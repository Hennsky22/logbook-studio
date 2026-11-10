
@extends('layouts.app')

@section('title', 'Tambah Logbook')
@section('page-title', 'Tambah Logbook')

@section('content')

<div class="page-heading">
    <div>
        <h1>Tambah Logbook</h1>
        <p>Catat kegiatan dan kondisi operasional studio.</p>
    </div>

    <a href="/logbooks" class="btn btn-outline">
        ← Kembali
    </a>
</div>

<form action="/logbooks" method="POST" class="card logbook-form">
    @csrf

    <div class="form-section">
        <h3>Informasi Kegiatan</h3>
        <p>Isi informasi dasar kegiatan studio.</p>
    </div>

    <div class="form-grid">

        <div class="form-group">
            <label for="tanggal">Tanggal Kegiatan *</label>
            <input
    type="date"
    name="tanggal"
    value="{{ old('tanggal', now()->format('Y-m-d')) }}"
    required
>
        </div>

        <div class="form-group">
            <label for="studio">Pilih Studio *</label>
            <select id="studio" name="studio" class="form-control" required>
                <option value="">-- Pilih Studio --</option>
                <option value="berita">Studio Berita</option>
                <option value="penyiaran">Studio Penyiaran</option>
                <option value="mcr">Master Control Room</option>
            </select>
        </div>

        <div class="form-group">
            <label for="jam_mulai">Jam Mulai *</label>
            <input
                type="time"
                id="jam_mulai"
                name="jam_mulai"
                class="form-control"
                required
            >
        </div>

        <div class="form-group">
            <label for="jam_selesai">Jam Selesai *</label>
            <input
                type="time"
                id="jam_selesai"
                name="jam_selesai"
                class="form-control"
                required
            >
        </div>

        <div class="form-group">
            <label for="jenis_kegiatan">Jenis Kegiatan *</label>
            <select
                id="jenis_kegiatan"
                name="jenis_kegiatan"
                class="form-control"
                required
            >
                <option value="">-- Pilih Jenis --</option>
                <option value="Produksi">Produksi</option>
                <option value="Siaran">Siaran</option>
                <option value="Pemeliharaan">Pemeliharaan</option>
                <option value="Pengujian">Pengujian</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="petugas">Nama Petugas *</label>
            <input
                type="text"
                id="petugas"
                name="petugas"
                class="form-control"
                placeholder="Masukkan nama petugas"
                value="{{ old('petugas') }}"
                required
            >
        </div>

        <div class="form-group full-width">
            <label for="nama_kegiatan">Nama Kegiatan *</label>
            <input
                type="text"
                id="nama_kegiatan"
                name="nama_kegiatan"
                class="form-control"
                placeholder="Contoh: Persiapan siaran berita"
                value="{{ old('nama_kegiatan') }}"
                required
            >
        </div>

        <div class="form-group full-width">
            <label for="uraian_kegiatan">Uraian Kegiatan *</label>
            <textarea
                id="uraian_kegiatan"
                name="uraian_kegiatan"
                class="form-control"
                placeholder="Jelaskan kegiatan yang dilakukan..."
                required
            >{{ old('uraian_kegiatan') }}</textarea>
        </div>

    </div>

    <div class="form-section">
        <h3>Kendala dan Penanganan</h3>
        <p>Catat kendala operasional jika ada.</p>
    </div>

    <div class="form-grid">

        <div class="form-group full-width">
            <label for="kendala">Kendala</label>
            <textarea
                id="kendala"
                name="kendala"
                class="form-control"
                placeholder="Tuliskan kendala atau isi '-' jika tidak ada"
            >{{ old('kendala') }}</textarea>
        </div>

        <div class="form-group full-width">
            <label for="penyebab">Penyebab Kendala</label>
            <textarea
                id="penyebab"
                name="penyebab"
                class="form-control"
                placeholder="Jelaskan penyebab kendala jika ada"
            >{{ old('penyebab') }}</textarea>
        </div>

        <div class="form-group full-width">
            <label for="penanganan">Penanganan</label>
            <textarea
                id="penanganan"
                name="penanganan"
                class="form-control"
                placeholder="Jelaskan tindakan yang dilakukan"
            >{{ old('penanganan') }}</textarea>
        </div>

        <div class="form-group">
            <label for="kondisi_akhir">Kondisi Akhir</label>
            <select id="kondisi_akhir" name="kondisi_akhir" class="form-control">
                <option value="">-- Pilih Kondisi --</option>
                <option value="Normal">Normal</option>
                <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                <option value="Belum Selesai">Belum Selesai</option>
            </select>
        </div>

        <div class="form-group">
            <label for="nama_pelapor">Nama Pelapor</label>
            <input
                type="text"
                id="nama_pelapor"
                name="nama_pelapor"
                class="form-control"
                placeholder="Nama pelapor"
            >
        </div>

    </div>

    <div class="form-actions">
        <a href="/logbooks" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn">Simpan Logbook</button>
    </div>

</form>

@endsection
