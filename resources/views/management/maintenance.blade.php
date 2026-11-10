
@extends('layouts.app')

@section('title', 'Pemeliharaan')

@section('page-title', 'Pemeliharaan')

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
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        padding: 14px 20px;
        border: none;
        border-radius: 9px;
        background-color: #078579;
        color: #fff !important;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none !important;
        white-space: nowrap;
        transition: background-color .2s ease;
    }

    .maintenance-add-btn:hover {
        background-color: #066d64;
        color: #fff !important;
    }

    .maintenance-alert {
        margin-bottom: 20px;
        padding: 14px 18px;
        border-radius: 8px;
        background: #dff5ed;
        color: #08775d;
    }

    .maintenance-alert-error {
        background: #fee2e2;
        color: #b91c1c;
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
        min-width: 900px;
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

    .maintenance-item-name {
        font-weight: 600;
        color: #243b53;
    }

    .maintenance-photo {
        display: block;
        width: 66px;
        height: 58px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
    }

    .maintenance-no-photo {
        color: #9aa8b7;
    }

    .maintenance-status {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        background: #dff5ef;
        color: #078579;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .maintenance-status.pending {
        background: #fff0d5;
        color: #9a6700;
    }

    .maintenance-empty {
        padding: 35px 20px !important;
        text-align: center;
        color: #8293a7 !important;
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
            <h2>Pemeliharaan Peralatan</h2>
            <p>Pantau perawatan, perbaikan, dan kondisi peralatan studio.</p>
        </div>

        <a href="{{ route('maintenance.create') }}"
           class="btn maintenance-add-btn">
            + Tambah Pemeliharaan
        </a>
    </div>

   
@if (session('success'))
    <div style="padding:14px 18px; margin-bottom:20px; background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; border-radius:8px;">
        {{ session('success') }}
    </div>
@endif


@if ($errors->any())
    <div style="margin:20px 24px 0; padding:14px 18px; background:#fee2e2; color:#991b1b; border-radius:8px;">
        <strong>Data belum berhasil disimpan.</strong>
        <ul style="margin:8px 0 0; padding-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="maintenance-card-heading">
</div>


    @if ($errors->any())
        <div class="maintenance-alert maintenance-alert-error">
            <strong>Data belum berhasil disimpan.</strong>
            <ul style="margin: 8px 0 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
<form action="{{ route('maintenance.index') }}"
      method="GET"
      style="display:flex;gap:10px;margin-bottom:20px;max-width:600px;">

    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari nama barang atau kerusakan..."
        style="flex:1;min-width:0;padding:12px;border:1px solid #d1d5db;border-radius:8px;"
    >

    <button type="submit" class="btn">
        Cari
    </button>

    @if (request('search'))
        <a href="{{ route('maintenance.index') }}"
           class="btn btn-outline">
            Reset
        </a>
    @endif
</form>

    <div class="maintenance-card">
        <div class="maintenance-card-heading">
            <h3>Riwayat Pemeliharaan</h3>
            <p>Daftar perawatan dan perbaikan peralatan studio.</p>
        </div>

        <div class="maintenance-table-wrapper">
            <table class="maintenance-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Rusak</th>
                        <th>Nama Barang</th>
                        <th>Kerusakan</th>
                        <th>Penanganan</th>
                        <th>Tanggal Perbaikan</th>
                        <th>Foto Sebelum</th>
                        <th>Foto Sesudah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                
<tbody>
    @forelse ($pemeliharaans as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>
                {{ $data->tanggal_rusak
                    ? \Carbon\Carbon::parse($data->tanggal_rusak)->format('d/m/Y')
                    : '-' }}
            </td>

            <td>{{ $data->item->nama_barang ?? '-' }}</td>

            <td>{{ $data->kerusakan ?? '-' }}</td>

            <td>{{ $data->penanganan ?? '-' }}</td>

            <td>
                {{ $data->tanggal_perbaikan
                    ? \Carbon\Carbon::parse($data->tanggal_perbaikan)->format('d/m/Y')
                    : '-' }}
            </td>

            <td>
                @if ($data->foto_awal)
                    <a href="{{ asset('storage/' . $data->foto_awal) }}"
                       target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('storage/' . $data->foto_awal) }}"
                             alt="Foto sebelum perbaikan"
                             style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                    </a>
                @else
                    -
                @endif
            </td>

            <td>
                @if ($data->foto_sesudah)
                    <a href="{{ asset('storage/' . $data->foto_sesudah) }}"
                       target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('storage/' . $data->foto_sesudah) }}"
                             alt="Foto sesudah perbaikan"
                             style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                    </a>
                @else
                    -
                @endif
            </td>

            <td>{{ $data->status ?? 'Menunggu Perbaikan' }}</td>

            <td>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    <a href="{{ route('maintenance.show', $data->id) }}"
                       class="btn"
                       style="padding:7px 10px;">
                        Detail
                    </a>

                    <a href="{{ route('maintenance.edit', $data->id) }}"
                       class="btn"
                       style="padding:7px 10px;">
                        Edit
                    </a>

                    <form action="{{ route('maintenance.destroy', $data->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus data pemeliharaan ini?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn"
                                style="padding:7px 10px;background:#dc3545;color:white;">
                            Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="10" style="text-align:center;padding:24px;">
                Belum ada data pemeliharaan.
            </td>
        </tr>
    @endforelse
</tbody>

            </table>
        </div>
    </div>

</div>
@endsection
