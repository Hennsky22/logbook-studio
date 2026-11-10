<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\ChecklistPemeriksaan;
use App\Models\ChecklistKeteranganHarian;
use App\Models\ChecklistCrewHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    /**
     * Dashboard dan daftar logbook berdasarkan studio.
     */
    public function index(Request $request)
    {
        $hariIni = now()->toDateString();

        $totalLogbook = Logbook::whereDate('tanggal', $hariIni)->count();

        $studioBerita = Logbook::where('studio', 'berita')
            ->whereDate('tanggal', $hariIni)
            ->count();

        $studioPenyiaran = Logbook::where('studio', 'penyiaran')
            ->whereDate('tanggal', $hariIni)
            ->count();

        $studioMcr = Logbook::where('studio', 'mcr')
            ->whereDate('tanggal', $hariIni)
            ->count();

        $pilihanStudio = [
            'berita' => 'berita',
            'penyiaran' => 'penyiaran',
            'mcr' => 'mcr',
            'Studio Berita' => 'berita',
            'Studio Penyiaran' => 'penyiaran',
            'Master Control Room' => 'mcr',
        ];

        $studioDipilih = $request->query('studio');
        $kodeStudio = $pilihanStudio[$studioDipilih] ?? null;

        $query = Logbook::whereDate('tanggal', $hariIni);

        if ($kodeStudio !== null) {
            $query->where('studio', $kodeStudio);
        }

        $logbooks = $query
            ->orderByDesc('jam_mulai')
            ->get();

        $namaStudio = match ($kodeStudio) {
            'berita' => 'Studio Berita',
            'penyiaran' => 'Studio Penyiaran',
            'mcr' => 'Master Control Room',
            default => 'Dashboard',
        };

        return view('logbooks.home', compact(
            'logbooks',
            'totalLogbook',
            'studioBerita',
            'studioPenyiaran',
            'studioMcr',
            'kodeStudio',
            'namaStudio',
            'hariIni'
        ));
    }

    /**
     * Halaman laporan logbook dan pemeriksaan kondisi barang.
     */
    public function reports(Request $request)
    {
        $studioMap = [
            'berita' => 'Studio Berita',
            'Studio Berita' => 'Studio Berita',
            'penyiaran' => 'Studio Penyiaran',
            'Studio Penyiaran' => 'Studio Penyiaran',
            'mcr' => 'Studio Master Control Room',
            'Master Control Room' => 'Studio Master Control Room',
            'Studio Master Control Room' => 'Studio Master Control Room',
        ];

        $studioInput = $request->query('studio');
        $studioBarang = $studioMap[$studioInput] ?? null;

        /*
        |--------------------------------------------------------------------------
        | LAPORAN LOGBOOK AKTIVITAS
        |--------------------------------------------------------------------------
        */

        $query = Logbook::query();

        if ($request->filled('studio')) {
            $kodeStudio = [
                'berita' => 'berita',
                'Studio Berita' => 'berita',
                'penyiaran' => 'penyiaran',
                'Studio Penyiaran' => 'penyiaran',
                'mcr' => 'mcr',
                'Master Control Room' => 'mcr',
                'Studio Master Control Room' => 'mcr',
            ][$studioInput] ?? null;

            if ($kodeStudio) {
                $query->where('studio', $kodeStudio);
            }
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_akhir
            );
        }

        /*
        |--------------------------------------------------------------------------
        | LAPORAN PERSONEL UNIT KERJA
        |--------------------------------------------------------------------------
        */

        $crewQuery = ChecklistCrewHarian::query();

        if ($studioBarang) {
            $crewQuery->where('studio', $studioBarang);
        }

        if ($request->filled('tanggal_mulai')) {
            $crewQuery->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $crewQuery->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $personelUnitKerja = $crewQuery
            ->orderByDesc('tanggal')
            ->orderBy('studio')
            ->orderBy('nama_crew')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | LAPORAN PENYELESAIAN CHECKLIST
        |--------------------------------------------------------------------------
        | Nama kepala studio diambil dari akun yang melakukan Simpan Semua.
        */

        $laporanSubmitQuery = ChecklistKeteranganHarian::query()
            ->leftJoin(
                'users',
                'checklist_keterangan_harians.user_id',
                '=',
                'users.id'
            )
            ->select(
                'checklist_keterangan_harians.*',
                'users.name as nama_kepala_studio'
            )
            ->whereNotNull('checklist_keterangan_harians.waktu_submit');

        if ($studioBarang) {
            $laporanSubmitQuery->where(
                'checklist_keterangan_harians.studio',
                $studioBarang
            );
        }

        if ($request->filled('tanggal_mulai')) {
            $laporanSubmitQuery->whereDate(
                'checklist_keterangan_harians.tanggal',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_akhir')) {
            $laporanSubmitQuery->whereDate(
                'checklist_keterangan_harians.tanggal',
                '<=',
                $request->tanggal_akhir
            );
        }

        $laporanPenyelesaian = $laporanSubmitQuery
            ->orderByDesc('checklist_keterangan_harians.tanggal')
            ->orderBy('checklist_keterangan_harians.studio')
            ->get();

        $logbooks = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('jam_mulai')
            ->get();

        $totalLogbook = $logbooks->count();

        $totalNormal = $logbooks
            ->where('kondisi_akhir', 'Normal')
            ->count();

        $totalPerluPerbaikan = $logbooks
            ->where('kondisi_akhir', 'Perlu Perbaikan')
            ->count();

        $totalBelumSelesai = $logbooks
            ->where('kondisi_akhir', 'Belum Selesai')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | LAPORAN CHECKLIST KONDISI BARANG
        |--------------------------------------------------------------------------
        */

        $checklistQuery = ChecklistPemeriksaan::with([
            'item',
            'user',
        ]);

        if ($studioBarang) {
            $checklistQuery->whereHas('item', function ($q) use ($studioBarang) {
                $q->where('studio', $studioBarang);
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $checklistQuery->whereDate(
                'tanggal_pemeriksaan',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_akhir')) {
            $checklistQuery->whereDate(
                'tanggal_pemeriksaan',
                '<=',
                $request->tanggal_akhir
            );
        }

        $pemeriksaan = $checklistQuery
            ->orderByDesc('tanggal_pemeriksaan')
            ->orderBy('item_id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MENGAMBIL KETERANGAN DAN FOTO TANDA TANGAN HARIAN
        |--------------------------------------------------------------------------
        */

        $daftarStudio = $pemeriksaan
            ->filter(fn ($row) => $row->item !== null)
            ->map(fn ($row) => $row->item->studio)
            ->unique()
            ->values();

        $keteranganQuery = ChecklistKeteranganHarian::with('user');

        if ($studioBarang) {
            $keteranganQuery->where('studio', $studioBarang);
        }

        if ($request->filled('tanggal_mulai')) {
            $keteranganQuery->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_akhir')) {
            $keteranganQuery->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_akhir
            );
        }

        $dataKeterangan = $keteranganQuery
            ->orderByDesc('tanggal')
            ->orderBy('studio')
            ->get();

        // Data keterangan umum ditampilkan pada tabel tersendiri di halaman Admin.
        $laporanKeteranganHarian = $dataKeterangan
            ->filter(function ($data) {
                return !empty(trim((string) $data->keterangan));
            })
            ->values();

        /*
         * Membuat indeks berdasarkan studio dan tanggal.
         */
        $keteranganMap = $dataKeterangan->keyBy(function ($data) {
            return $data->studio . '|' .
                $data->tanggal->format('Y-m-d');
        });

        /*
         * Menggabungkan keterangan dan foto ke data pemeriksaan.
         */
        $pemeriksaan->each(function ($row) use ($keteranganMap) {

            $studio = $row->item?->studio;

            $tanggal = $row->tanggal_pemeriksaan
                ? $row->tanggal_pemeriksaan->format('Y-m-d')
                : null;

            $key = $studio . '|' . $tanggal;

            $keteranganHarian = $keteranganMap->get($key);

            $row->keterangan_harian = $keteranganHarian?->keterangan;

            $row->foto_tanda_tangan = $keteranganHarian?->foto_tanda_tangan;

        });

        /*
        |--------------------------------------------------------------------------
        | REKAPITULASI PEMERIKSAAN
        |--------------------------------------------------------------------------
        */

        $totalPemeriksaan = $pemeriksaan->count();

        $totalKondisiBaik = $pemeriksaan
            ->where('kondisi', 'Baik')
            ->count();

        $totalKondisiRusak = $pemeriksaan
            ->where('kondisi', 'Rusak')
            ->count();

        return view('reports.index', compact(
            'logbooks',
            'totalLogbook',
            'totalNormal',
            'totalPerluPerbaikan',
            'totalBelumSelesai',
            'pemeriksaan',
            'totalPemeriksaan',
            'totalKondisiBaik',
            'totalKondisiRusak',
            'personelUnitKerja',
            'laporanPenyelesaian',
            'laporanKeteranganHarian'
        ));
    }

    /**
     * Form tambah logbook.
     */
    public function create()
    {
        return view('logbooks.create');
    }

    /**
     * Simpan logbook baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'studio' => ['required', 'in:berita,penyiaran,mcr'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required'],
            'jenis_kegiatan' => ['required', 'string'],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'uraian_kegiatan' => ['required', 'string'],
            'petugas' => ['required', 'string', 'max:255'],
            'kendala' => ['nullable', 'string'],
            'penyebab' => ['nullable', 'string'],
            'penanganan' => ['nullable', 'string'],
            'kondisi_akhir' => ['nullable', 'string'],
            'nama_pelapor' => ['nullable', 'string', 'max:255'],
        ]);

        $data['user_id'] = Auth::id();

        Logbook::create($data);

        return redirect('/logbooks')
            ->with('success', 'Logbook berhasil disimpan!');
    }
}
