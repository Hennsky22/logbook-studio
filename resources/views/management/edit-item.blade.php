
@extends('layouts.app')

@section('title', 'Edit Barang - ' . $namaStudio)
@section('page-title', 'Edit Barang')

@section('content')

<style>
    .edit-item-wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }

    .edit-item-card {
        background: #fff;
        border: 1px solid #e7edf0;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 4px 18px rgba(30, 55, 70, 0.04);
    }

    .edit-item-heading {
        margin-bottom: 24px;
    }

    .edit-item-heading h2 {
        margin: 0 0 8px;
        color: #183b50;
        font-size: 23px;
    }

    .edit-item-heading p {
        margin: 0;
        color: #718096;
        font-size: 14px;
    }

    .edit-item-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .edit-field {
        min-width: 0;
    }

    .edit-field.full-width,
    .edit-section-title {
        grid-column: 1 / -1;
    }

    .edit-field label {
        display: block;
        margin-bottom: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .edit-field input,
    .edit-field select {
        display: block;
        width: 100%;
        min-height: 44px;
        padding: 10px 12px;
        border: 1px solid #dbe3e8;
        border-radius: 9px;
        background: #fff;
        color: #243746;
        font-family: inherit;
        font-size: 13px;
        outline: none;
    }

    .edit-field input:focus,
    .edit-field select:focus {
        border-color: #078579;
        box-shadow: 0 0 0 3px rgba(7, 133, 121, .10);
    }

    .edit-field input[type="file"] {
        padding: 9px;
    }

    .edit-field small {
        display: block;
        margin-top: 7px;
        color: #718096;
        font-size: 11px;
        line-height: 1.6;
    }

    .edit-section-title {
        margin: 8px 0 -5px;
        padding-bottom: 12px;
        border-bottom: 1px solid #edf1f3;
        color: #087f75;
        font-size: 14px;
        font-weight: 750;
    }

    .edit-current-photo {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 12px;
        padding: 12px;
        border: 1px solid #e7edf0;
        border-radius: 10px;
    }

    .edit-current-photo img {
        width: 100px;
        height: 85px;
        object-fit: cover;
        border-radius: 8px;
    }

    .edit-current-photo p {
        margin: 0;
        color: #64748b;
        font-size: 12px;
    }

    .edit-alert {
        margin-bottom: 20px;
        padding: 14px 17px;
        border-radius: 10px;
        font-size: 13px;
        line-height: 1.7;
    }

    .edit-alert ul {
        margin: 7px 0 0;
        padding-left: 20px;
    }

    .edit-alert-danger {
        background: #fff0f0;
        border: 1px solid #f5cccc;
        color: #a52c2c;
    }

    .edit-alert-success {
        background: #eaf8ef;
        border: 1px solid #c8ebd3;
        color: #23683b;
    }

    .edit-form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #edf1f3;
    }

    .edit-form-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 11px 20px;
        border: 1px solid #078579;
        border-radius: 9px;
        background: #078579;
        color: #fff;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .edit-form-actions .btn:hover {
        background: #066d65;
    }

    .edit-form-actions .btn-outline {
        background: #fff;
        border-color: #dbe3e8;
        color: #087f75;
    }

    .edit-form-actions .btn-outline:hover {
        background: #f3f8f8;
    }

    @media (max-width: 650px) {
        .edit-item-card {
            padding: 18px;
        }

        .edit-item-grid {
            grid-template-columns: 1fr;
            gap: 17px;
        }

        .edit-field.full-width,
        .edit-section-title {
            grid-column: auto;
        }

        .edit-form-actions {
            flex-direction: column-reverse;
        }

        .edit-form-actions .btn {
            width: 100%;
        }
    }
</style>

<div class="edit-item-wrapper">

    <div class="page-heading edit-item-heading">
        <div>
            <h2>Edit Barang — {{ $namaStudio }}</h2>
            <p>Ubah identitas, foto, status, dan kondisi barang inventaris studio.</p>
        </div>
    </div>

    <div class="edit-item-card">

        @if (session('success'))
            <div class="edit-alert edit-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="edit-alert edit-alert-danger">
                <strong>Data belum valid. Periksa kembali isian berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('items.update', $item->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <input type="hidden" name="studio" value="{{ $studio }}">

            <div class="edit-item-grid">

                {{-- IDENTITAS BARANG --}}
                <div class="edit-section-title">
                    Identitas Barang
                </div>

                <div class="edit-field">
                    <label for="nama_barang">Nama Barang *</label>
                    <input
                        type="text"
                        id="nama_barang"
                        name="nama_barang"
                        value="{{ old('nama_barang', $item->nama_barang) }}"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="edit-field">
                    <label for="kategori">Kategori Barang *</label>
                    <input
                        type="text"
                        id="kategori"
                        name="kategori"
                        value="{{ old('kategori', $item->kategori) }}"
                        maxlength="255"
                        required
                    >
                </div>

                <div class="edit-field">
                    <label for="merk">Merek / Brand</label>
                    <input
                        type="text"
                        id="merk"
                        name="merk"
                        value="{{ old('merk', $item->merk) }}"
                        maxlength="255"
                    >
                </div>

                <div class="edit-field full-width">
                    <label for="studio_display">Studio</label>
                    <input
                        type="text"
                        id="studio_display"
                        value="{{ $namaStudio }}"
                        disabled
                    >
                    <small>Studio asal barang tidak dapat diubah dari halaman ini.</small>
                </div>

                {{-- INFORMASI INVENTARIS --}}
                <div class="edit-section-title">
                    Informasi Inventaris
                </div>

                <div class="edit-field">
                    <label for="status_barang">Status Barang *</label>
                    <select id="status_barang" name="status_barang" required>
                        @foreach (['Tersedia', 'Dipinjam', 'Dalam Pemeliharaan'] as $status)
                            <option
                                value="{{ $status }}"
                                {{ old('status_barang', $item->status_barang) === $status ? 'selected' : '' }}
                            >
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="edit-field">
                    <label for="kondisi_barang">Kondisi Barang *</label>
                    <select id="kondisi_barang" name="kondisi_barang" required>
                        @foreach (['Baik', 'Perlu Perbaikan', 'Rusak'] as $kondisi)
                            <option
                                value="{{ $kondisi }}"
                                {{ old('kondisi_barang', $item->kondisi_barang) === $kondisi ? 'selected' : '' }}
                            >
                                {{ $kondisi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- FOTO BARANG --}}
                <div class="edit-section-title">
                    Foto Barang
                </div>

                <div class="edit-field full-width">
                    <label for="foto">Unggah Foto Baru (opsional)</label>
                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    >

                    <small>
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                        Kosongkan jika tidak ingin mengganti foto.
                    </small>

                    @if ($item->foto)
                        <div class="edit-current-photo">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->foto) }}"
                                alt="Foto {{ $item->nama_barang }}"
                            >

                            <p>
                                Foto barang saat ini. Foto akan diganti jika kamu mengunggah foto baru.
                            </p>
                        </div>
                    @else
                        <small>Belum ada foto yang tersimpan untuk barang ini.</small>
                    @endif
                </div>

            </div>

            {{-- TOMBOL --}}
            <div class="edit-form-actions">

                <a
                    href="{{ route('items.index', ['studio' => $namaStudio]) }}"
                    class="btn btn-outline"
                >
                    Batal
                </a>

                <button type="submit" class="btn">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection