<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PemeliharaanController extends Controller
{
    /**
     * Menampilkan daftar pemeliharaan.
     */
    
public function index(Request $request)
{
    $query = Pemeliharaan::with('item');

    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('kerusakan', 'like', '%' . $search . '%')
                ->orWhere('penanganan', 'like', '%' . $search . '%')
                ->orWhereHas('item', function ($itemQuery) use ($search) {
                    $itemQuery->where(
                        'nama_barang',
                        'like',
                        '%' . $search . '%'
                    );
                });
        });
    }

    $pemeliharaans = $query->latest()->get();

    return view(
        'management.maintenance',
        compact('pemeliharaans')
    );
}


    /**
     * Menampilkan form tambah pemeliharaan.
     */
    public function create()
    {
        $items = Item::orderBy('nama_barang')->get();

        return view('management.create-maintenance', compact('items'));
    }

    /**
     * Menyimpan data pemeliharaan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal_rusak' => 'required|date',
            'tanggal_perbaikan' => 'nullable|date|after_or_equal:tanggal_rusak',
            'kerusakan' => 'required|string|max:5000',
            'penanganan' => 'nullable|string|max:5000',
            'foto_awal' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fotoAwal = null;
        $fotoSesudah = null;

        try {
            if ($request->hasFile('foto_awal')) {
                $fotoAwal = $request->file('foto_awal')
                    ->store('pemeliharaan', 'public');
            }

            if ($request->hasFile('foto_sesudah')) {
                $fotoSesudah = $request->file('foto_sesudah')
                    ->store('pemeliharaan', 'public');
            }

            Pemeliharaan::create([
                'item_id' => $validated['item_id'],
                'tanggal_rusak' => $validated['tanggal_rusak'],
                'tanggal_perbaikan' => $validated['tanggal_perbaikan'] ?? null,
                'kerusakan' => $validated['kerusakan'],
                'penanganan' => $validated['penanganan'] ?? null,
                'foto_awal' => $fotoAwal,
                'foto_sesudah' => $fotoSesudah,
                'status' => !empty($validated['tanggal_perbaikan'])
                    ? 'Selesai'
                    : 'Menunggu Perbaikan',
            ]);
        } catch (\Throwable $e) {
            if ($fotoAwal) {
                Storage::disk('public')->delete($fotoAwal);
            }

            if ($fotoSesudah) {
                Storage::disk('public')->delete($fotoSesudah);
            }

            throw $e;
        }

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Data pemeliharaan berhasil disimpan.');
    }

    /**
     * Menampilkan detail satu data pemeliharaan.
     */
    public function show(Pemeliharaan $pemeliharaan)
    {
        $pemeliharaan->load('item');

        return view(
            'management.show-maintenance',
            compact('pemeliharaan')
        );
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Pemeliharaan $pemeliharaan)
    {
        $items = Item::orderBy('nama_barang')->get();

        return view(
            'management.edit-maintenance',
            compact('pemeliharaan', 'items')
        );
    }

    /**
     * Memperbarui data pemeliharaan.
     */
    public function update(Request $request, Pemeliharaan $pemeliharaan)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal_rusak' => 'required|date',
            'tanggal_perbaikan' => 'nullable|date|after_or_equal:tanggal_rusak',
            'kerusakan' => 'required|string|max:5000',
            'penanganan' => 'nullable|string|max:5000',
            'foto_awal' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fotoAwalLama = $pemeliharaan->foto_awal;
        $fotoSesudahLama = $pemeliharaan->foto_sesudah;

        $fotoAwalBaru = null;
        $fotoSesudahBaru = null;

        try {
            if ($request->hasFile('foto_awal')) {
                $fotoAwalBaru = $request->file('foto_awal')
                    ->store('pemeliharaan', 'public');

                $validated['foto_awal'] = $fotoAwalBaru;
            }

            if ($request->hasFile('foto_sesudah')) {
                $fotoSesudahBaru = $request->file('foto_sesudah')
                    ->store('pemeliharaan', 'public');

                $validated['foto_sesudah'] = $fotoSesudahBaru;
            }

            $validated['status'] = !empty($validated['tanggal_perbaikan'])
                ? 'Selesai'
                : 'Menunggu Perbaikan';

            $pemeliharaan->update($validated);
        } catch (\Throwable $e) {
            if ($fotoAwalBaru) {
                Storage::disk('public')->delete($fotoAwalBaru);
            }

            if ($fotoSesudahBaru) {
                Storage::disk('public')->delete($fotoSesudahBaru);
            }

            throw $e;
        }

        // Hapus foto lama hanya jika foto baru berhasil disimpan.
        if ($fotoAwalBaru && $fotoAwalLama) {
            Storage::disk('public')->delete($fotoAwalLama);
        }

        if ($fotoSesudahBaru && $fotoSesudahLama) {
            Storage::disk('public')->delete($fotoSesudahLama);
        }

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Data pemeliharaan berhasil diperbarui.');
    }

    /**
     * Menghapus data pemeliharaan.
     */
    public function destroy(Pemeliharaan $pemeliharaan)
    {
        $fotoAwal = $pemeliharaan->foto_awal;
        $fotoSesudah = $pemeliharaan->foto_sesudah;

        $pemeliharaan->delete();

        // Hapus file hanya jika tidak digunakan catatan lain.
        $fotoMasihDigunakan = Pemeliharaan::where(function ($query) use ($fotoAwal, $fotoSesudah) {
            $query->where(function ($q) use ($fotoAwal) {
                if ($fotoAwal) {
                    $q->where('foto_awal', $fotoAwal)
                      ->orWhere('foto_sesudah', $fotoAwal);
                } else {
                    $q->whereRaw('1 = 0');
                }
            });

            if ($fotoSesudah) {
                $query->orWhere('foto_awal', $fotoSesudah)
                      ->orWhere('foto_sesudah', $fotoSesudah);
            }
        })->exists();

        if ($fotoAwal && !$fotoMasihDigunakan) {
            Storage::disk('public')->delete($fotoAwal);
        }

        if ($fotoSesudah && $fotoSesudah !== $fotoAwal && !$fotoMasihDigunakan) {
            Storage::disk('public')->delete($fotoSesudah);
        }

        return redirect()
            ->route('maintenance.index')
            ->with('success', 'Data pemeliharaan berhasil dihapus.');
    }
}
