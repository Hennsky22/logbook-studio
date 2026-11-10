
@extends('layouts.app')

@section('title', 'Peminjaman')
@section('page-title', 'Peminjaman')

@section('content')
<style>
    .maintenance-page {
        width: 100%;
        min-width: 0;
    }

    .maintenance-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
    }

    .maintenance-heading-text h2 {
        margin: 0 0 8px;
        color: #243b53;
        font-size: 24px;
        font-weight: 700;
    }

    .maintenance-heading-text p {
        margin: 0;
        color: #8293a7;
        font-size: 15px;
    }

    .maintenance-add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        padding: 14px 20px;
        border: none;
        border-radius: 9px;
        background: #078579;
        color: #fff !important;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none !important;
    }

    .maintenance-add-btn:hover {
        background: #066d64;
    }

    .maintenance-alert {
        margin-bottom: 20px;
        padding: 14px 18px;
        border-radius: 8px;
        background: #dff5ed;
        color: #08775d;
    }

    .maintenance-card {
        width: 100%;
        overflow: hidden;
        border: 1px solid #e6edf2;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 4px 14px rgba(20, 45, 70, .04);
    }

    .maintenance-card-heading {
        padding: 24px 24px 18px;
    }

    .maintenance-card-heading h3 {
        margin: 0 0 8px;
        color: #243b53;
        font-size: 17px;
        font-weight: 700;
    }

    .maintenance-card-heading p {
        margin: 0;
        color: #8293a7;
        font-size: 14px;
    }

    .maintenance-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .maintenance-table {
        width: 100%;
        min-width: 1000px;
        border-collapse: collapse;
        text-align: left;
    }

    .maintenance-table thead th {
        padding: 16px 15px;
        background: #f7f9fb;
        color: #74869a;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
        border-bottom: 1px solid #e6edf2;
    }

    .maintenance-table tbody td {
        padding: 16px 15px;
        color: #34495e;
        font-size: 13px;
        border-bottom: 1px solid #e8eef3;
        vertical-align: middle;
    }

    .maintenance-table tbody tr:last-child td {
        border-bottom: none;
    }

    .maintenance-table tbody tr:hover {
        background: #fbfdfd;
    }

    .maintenance-status {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        background: #fff0d5;
        color: #9a6700;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .maintenance-status.done {
        background: #dff5ef;
        color: #078579;
    }

    .maintenance-empty {
        padding: 35px 20px !important;
        text-align: center;
        color: #8293a7 !important;
    }

    .loan-action-group {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: wrap;
    }

    .loan-action-group form {
        margin: 0;
    }

    .loan-action-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 7px 10px;
        border: none;
        border-radius: 7px;
        background: #078579;
        color: #fff !important;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none !important;
        white-space: nowrap;
        cursor: pointer;
    }

    .loan-action-btn:hover {
        background: #066d64;
    }

    .loan-action-btn.delete {
        background: #dc3545;
    }

    .loan-action-btn.delete:hover {
        background: #bb2d3b;
    }

    @media (max-width: 768px) {
        .maintenance-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .maintenance-add-btn {
            align-self: flex-start;
        }

        .maintenance-card-heading {
            padding: 18px;
        }
    }
</style>

<div class="maintenance-page">

    <div class="maintenance-heading">
        <div class="maintenance-heading-text">
            <h2>Peminjaman Barang</h2>
            <p>Kelola pencatatan peminjaman dan pengembalian barang studio.</p>
        </div>

        <a href="{{ route('loans.create') }}"
           class="btn maintenance-add-btn">
            + Tambah Peminjaman
        </a>
    </div>

    @if (session('success'))
        <div class="maintenance-alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="maintenance-alert"
             style="background:#fee2e2;color:#b91c1c;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="maintenance-alert"
             style="background:#fee2e2;color:#b91c1c;">
            <strong>Data belum berhasil diproses.</strong>
            <ul style="margin:8px 0 0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="maintenance-card">
        <div class="maintenance-card-heading">
            <h3>Riwayat Peminjaman</h3>
            <p>Daftar peminjaman dan pengembalian barang studio.</p>
        </div>

        <div class="maintenance-table-wrapper">
            <table class="maintenance-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Pinjam</th>
                        <th>Studio</th>
                        <th>Kegiatan</th>
                        <th>Dipinjam Oleh</th>
                        <th>Dikembalikan Oleh</th>
                        <th>Barang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($peminjamans as $data)
                        @php
                            $studio = $data->logbook->studio ?? '-';

                            $namaStudio = match ($studio) {
                                'berita' => 'Studio Berita',
                                'penyiaran' => 'Studio Penyiaran',
                                'mcr' => 'Master Control Room',
                                default => $studio,
                            };

                            $sudahKembali = strtolower($data->status ?? '') === 'dikembalikan';
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $data->tanggal_pinjam
                                    ? \Carbon\Carbon::parse($data->tanggal_pinjam)->format('d/m/Y')
                                    : '-' }}
                            </td>

                            <td>{{ $namaStudio }}</td>

                            <td>{{ $data->logbook->nama_kegiatan ?? '-' }}</td>

                            <td>
                                {{ $data->petugas->name
                                    ?? $data->logbook->petugas
                                    ?? '-' }}
                            </td>

                            <td>
                                {{ $data->tanggal_kembali
                                    ? ($data->petugas->name ?? $data->logbook->petugas ?? '-')
                                    : 'Belum dikembalikan' }}
                            </td>

                            <td>{{ $data->item->nama_barang ?? '-' }}</td>

                            <td>
                                <span class="maintenance-status {{ $sudahKembali ? 'done' : '' }}">
                                    {{ $data->status ?? 'Dipinjam' }}
                                </span>
                            </td>

                            <td>
                                <div class="loan-action-group">
                                    <a href="{{ route('loans.show', $data->id) }}"
                                       class="loan-action-btn">
                                        Detail
                                    </a>

                                    @if (!$sudahKembali)
                                        <form action="{{ route('loans.return', $data->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Konfirmasi barang ini sudah dikembalikan?')">
                                            @csrf

                                            <button type="submit" class="loan-action-btn">
                                                Pengembalian
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('loans.destroy', $data->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus catatan peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="loan-action-btn delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="maintenance-empty">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
