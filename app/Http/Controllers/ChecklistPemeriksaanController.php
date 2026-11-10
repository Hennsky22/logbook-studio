<?php

namespace App\Http\Controllers;

use App\Models\ChecklistPemeriksaan;
use App\Models\ChecklistKeteranganHarian;
use App\Models\ChecklistCrewHarian;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ChecklistPemeriksaanController extends Controller
{
    private const STUDIOS = [
        'Studio Master Control Room',
        'Studio Berita',
        'Studio Penyiaran',
    ];

    private const CREW = [
        'PD',
        'TD',
        'Maintenance',
        'Master Control',
        'Recaller 1',
        'Recaller 2',
        'Ingest',
        'Running Text',
    ];

    /** Menampilkan checklist harian. */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'studio' => ['required', 'string', Rule::in(self::STUDIOS)],
        ]);

        $studio = $validated['studio'];
        $tanggal = now('Asia/Jakarta')->toDateString();

        $items = Item::where('studio', $studio)
            ->orderBy('nama_barang')
            ->get();

        $pemeriksaan = ChecklistPemeriksaan::whereDate('tanggal_pemeriksaan', $tanggal)
            ->whereIn('item_id', $items->pluck('id'))
            ->get()
            ->keyBy('item_id');

        $keteranganHarian = ChecklistKeteranganHarian::where('studio', $studio)
            ->whereDate('tanggal', $tanggal)
            ->first();

        $crewRecords = ChecklistCrewHarian::where('studio', $studio)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('nama_crew');

        return view('dashboard.checklist', compact(
            'tanggal',
            'studio',
            'items',
            'pemeriksaan',
            'keteranganHarian',
            'crewRecords'
        ))->with('crewList', self::CREW);
    }

    /** Menyimpan kondisi satu barang. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'studio' => ['required', 'string', Rule::in(self::STUDIOS)],
            'item_id' => [
                'required',
                'integer',
                Rule::exists('items', 'id')->where('studio', $request->input('studio')),
            ],
            'kondisi' => ['required', Rule::in(['Baik', 'Error', 'Rusak'])],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $tanggal = now('Asia/Jakarta')->toDateString();
        $studio = $validated['studio'];

        DB::transaction(function () use ($validated, $tanggal, $studio) {
            ChecklistPemeriksaan::updateOrCreate(
                [
                    'item_id' => $validated['item_id'],
                    'tanggal_pemeriksaan' => $tanggal,
                ],
                [
                    'user_id' => Auth::id(),
                    'kondisi' => $validated['kondisi'],
                    'catatan' => $validated['catatan'] ?? null,
                ]
            );

            Item::where('id', $validated['item_id'])
                ->where('studio', $studio)
                ->update(['kondisi_barang' => $validated['kondisi']]);
        });

        return redirect()
            ->route('dashboard.checklist', ['studio' => $studio])
            ->with('success', 'Pemeriksaan barang berhasil disimpan.');
    }

    /** Menyimpan nama crew per unit kerja. Input akan kosong setelah redirect berhasil. */
    public function storeCrew(Request $request)
    {
        $validated = $request->validate([
            'studio' => ['required', 'string', Rule::in(self::STUDIOS)],
            'crew' => ['required', 'array'],
            'crew.*' => ['nullable', 'string', 'max:1000'],
        ]);

        $studio = $validated['studio'];
        $tanggal = now('Asia/Jakarta')->toDateString();

        DB::transaction(function () use ($validated, $studio, $tanggal) {
            foreach ($validated['crew'] as $namaCrew => $namaPetugas) {
                if (!in_array($namaCrew, self::CREW, true)) {
                    abort(422, 'Nama unit kerja tidak valid.');
                }

                ChecklistCrewHarian::updateOrCreate(
                    [
                        'studio' => $studio,
                        'tanggal' => $tanggal,
                        'nama_crew' => $namaCrew,
                    ],
                    [
                        'user_id' => Auth::id(),
                        'keterangan' => $namaPetugas,
                    ]
                );
            }
        });

        return redirect()
            ->route('dashboard.checklist', ['studio' => $studio])
            ->with('success', 'Personel Unit Kerja berhasil disimpan.');
    }

    /** Menyimpan keterangan harian dan foto tanda tangan studio pada tanggal berjalan. */
    public function storeKeterangan(Request $request)
    {
        $validated = $request->validate([
            'studio' => ['required', 'string', Rule::in(self::STUDIOS)],
            'keterangan' => ['nullable', 'string', 'max:5000'],
            'foto_tanda_tangan' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $studio = $validated['studio'];
        $tanggal = now('Asia/Jakarta')->toDateString();

        $dataLama = ChecklistKeteranganHarian::where('studio', $studio)
            ->whereDate('tanggal', $tanggal)
            ->first();

        $fotoLama = $dataLama?->foto_tanda_tangan;
        $fotoBaru = $fotoLama;

        if ($request->hasFile('foto_tanda_tangan')) {
            $fotoBaru = $request->file('foto_tanda_tangan')->store('tanda-tangan', 'public');
        }

        ChecklistKeteranganHarian::updateOrCreate(
            [
                'studio' => $studio,
                'tanggal' => $tanggal,
            ],
            [
                'user_id' => Auth::id(),
                'keterangan' => $validated['keterangan'] ?? null,
                'foto_tanda_tangan' => $fotoBaru,
            ]
        );

        if ($fotoLama && $fotoBaru !== $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()
            ->route('dashboard.checklist', ['studio' => $studio])
            ->with('success', 'Keterangan dan tanda tangan berhasil disimpan.');
    }

    /** Menampilkan riwayat pemeriksaan barang. */
    public function history(Request $request)
    {
        $validated = $request->validate([
            'studio' => ['required', 'string', Rule::in(self::STUDIOS)],
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
        ]);

        $studio = $validated['studio'];
        $tanggal = $validated['tanggal'] ?? null;

        $query = ChecklistPemeriksaan::with(['item', 'user'])
            ->whereHas('item', function ($query) use ($studio) {
                $query->where('studio', $studio);
            })
            ->orderByDesc('tanggal_pemeriksaan')
            ->orderBy('item_id');

        if ($tanggal) {
            $query->whereDate('tanggal_pemeriksaan', $tanggal);
        }

        $riwayat = $query->paginate(15)->withQueryString();

        return view('dashboard.history', compact('riwayat', 'tanggal', 'studio'));
    }

    /** Menyimpan personel, seluruh kondisi peralatan, keterangan, dan foto sekaligus. */
    public function storeAll(Request $request)
    {
        $validated = $request->validate([
            'studio' => ['required', 'string', Rule::in(self::STUDIOS)],
            'crew' => ['required', 'array'],
            'crew.*' => ['nullable', 'string', 'max:1000'],
            'pemeriksaan' => ['nullable', 'array'],
            'pemeriksaan.*' => ['array'],
            'pemeriksaan.*.kondisi' => ['nullable', Rule::in(['Baik', 'Error', 'Rusak'])],
            'pemeriksaan.*.catatan' => ['nullable', 'string', 'max:1000'],
            'keterangan' => ['nullable', 'string', 'max:5000'],
            'foto_tanda_tangan' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $studio = $validated['studio'];
        $tanggal = now('Asia/Jakarta')->toDateString();
        $daftarPemeriksaan = $validated['pemeriksaan'] ?? [];

        // Pastikan semua ID peralatan berasal dari studio yang sedang dibuka.
        $itemIds = array_map('intval', array_keys($daftarPemeriksaan));
        $itemIdsValid = Item::where('studio', $studio)
            ->whereIn('id', $itemIds)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        if (count($itemIdsValid) !== count(array_unique($itemIds))) {
            return back()
                ->withErrors(['pemeriksaan' => 'Ada data peralatan yang tidak sesuai dengan studio ini.'])
                ->withInput();
        }

        $dataLama = ChecklistKeteranganHarian::where('studio', $studio)
            ->whereDate('tanggal', $tanggal)
            ->first();

        $fotoLama = $dataLama?->foto_tanda_tangan;
        $fotoBaru = $fotoLama;

        if ($request->hasFile('foto_tanda_tangan')) {
            $fotoBaru = $request->file('foto_tanda_tangan')->store('tanda-tangan', 'public');
        }

        try {
            DB::transaction(function () use (
                $validated,
                $studio,
                $tanggal,
                $fotoBaru,
                $daftarPemeriksaan
            ) {
                foreach ($validated['crew'] as $namaUnit => $namaCrew) {
                    if (!in_array($namaUnit, self::CREW, true)) {
                        abort(422, 'Nama unit kerja tidak valid.');
                    }

                    ChecklistCrewHarian::updateOrCreate(
                        [
                            'studio' => $studio,
                            'tanggal' => $tanggal,
                            'nama_crew' => $namaUnit,
                        ],
                        [
                            'user_id' => Auth::id(),
                            'keterangan' => $namaCrew,
                        ]
                    );
                }

                foreach ($daftarPemeriksaan as $itemId => $data) {
                    $itemId = (int) $itemId;
                    $kondisiBaru = $data['kondisi'] ?? null;
                    $catatanBaru = $data['catatan'] ?? null;

                    $recordLama = ChecklistPemeriksaan::where('item_id', $itemId)
                        ->whereDate('tanggal_pemeriksaan', $tanggal)
                        ->first();

                    // Baris tanpa kondisi baru tidak membuat record kosong.
                    // Jika sudah pernah diperiksa hari ini, catatannya tetap bisa diperbarui.
                    if (!$kondisiBaru && !$recordLama) {
                        continue;
                    }

                    $kondisiSimpan = $kondisiBaru ?: $recordLama->kondisi;

                    ChecklistPemeriksaan::updateOrCreate(
                        [
                            'item_id' => $itemId,
                            'tanggal_pemeriksaan' => $tanggal,
                        ],
                        [
                            'user_id' => Auth::id(),
                            'kondisi' => $kondisiSimpan,
                            'catatan' => $catatanBaru,
                        ]
                    );

                    if ($kondisiBaru) {
                        Item::where('id', $itemId)
                            ->where('studio', $studio)
                            ->update(['kondisi_barang' => $kondisiBaru]);
                    }
                }

                ChecklistKeteranganHarian::updateOrCreate(
                    [
                        'studio' => $studio,
                        'tanggal' => $tanggal,
                    ],
                    [
                        'user_id' => Auth::id(),
                        'keterangan' => $validated['keterangan'] ?? null,
                        'foto_tanda_tangan' => $fotoBaru,
                        'waktu_submit' => now('Asia/Jakarta'),
                    ]
                );
            });
        } catch (\Throwable $exception) {
            // Jika penyimpanan gagal setelah foto diunggah, jangan biarkan file yatim.
            if ($fotoBaru && $fotoBaru !== $fotoLama) {
                Storage::disk('public')->delete($fotoBaru);
            }

            throw $exception;
        }

        if ($fotoLama && $fotoBaru !== $fotoLama) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()
            ->route('dashboard.checklist', ['studio' => $studio])
            ->with('success', 'Seluruh pemeriksaan berhasil disimpan.');
    }
}
