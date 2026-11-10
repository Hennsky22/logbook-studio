<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ChecklistPemeriksaan;
use App\Models\ChecklistCrewHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MonitoringPublikController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR STUDIO
    |--------------------------------------------------------------------------
    */

    private const STUDIOS = [
        'master-control-room' => [
            'nama' => 'Studio Master Control Room',
            'aliases' => [
                'Studio Master Control Room',
                'Master Control Room',
                'MCR',
            ],
        ],

        'berita' => [
            'nama' => 'Studio Berita',
            'aliases' => [
                'Studio Berita',
                'Berita',
            ],
        ],

        'penyiaran' => [
            'nama' => 'Studio Penyiaran',
            'aliases' => [
                'Studio Penyiaran',
                'Penyiaran',
            ],
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | URUTAN UNIT KERJA SESUAI FORM CHECKLIST
    |--------------------------------------------------------------------------
    */

    private const URUTAN_CREW = [
        'PD',
        'TD',
        'Maintenance',
        'Master Control',
        'Recaller 1',
        'Recaller 2',
        'Ingest',
        'Running Text',
    ];

    /*
    |--------------------------------------------------------------------------
    | HALAMAN UTAMA MONITORING PUBLIK
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $tanggal = $this->validTanggal($request->input('tanggal'));

        $studioFilter = $request->input('studio');

        $cards = collect(self::STUDIOS)->map(
            function ($config, $slug) use ($tanggal) {

                $studio = $this->loadStudio($config, $tanggal);

                return [
                    'slug' => $slug,
                    'nama' => $config['nama'],

                    'items' => $studio['items'],

                    // Untuk preview crew di halaman utama
                    'crew' => $studio['crew']
                        ->pluck('nama_crew')
                        ->filter(fn ($nama) => $nama !== '-')
                        ->values(),

                    'petugas' => $studio['petugas'],

                    'total' => $studio['items']->count(),

                    'diperiksa' => $studio['diperiksa'],

                    'lengkap' => $studio['items']->count() > 0
                        && $studio['diperiksa'] >= $studio['items']->count(),
                ];
            }
        );

        if ($studioFilter && $cards->has($studioFilter)) {
            $cards = $cards->only([$studioFilter]);
        } else {
            $studioFilter = '';
        }

        return view('monitoring.index', [
            'tanggal' => $tanggal,
            'studioFilter' => $studioFilter,
            'cards' => $cards,
            'summary' => $this->summary($cards),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DATA REALTIME HALAMAN UTAMA
    |--------------------------------------------------------------------------
    */

    public function data(Request $request)
    {
        $tanggal = $this->validTanggal($request->input('tanggal'));

        $studioFilter = $request->input('studio');

        $cards = collect(self::STUDIOS)->map(
            function ($config, $slug) use ($tanggal) {

                $studio = $this->loadStudio($config, $tanggal);

                return [
                    'slug' => $slug,
                    'nama' => $config['nama'],

                    'crew' => $studio['crew']
                        ->pluck('nama_crew')
                        ->filter(fn ($nama) => $nama !== '-')
                        ->values(),

                    'petugas' => $studio['petugas'],

                    'total' => $studio['items']->count(),

                    'diperiksa' => $studio['diperiksa'],

                    'lengkap' => $studio['items']->count() > 0
                        && $studio['diperiksa'] >= $studio['items']->count(),

                    'items' => $studio['items']->map(
                        fn ($item) => [
                            'nama_barang' => $item->nama_barang,

                            'kondisi' => $item->monitoring_pemeriksaan?->kondisi,
                        ]
                    )->values(),
                ];
            }
        );

        if ($studioFilter && $cards->has($studioFilter)) {
            $cards = $cards->only([$studioFilter]);
        }

        return response()->json([
            'cards' => $cards->values(),

            'summary' => $this->summary($cards),

            'updated_at' => now('Asia/Jakarta')->format('H:i:s'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL STUDIO
    |--------------------------------------------------------------------------
    */

    public function detail(Request $request, string $studio)
    {
        abort_unless(isset(self::STUDIOS[$studio]), 404);

        $tanggal = $this->validTanggal($request->input('tanggal'));

        $config = self::STUDIOS[$studio];

        $data = $this->loadStudio($config, $tanggal);

        return view('monitoring.detail', [
            'tanggal' => $tanggal,

            'studioSlug' => $studio,

            'studioNama' => $config['nama'],

            // Berisi unit kerja dan nama crew
            'crew' => $data['crew'],

            'items' => $data['items'],

            'jumlahDiperiksa' => $data['diperiksa'],

            'totalBarang' => $data['items']->count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DATA REALTIME DETAIL STUDIO
    |--------------------------------------------------------------------------
    */

    public function detailData(Request $request, string $studio)
    {
        abort_unless(isset(self::STUDIOS[$studio]), 404);

        $tanggal = $this->validTanggal($request->input('tanggal'));

        $data = $this->loadStudio(
            self::STUDIOS[$studio],
            $tanggal
        );

        return response()->json([
            'crew' => $data['crew']->map(
                fn ($item) => [
                    'unit_kerja' => $item['unit_kerja'],

                    'nama_crew' => $item['nama_crew'],
                ]
            )->values(),

            'items' => $data['items']->map(
                fn ($item) => [
                    'nama_barang' => $item->nama_barang,

                    'kondisi' => $item->monitoring_pemeriksaan?->kondisi,

                    'petugas' => $item->monitoring_pemeriksaan?->user?->name,
                ]
            )->values(),

            'jumlah_diperiksa' => $data['diperiksa'],

            'total_barang' => $data['items']->count(),

            'updated_at' => now('Asia/Jakarta')->format('H:i:s'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MENGAMBIL DATA BARANG DAN CREW PER STUDIO
    |--------------------------------------------------------------------------
    */

    private function loadStudio(array $config, string $tanggal): array
    {
        $aliases = $this->studioAliases($config);

        /*
        |--------------------------------------------------------------------------
        | DATA BARANG
        |--------------------------------------------------------------------------
        */

        $items = Item::query()
            ->whereIn('studio', $aliases)
            ->orderBy('nama_barang')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA PEMERIKSAAN BARANG
        |--------------------------------------------------------------------------
        */

        $checks = ChecklistPemeriksaan::with('user')
            ->whereDate('tanggal_pemeriksaan', $tanggal)
            ->whereIn('item_id', $items->pluck('id'))
            ->orderByDesc('created_at')
            ->get()
            ->unique('item_id')
            ->keyBy('item_id');

        // Hubungkan data pemeriksaan dengan barang
        $items->each(function ($item) use ($checks) {

            $item->setAttribute(
                'monitoring_pemeriksaan',
                $checks->get($item->id)
            );

        });

        /*
        |--------------------------------------------------------------------------
        | DATA CREW
        |--------------------------------------------------------------------------
        |
        | nama_crew = Unit Kerja
        | keterangan = Nama Crew yang diinput
        |
        */

        $recordsCrew = ChecklistCrewHarian::query()
            ->whereDate('tanggal', $tanggal)
            ->whereIn('studio', $aliases)
            ->get()
            ->keyBy('nama_crew');

        // Urutkan berdasarkan formulir checklist
        $urutanCrew = array_flip(self::URUTAN_CREW);

        // Tampilkan semua unit kerja sesuai urutan
        $crew = collect(self::URUTAN_CREW)
            ->map(function ($unitKerja) use ($recordsCrew) {

                $record = $recordsCrew->get($unitKerja);

                return [
                    'unit_kerja' => $unitKerja,

                    'nama_crew' => trim((string) ($record?->keterangan ?? '')) !== ''
                        ? $record->keterangan
                        : '-',
                ];
            })
            ->sortBy(function ($item) use ($urutanCrew) {

                return $urutanCrew[$item['unit_kerja']] ?? 999;

            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | NAMA PETUGAS PEMERIKSA
        |--------------------------------------------------------------------------
        */

        $petugas = $checks
            ->map(fn ($check) => $check->user?->name)
            ->filter()
            ->unique()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | JUMLAH BARANG YANG SUDAH DIPERIKSA
        |--------------------------------------------------------------------------
        */

        $jumlahDiperiksa = $items->filter(
            fn ($item) => $item->monitoring_pemeriksaan !== null
        )->count();

        return [
            'items' => $items,

            'crew' => $crew,

            'petugas' => $petugas,

            'diperiksa' => $jumlahDiperiksa,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS NAMA STUDIO
    |--------------------------------------------------------------------------
    */

    private function studioAliases(array $config): Collection
    {
        $allNames = Item::query()
            ->whereNotNull('studio')
            ->pluck('studio')
            ->merge(
                ChecklistCrewHarian::query()
                    ->whereNotNull('studio')
                    ->pluck('studio')
            )
            ->filter()
            ->unique();

        $target = $this->normalisasiNamaStudio($config['nama']);

        $matched = $allNames->filter(
            fn ($name) =>
                $this->normalisasiNamaStudio((string) $name) === $target
        );

        return $matched
            ->merge($config['aliases'])
            ->unique()
            ->values();
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALISASI NAMA STUDIO
    |--------------------------------------------------------------------------
    */

    private function normalisasiNamaStudio(string $nama): string
    {
        $nama = strtolower(
            trim(
                preg_replace('/\s+/', ' ', $nama)
            )
        );

        if (
            str_contains($nama, 'master control')
            || $nama === 'mcr'
        ) {
            return 'Studio Master Control Room';
        }

        if (str_contains($nama, 'berita')) {
            return 'Studio Berita';
        }

        if (str_contains($nama, 'penyiar')) {
            return 'Studio Penyiaran';
        }

        return trim($nama);
    }

    /*
    |--------------------------------------------------------------------------
    | RINGKASAN KONDISI BARANG
    |--------------------------------------------------------------------------
    */

    private function summary(Collection $cards): array
    {
        $allItems = $cards->flatMap(
            fn ($card) => $card['items']
        );

        $baik = $allItems->filter(
            fn ($item) =>
                strtolower(
                    (string) $item->monitoring_pemeriksaan?->kondisi
                ) === 'baik'
        )->count();

        $error = $allItems->filter(
            fn ($item) =>
                strtolower(
                    (string) $item->monitoring_pemeriksaan?->kondisi
                ) === 'error'
        )->count();

        $rusak = $allItems->filter(
            fn ($item) =>
                strtolower(
                    (string) $item->monitoring_pemeriksaan?->kondisi
                ) === 'rusak'
        )->count();

        $total = $allItems->count();

        $checked = $allItems->filter(
            fn ($item) =>
                $item->monitoring_pemeriksaan !== null
        )->count();

        return [
            'total' => $total,

            'baik' => $baik,

            'error' => $error,

            'rusak' => $rusak,

            'belum' => max(0, $total - $checked),

            'operasional' => $rusak > 0
                ? 'PERLU PERHATIAN'
                : ($error > 0 ? 'WASPADA' : 'NORMAL'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI TANGGAL
    |--------------------------------------------------------------------------
    */

    private function validTanggal(?string $tanggal): string
    {
        if (
            $tanggal
            && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)
            && strtotime($tanggal) !== false
        ) {
            return $tanggal;
        }

        return now('Asia/Jakarta')->toDateString();
    }
}