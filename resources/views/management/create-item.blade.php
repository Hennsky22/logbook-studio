
@extends('layouts.app')

@section('title', 'Tambah Barang - ' . $namaStudio)

@section('content')

<div class="page-header">
    <h2>Tambah Barang — {{ $namaStudio }}</h2>
    <p>Lengkapi identitas dan kondisi barang inventaris studio.</p>
</div>

<div class="form-card">

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <input type="hidden" name="studio" value="{{ $studio }}">

        <div class="form-grid">

            {{-- NAMA BARANG --}}
            <div class="form-group">
                <label for="nama_barang">
                    Nama Barang <span>*</span>
                </label>

                <input
                    type="text"
                    id="nama_barang"
                    name="nama_barang"
                    value="{{ old('nama_barang') }}"
                    required
                >
            </div>

            {{-- KATEGORI BARANG --}}
            <div class="form-group">
                <label for="kategori">
                    Kategori Barang <span>*</span>
                </label>

                <input
                    type="text"
                    id="kategori"
                    name="kategori"
                    value="{{ old('kategori') }}"
                    required
                    placeholder="Contoh: Elektronik"
                >
            </div>

            {{-- STATUS BARANG --}}
            <div class="form-group">
                <label for="status_barang">
                    Status Barang <span>*</span>
                </label>

                <select id="status_barang" name="status_barang" required>
                    <option value="">Pilih status</option>

                    <option value="Tersedia"
                        @selected(old('status_barang') === 'Tersedia')>
                        Tersedia
                    </option>

                    <option value="Dipinjam"
                        @selected(old('status_barang') === 'Dipinjam')>
                        Dipinjam
                    </option>

                    <option value="Dalam Pemeliharaan"
                        @selected(old('status_barang') === 'Dalam Pemeliharaan')>
                        Dalam Pemeliharaan
                    </option>
                </select>
            </div>

            {{-- KONDISI BARANG --}}
            <div class="form-group">
                <label for="kondisi_barang">
                    Kondisi Barang <span>*</span>
                </label>

                <select id="kondisi_barang" name="kondisi_barang" required>
                    <option value="">Pilih kondisi</option>

                    <option value="Baik"
                        @selected(old('kondisi_barang') === 'Baik')>
                        Baik
                    </option>

                    <option value="Perlu Perbaikan"
                        @selected(old('kondisi_barang') === 'Perlu Perbaikan')>
                        Perlu Perbaikan
                    </option>

                    <option value="Rusak"
                        @selected(old('kondisi_barang') === 'Rusak')>
                        Rusak
                    </option>
                </select>
            </div>

            {{-- FOTO BARANG --}}
            <div class="form-group form-group-full">
                <label for="foto">Foto Barang</label>

                <input
                    type="file"
                    id="foto"
                    name="foto"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small>
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                </small>
            </div>

        </div>

        {{-- TOMBOL --}}
        <div class="form-actions">

            <a href="{{ route('items.index', ['studio' => $namaStudio]) }}"
               class="btn btn-outline">
                Batal
            </a>

            <button type="submit" class="btn maintenance-add-btn">
                Simpan Barang
            </button>

        </div>

    </form>

</div>

<style>
    .form-card {
        background: #fff;
        border: 1px solid #e5edf2;
        border-radius: 16px;
        padding: 28px;
        margin-top: 28px;
        box-shadow: 0 5px 18px rgba(25, 55, 80, 0.04);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 0;
    }

    .form-group-full {
        grid-column: 1 / -1;
    }

    .form-group label {
        color: #243b53;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group label span {
        color: #dc3545;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        box-sizing: border-box;
        min-height: 44px;
        padding: 10px 12px;
        border: 1px solid #dce5ec;
        border-radius: 8px;
        background: #fff;
        color: #243b53;
        font: inherit;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #07877d;
        box-shadow: 0 0 0 3px rgba(7, 135, 125, 0.12);
    }

    .form-group small {
        color: #718096;
        font-size: 12px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        border-top: 1px solid #e5edf2;
        margin-top: 28px;
        padding-top: 24px;
    }

    .form-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 10px 20px;
        border-radius: 9px;
        text-decoration: none;
        cursor: pointer;
        font: inherit;
        font-weight: 600;
    }

    .form-actions .btn-outline {
        background: #fff;
        border: 1px solid #dce5ec;
        color: #07877d;
    }

    .form-actions .maintenance-add-btn {
        background: #07877d;
        border: 1px solid #07877d;
        color: #fff;
    }

    .alert-danger {
        background: #fff1f0;
        color: #b42318;
        border: 1px solid #ffd5d2;
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 22px;
    }

    @media (max-width: 700px) {
        .form-card {
            padding: 18px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group-full {
            grid-column: auto;
        }
    }
</style>

@endsection
