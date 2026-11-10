<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Item;
use App\Models\Logbook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
{
    $peminjamans = Peminjaman::with([
        'logbook',
        'item',
        'petugas',
    ])->latest()->get();

    return view('management.loans', compact('peminjamans'));
}

    public function create()
    {
        $logbooks = Logbook::latest()->get();

        $items = Item::where('status_barang', 'Tersedia')
            ->orderBy('nama_barang')
            ->get();

        $petugas = User::orderBy('name')->get();

        return view('management.create-loan', compact(
            'logbooks',
            'items',
            'petugas'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logbook_id' => 'required|exists:logbooks,id',
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_rencana_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
        ]);

        DB::transaction(function () use ($validated) {
            $item = Item::whereKey($validated['item_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($item->status_barang !== 'Tersedia') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'item_id' => 'Barang ini sudah tidak tersedia untuk dipinjam.',
                ]);
            }

            Peminjaman::create([
                'logbook_id' => $validated['logbook_id'],
                'item_id' => $item->id,
                'user_id' => $validated['user_id'],
                'kondisi_awal' => $item->kondisi_barang,
                'kondisi_kembali' => null,
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_rencana_kembali' => $validated['tanggal_rencana_kembali'] ?? null,
                'tanggal_kembali' => null,
                'status' => 'Dipinjam',
            ]);

            $item->update([
                'status_barang' => 'Dipinjam',
            ]);
        });

        return redirect()
            ->route('loans.index')
            ->with('success', 'Peminjaman barang berhasil ditambahkan.');
        }

        
public function returnItem(Peminjaman $peminjaman)
{
    DB::transaction(function () use ($peminjaman) {
        $peminjaman = Peminjaman::whereKey($peminjaman->id)
            ->lockForUpdate()
            ->firstOrFail();

        if (strtolower($peminjaman->status ?? '') === 'dikembalikan') {
            return;
        }

        $item = Item::whereKey($peminjaman->item_id)
            ->lockForUpdate()
            ->firstOrFail();

        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        $item->update([
            'status_barang' => 'Tersedia',
        ]);
    });

    return redirect()
        ->route('loans.index')
        ->with('success', 'Pengembalian barang berhasil dicatat.');
    }



public function show(Peminjaman $peminjaman)
{
    $peminjaman->load([
        'logbook',
        'item',
        'petugas',
    ]);

    return view('management.show-loan', compact('peminjaman'));
}

}