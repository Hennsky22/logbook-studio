<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ChecklistPemeriksaan;
use App\Models\ChecklistKeteranganHarian;
use App\Models\ChecklistCrewHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.user');
    }

    public function inventory()
    {
        $items = Item::where('studio', 'Studio Master Control Room')
            ->orderBy('nama_barang')->get();

        return view('dashboard.inventory', compact('items'));
    }

    /** Dashboard monitoring laporan harian seluruh studio. */
    public function monitoring(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_akhir' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'studio' => ['nullable', 'in:semua,Studio Master Control Room,Studio Berita,Studio Penyiaran'],
        ]);

        $today = now('Asia/Jakarta')->toDateString();
        $tanggalMulai = $request->input('tanggal_mulai', $today);
        $tanggalAkhir = $request->input('tanggal_akhir', $today);
        $studioDipilih = $request->input('studio', 'semua');

        $studios = [
            'Studio Master Control Room',
            'Studio Berita',
            'Studio Penyiaran',
        ];
        $studioAktif = $studioDipilih === 'semua' ? $studios : [$studioDipilih];

        $laporan = ChecklistKeteranganHarian::with('user')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->whereIn('studio', $studioAktif)
            ->orderByDesc('tanggal')->orderBy('studio')->get()
            ->keyBy(fn ($row) => $row->studio . '|' . $row->tanggal->format('Y-m-d'));

        $items = Item::whereIn('studio', $studioAktif)->get()->groupBy('studio');

        $pemeriksaan = ChecklistPemeriksaan::with(['item', 'user'])
            ->whereBetween('tanggal_pemeriksaan', [$tanggalMulai, $tanggalAkhir])
            ->whereHas('item', fn ($q) => $q->whereIn('studio', $studioAktif))
            ->orderByDesc('tanggal_pemeriksaan')->get();

        $crew = ChecklistCrewHarian::with('user')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->whereIn('studio', $studioAktif)
            ->orderBy('studio')->orderBy('nama_crew')->get();

        $tanggalList = [];
        $start = Carbon::parse($tanggalMulai);
        $end = Carbon::parse($tanggalAkhir);
        // Batasi rentang tampilan agar halaman tidak membuat ribuan baris.
        if ($start->diffInDays($end) > 90) {
            return back()->withErrors(['tanggal_akhir' => 'Rentang monitoring maksimal 90 hari.'])->withInput();
        }
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $tanggalList[] = $date->toDateString();
        }

        $rows = collect();
        foreach ($tanggalList as $tanggal) {
            foreach ($studioAktif as $studio) {
                $key = $studio . '|' . $tanggal;
                $note = $laporan->get($key);
                $studioChecks = $pemeriksaan->filter(function ($row) use ($studio, $tanggal) {
                    return $row->item && $row->item->studio === $studio
                        && $row->tanggal_pemeriksaan->format('Y-m-d') === $tanggal;
                });
                $totalBarang = ($items->get($studio) ?? collect())->count();
                $baik = $studioChecks->where('kondisi', 'Baik')->count();
                $error = $studioChecks->where('kondisi', 'Error')->count();
                $rusak = $studioChecks->where('kondisi', 'Rusak')->count();
                $sudahSubmit = $note !== null;
                $status = !$sudahSubmit ? 'Belum Mengisi' : (($error + $rusak) > 0 ? 'Perlu Perhatian' : 'Sudah Mengisi');

                $rows->push((object) [
                    'tanggal' => $tanggal,
                    'studio' => $studio,
                    'note' => $note,
                    'petugas' => $note?->user?->name ?? ($studioChecks->first()?->user?->name),
                    'waktu_submit' => $note?->waktu_submit ?? $note?->updated_at,
                    'total_barang' => $totalBarang,
                    'diperiksa' => $studioChecks->count(),
                    'baik' => $baik,
                    'error' => $error,
                    'rusak' => $rusak,
                    'status' => $status,
                    'pemeriksaan' => $studioChecks->values(),
                    'personel' => $crew->filter(fn ($c) => $c->studio === $studio && $c->tanggal->format('Y-m-d') === $tanggal)->values(),
                ]);
            }
        }

        $totalLaporan = $rows->count();
        $sudahMengisi = $rows->where('status', 'Sudah Mengisi')->count();
        $belumMengisi = $rows->where('status', 'Belum Mengisi')->count();
        $perluPerhatian = $rows->where('status', 'Perlu Perhatian')->count();
        $totalBaik = $rows->sum('baik');
        $totalError = $rows->sum('error');
        $totalRusak = $rows->sum('rusak');

        return view('dashboard.monitoring', compact(
            'rows', 'studios', 'studioDipilih', 'tanggalMulai', 'tanggalAkhir',
            'totalLaporan', 'sudahMengisi', 'belumMengisi', 'perluPerhatian',
            'totalBaik', 'totalError', 'totalRusak'
        ));
    }
}
