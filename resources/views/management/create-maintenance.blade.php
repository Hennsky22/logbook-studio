
@extends('layouts.app')

@section('title', 'Tambah Pemeliharaan')
@section('page-title', 'Pemeliharaan')

@section('content')
<div class="page-heading">
    <div>
        <h1>Tambah Pemeliharaan</h1>
        <p>Catat kerusakan dan perbaikan peralatan studio.</p>
    </div>

    <a href="{{ route('maintenance.index') }}" class="btn">
        ← Kembali
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card activity-card" style="padding:28px;">
    <h3 class="card-title">Form Pemeliharaan Peralatan</h3>

    <form action="{{ route('maintenance.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div class="maintenance-grid">
            <div class="field">
                <label for="item_id">Barang *</label>
                <select name="item_id" id="item_id" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}"
                            @selected(old('item_id') == $item->id)>
                            {{ $item->id }} - {{ $item->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="tanggal_rusak">Tanggal Rusak *</label>
                <input type="date" name="tanggal_rusak"
                       id="tanggal_rusak"
                       value="{{ old('tanggal_rusak') }}" required>
            </div>

            <div class="field">
                <label for="tanggal_perbaikan">Tanggal Perbaikan</label>
                <input type="date" name="tanggal_perbaikan"
                       id="tanggal_perbaikan"
                       value="{{ old('tanggal_perbaikan') }}">
            </div>

            <div class="field">
                <label for="kerusakan">Kerusakan *</label>
                <textarea name="kerusakan" id="kerusakan"
                          rows="4" required>{{ old('kerusakan') }}</textarea>
            </div>

            <div class="field">
                <label for="penanganan">Penanganan</label>
                <textarea name="penanganan" id="penanganan"
                          rows="4">{{ old('penanganan') }}</textarea>
            </div>

            <div class="field">
                <label for="foto_awal">Foto Awal Sebelum Perbaikan</label>
                <input type="file" name="foto_awal" id="foto_awal"
                       accept="image/jpeg,image/png,image/webp">
                <small>Format JPG, PNG, atau WEBP; maksimal 2 MB.</small>
            </div>

            <div class="field">
                <label for="foto_sesudah">Foto Sesudah Perbaikan</label>
                <input type="file" name="foto_sesudah" id="foto_sesudah"
                       accept="image/jpeg,image/png,image/webp">
                <small>Boleh dikosongkan jika belum selesai diperbaiki.</small>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('maintenance.index') }}" class="btn">
                Batal
            </a>

            <button type="submit" class="btn btn-primary">
                Simpan Pemeliharaan
            </button>
        </div>
    </form>
</div>

<style>
.maintenance-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 22px;
    margin-top: 24px;
}
.field {
    display: flex;
    flex-direction: column;
    gap: 9px;
}
.field label {
    font-weight: 600;
    font-size: 14px;
}
.field input, .field select, .field textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 12px;
    border: 1px solid #d9e2ea;
    border-radius: 9px;
    background: #fff;
    font: inherit;
}
.field input, .field select {
    min-height: 45px;
}
.field small {
    color: #718096;
    font-size: 12px;
}
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 26px;
    padding-top: 22px;
    border-top: 1px solid #edf1f5;
}
@media (max-width: 700px) {
    .maintenance-grid {
        grid-template-columns: 1fr;
    }
    .form-actions {
        flex-direction: column-reverse;
    }
}
</style>
@endsection
