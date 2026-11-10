<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pemeliharaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ManagementController extends Controller
{
    /**
     * Nilai studio yang disimpan di database.
     */
    private const STUDIO_MAP = [
        'Master Control Room' => 'Studio Master Control Room',
        'Studio Master Control Room' => 'Studio Master Control Room',
        'Studio Berita' => 'Studio Berita',
        'Studio Penyiaran' => 'Studio Penyiaran',
    ];

    /**
     * Menentukan studio yang sedang dibuka.
     */
    private function resolveStudio(?string $studio): string
    {
        return self::STUDIO_MAP[$studio ?? 'Master Control Room']
            ?? self::STUDIO_MAP['Master Control Room'];
    }

    /**
     * Nama studio untuk ditampilkan di halaman.
     */
    private function studioLabel(string $studio): string
    {
        return $studio === 'Studio Master Control Room'
            ? 'Master Control Room'
            : $studio;
    }

    /**
     * Mengembalikan pengguna ke halaman inventaris studio terkait.
     */
    private function studioRedirect(string $studio)
    {
        return redirect()->route('items.index', [
            'studio' => $this->studioLabel($studio),
        ]);
    }

    /**
     * Halaman pemeliharaan.
     */
    public function index()
    {
        $pemeliharaans = Pemeliharaan::with('item')
            ->latest()
            ->get();

        return view('management.maintenance', compact('pemeliharaans'));
    }

    /**
     * Halaman peminjaman.
     */
    public function loans()
    {
        return view('management.loans');
    }

    /**
     * Halaman pemeliharaan.
     */
    public function maintenance()
    {
        return view('management.maintenance');
    }

    /**
     * Menampilkan inventaris sesuai studio yang dipilih.
     */
    public function items(Request $request)
    {
        $studio = $this->resolveStudio($request->query('studio'));
        $namaStudio = $this->studioLabel($studio);

        $query = Item::where('studio', $studio);

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->get();

        $totalBarang = Item::where('studio', $studio)->count();

        $kondisiBaik = Item::where('studio', $studio)
            ->where('kondisi_barang', 'Baik')
            ->count();

        $perluPerbaikan = Item::where('studio', $studio)
            ->where('kondisi_barang', 'Perlu Perbaikan')
            ->count();

        $judulStudio = 'Inventaris ' . $namaStudio;

        return view('management.items', compact(
            'items',
            'totalBarang',
            'kondisiBaik',
            'perluPerbaikan',
            'judulStudio',
            'namaStudio',
            'studio'
        ));
    }

    /**
     * Form tambah barang.
     */
    public function createItem(Request $request)
    {
        $studio = $this->resolveStudio($request->query('studio'));
        $namaStudio = $this->studioLabel($studio);

        return view('management.create-item', compact(
            'studio',
            'namaStudio'
        ));
    }

    
/**
 * Menyimpan barang baru ke studio yang dipilih.
 */
public function storeItem(Request $request)
{
    $validated = $request->validate([
        'studio' => [
            'required',
            Rule::in([
                'Studio Master Control Room',
                'Studio Berita',
                'Studio Penyiaran',
            ]),
        ],

        'nama_barang' => ['required', 'string', 'max:255'],

        'kategori' => ['required', 'string', 'max:255'],

        'foto' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],

        'status_barang' => [
            'required',
            Rule::in(['Tersedia', 'Dipinjam', 'Dalam Pemeliharaan']),
        ],

        'kondisi_barang' => [
            'required',
            Rule::in(['Baik', 'Perlu Perbaikan', 'Rusak']),
        ],
    ]);

    // Field lama tidak lagi digunakan pada form.
    $validated['serial_number'] = null;
    $validated['merk'] = null;
    $validated['tahun_produksi'] = null;
    $validated['tahun_masuk'] = null;

    // Upload foto barang jika tersedia.
    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')
            ->store('barang', 'public');
    }

    $studio = $validated['studio'];

    Item::create($validated);

    return $this->studioRedirect($studio)
        ->with('success', 'Barang berhasil ditambahkan.');
}


    /**
     * Form edit barang.
     */
    public function editItem(Request $request, Item $item)
    {
        $studio = $this->resolveStudio(
            $request->query('studio', $item->studio)
        );

        abort_unless($item->studio === $studio, 404);

        $namaStudio = $this->studioLabel($studio);

        return view('management.edit-item', compact(
            'item',
            'studio',
            'namaStudio'
        ));
    }

    /**
     * Memperbarui data barang tanpa mengubah studio asalnya.
     */
    
public function updateItem(Request $request, Item $item)
{
    $studio = $this->resolveStudio(
        $request->input(
            'studio',
            $request->query('studio', $item->studio)
        )
    );

    abort_unless($item->studio === $studio, 404);

    $validated = $request->validate([
        'nama_barang' => ['required', 'string', 'max:255'],
        'merk' => ['nullable', 'string', 'max:255'],
        'kategori' => ['required', 'string', 'max:255'],

        'foto' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048'
        ],

        'status_barang' => [
            'required',
            Rule::in(['Tersedia', 'Dipinjam', 'Dalam Pemeliharaan']),
        ],

        'kondisi_barang' => [
            'required',
            Rule::in(['Baik', 'Perlu Perbaikan', 'Rusak']),
        ],
    ]);

    // Pertahankan data lama yang tidak lagi ditampilkan di form.
    unset(
        $validated['serial_number'],
        $validated['tahun_produksi'],
        $validated['tahun_masuk']
    );

    if ($request->hasFile('foto')) {
        if ($item->foto) {
            Storage::disk('public')->delete($item->foto);
        }

        $validated['foto'] = $request->file('foto')
            ->store('barang', 'public');
    }

    // Studio barang tetap mengikuti data awal.
    $item->update($validated);

    return $this->studioRedirect($studio)
        ->with('success', 'Data barang berhasil diperbarui.');
}


    /**
     * Menghapus barang.
     */
    
/**
 * Menghapus barang dengan pemeriksaan riwayat pemeliharaan.
 */
public function destroyItem(Request $request, Item $item)
{
    $studio = $this->resolveStudio(
        $request->input(
            'studio',
            $request->query('studio', $item->studio)
        )
    );

    abort_unless($item->studio === $studio, 404);

    // Cek apakah barang masih memiliki riwayat pemeliharaan.
    $memilikiRiwayat = Pemeliharaan::where('item_id', $item->id)
        ->exists();

    if ($memilikiRiwayat) {
        return $this->studioRedirect($studio)
            ->with(
                'error',
                'Barang tidak dapat dihapus karena masih memiliki riwayat pemeliharaan. Silakan pertahankan data barang agar riwayat tetap tersimpan.'
            );
    }

    // Hapus data barang terlebih dahulu.
    $fotoBarang = $item->foto;

    $item->delete();

    // Hapus foto hanya jika data barang berhasil dihapus.
    if ($fotoBarang) {
        Storage::disk('public')->delete($fotoBarang);
    }

    return $this->studioRedirect($studio)
        ->with('success', 'Barang berhasil dihapus.');
}


    /**
     * Menampilkan foto barang.
     */
    public function showItemPhoto(Request $request, Item $item)
    {
        $studio = $this->resolveStudio(
            $request->query('studio', $item->studio)
        );

        abort_unless($item->studio === $studio, 404);

        if (
            !$item->foto ||
            !Storage::disk('public')->exists($item->foto)
        ) {
            return $this->studioRedirect($studio)
                ->with('error', 'Foto barang tidak ditemukan.');
        }

        return view('management.item-photo', compact('item'));
    }
}