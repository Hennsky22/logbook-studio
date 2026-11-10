
@extends('layouts.app')

@section('title', $judulStudio)
@section('page-title', $judulStudio)

@section('content')

<style>
    .inventory-page {
        max-width: 1250px;
        margin: 0 auto;
    }

    .inventory-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .inventory-heading h2 {
        margin: 0 0 7px;
        color: #183b50;
        font-size: 25px;
    }

    .inventory-heading p {
        margin: 0;
        color: #718096;
        font-size: 13px;
        line-height: 1.6;
    }

    .inventory-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .inventory-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 16px;
        border: 1px solid #087f75;
        border-radius: 9px;
        background: #087f75;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        font-family: inherit;
    }

    .inventory-btn:hover {
        background: #06685f;
        color: #fff;
    }

    .inventory-btn-outline {
        background: #fff;
        color: #087f75;
        border-color: #d5e3e2;
    }

    .inventory-btn-outline:hover {
        background: #f0f8f7;
        color: #06685f;
    }

    .inventory-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .inventory-stat {
        padding: 22px;
        background: #fff;
        border: 1px solid #e7edf0;
        border-radius: 14px;
    }

    .inventory-stat-label {
        color: #718096;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .inventory-stat-number {
        color: #183b50;
        font-size: 28px;
        font-weight: 750;
    }

    .inventory-stat-note {
        margin-top: 7px;
        color: #82909b;
        font-size: 11px;
    }

    .inventory-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e7edf0;
        border-radius: 15px;
    }

    .inventory-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        padding: 22px;
        border-bottom: 1px solid #edf1f3;
    }

    .inventory-panel-header h3 {
        margin: 0 0 6px;
        color: #183b50;
        font-size: 17px;
    }

    .inventory-panel-header p {
        margin: 0;
        color: #718096;
        font-size: 12px;
    }

    .inventory-search {
        display: flex;
        gap: 8px;
        width: 100%;
        max-width: 430px;
    }

    .inventory-search input {
        min-width: 0;
        flex: 1;
        padding: 10px 12px;
        border: 1px solid #dbe3e8;
        border-radius: 8px;
        outline: none;
        font-size: 12px;
    }

    .inventory-search input:focus {
        border-color: #087f75;
    }

    .inventory-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .inventory-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12px;
    }

    .inventory-table th {
        padding: 14px 16px;
        background: #f7fafb;
        color: #60717e;
        font-size: 10px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .4px;
        white-space: nowrap;
    }

    .inventory-table td {
        padding: 16px;
        border-top: 1px solid #edf1f3;
        color: #334155;
        vertical-align: middle;
    }

    .inventory-table tbody tr:hover {
        background: #fbfdfd;
    }

    .inventory-item-name {
        color: #183b50;
        font-size: 13px;
        font-weight: 700;
        min-width: 150px;
    }

    .inventory-muted {
        margin-top: 5px;
        color: #82909b;
        font-size: 11px;
        line-height: 1.5;
    }

    .inventory-badge {
        display: inline-block;
        padding: 6px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .inventory-badge-good {
        background: #e8f6ed;
        color: #237443;
    }

    .inventory-badge-warning {
        background: #fff3dc;
        color: #96620c;
    }

    .inventory-badge-danger {
        background: #ffebeb;
        color: #b83232;
    }

    .inventory-badge-neutral {
        background: #edf2f7;
        color: #526171;
    }

    .inventory-row-actions {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .inventory-action-link {
        display: inline-block;
        padding: 7px 10px;
        border: 1px solid #dbe7e6;
        border-radius: 7px;
        background: #fff;
        color: #087f75;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
    }

    .inventory-action-link:hover {
        background: #eef8f6;
    }

    .inventory-action-delete {
        border: 1px solid #f0d7d7;
        color: #b83232;
        cursor: pointer;
    }

    .inventory-action-delete:hover {
        background: #fff1f1;
    }

    .inventory-empty {
        padding: 45px 20px;
        text-align: center;
        color: #718096;
    }

    .inventory-empty h4 {
        margin: 0 0 8px;
        color: #183b50;
        font-size: 16px;
    }

    .inventory-empty p {
        margin: 0 0 18px;
        font-size: 12px;
        line-height: 1.7;
    }

    .inventory-alert {
        margin-bottom: 18px;
        padding: 13px 16px;
        border-radius: 9px;
        font-size: 12px;
        line-height: 1.7;
    }

    .inventory-alert-success {
        color: #237443;
        background: #e8f6ed;
        border: 1px solid #ccebd5;
    }

    .inventory-alert-error {
        color: #b83232;
        background: #ffebeb;
        border: 1px solid #f3cccc;
    }

    .inventory-alert ul {
        padding-left: 20px;
    }

    @media (max-width: 800px) {
        .inventory-summary {
            grid-template-columns: 1fr;
        }

        .inventory-heading h2 {
            font-size: 22px;
        }

        .inventory-panel-header {
            align-items: stretch;
        }

        .inventory-search {
            max-width: none;
        }
    }

    @media (max-width: 480px) {
        .inventory-actions {
            width: 100%;
        }

        .inventory-actions .inventory-btn {
            flex: 1;
        }

        .inventory-search {
            flex-wrap: wrap;
        }

        .inventory-search input {
            flex-basis: 100%;
        }
    }
</style>

<div class="inventory-page">

    {{-- HEADER --}}
    <div class="inventory-heading">
        <div>
            <h2>{{ $judulStudio }}</h2>
            <p>Kelola data, kondisi, dan status inventaris studio.</p>
        </div>

        <div class="inventory-actions">
            <a href="{{ url('/logbooks') }}"
               class="inventory-btn inventory-btn-outline">
                &larr; Kembali ke Dashboard
            </a>

            <a href="{{ route('items.create', ['studio' => $namaStudio]) }}"
               class="inventory-btn">
                + Tambah Barang
            </a>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="inventory-alert inventory-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="inventory-alert inventory-alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="inventory-alert inventory-alert-error">
            <strong>Ada data yang perlu diperiksa:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RINGKASAN INVENTARIS --}}
    <div class="inventory-summary">

        <div class="inventory-stat">
            <div class="inventory-stat-label">Total Barang</div>
            <div class="inventory-stat-number">{{ $totalBarang }}</div>
            <div class="inventory-stat-note">
                Inventaris {{ $namaStudio }}
            </div>
        </div>

        <div class="inventory-stat">
            <div class="inventory-stat-label">Kondisi Baik</div>
            <div class="inventory-stat-number">{{ $kondisiBaik }}</div>
            <div class="inventory-stat-note">
                Barang dengan kondisi baik
            </div>
        </div>

        <div class="inventory-stat">
            <div class="inventory-stat-label">Perlu Perbaikan</div>
            <div class="inventory-stat-number">{{ $perluPerbaikan }}</div>
            <div class="inventory-stat-note">
                Barang yang perlu ditindaklanjuti
            </div>
        </div>

    </div>

    {{-- DAFTAR INVENTARIS --}}
    <div class="inventory-panel">

        <div class="inventory-panel-header">

            <div>
                <h3>Daftar Inventaris</h3>

                <p>
                    Menampilkan {{ $items->count() }} barang

                    @if (request('search'))
                        untuk pencarian "{{ request('search') }}"
                    @endif
                </p>
            </div>

            {{-- PENCARIAN --}}
            <form
                action="{{ route('items.index') }}"
                method="GET"
                class="inventory-search"
            >

                <input
                    type="hidden"
                    name="studio"
                    value="{{ $namaStudio }}"
                >

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau merek barang..."
                >

                <button type="submit" class="inventory-btn">
                    Cari
                </button>

                @if (request('search'))
                    <a
                        href="{{ route('items.index', ['studio' => $namaStudio]) }}"
                        class="inventory-btn inventory-btn-outline"
                    >
                        Reset
                    </a>
                @endif

            </form>

        </div>

        {{-- TABEL --}}
        @if ($items->isNotEmpty())

            <div class="inventory-table-wrap">

                <table class="inventory-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Barang</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($items as $item)

                            <tr>

                                {{-- ID --}}
                                <td>
                                    #{{ $item->id }}
                                </td>

                                {{-- NAMA BARANG --}}
                                <td>
                                    <div class="inventory-item-name">
                                        {{ $item->nama_barang }}
                                    </div>

                                    <div class="inventory-muted">
                                        {{ $item->kategori ?: 'Kategori belum diisi' }}
                                        ·
                                        {{ $item->merk ?: 'Merek belum diisi' }}
                                    </div>
                                </td>

                                {{-- KONDISI --}}
                                <td>
                                    @php
                                        $kondisi = $item->kondisi_barang ?? 'Belum diketahui';

                                        $kondisiClass = match ($kondisi) {
                                            'Baik' => 'inventory-badge-good',
                                            'Perlu Perbaikan' => 'inventory-badge-warning',
                                            'Rusak' => 'inventory-badge-danger',
                                            default => 'inventory-badge-neutral',
                                        };
                                    @endphp

                                    <span class="inventory-badge {{ $kondisiClass }}">
                                        {{ $kondisi }}
                                    </span>
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @php
                                        $status = $item->status_barang ?? 'Belum diketahui';

                                        $statusClass = match ($status) {
                                            'Tersedia' => 'inventory-badge-good',
                                            'Dipinjam' => 'inventory-badge-warning',
                                            'Dalam Pemeliharaan' => 'inventory-badge-danger',
                                            default => 'inventory-badge-neutral',
                                        };
                                    @endphp

                                    <span class="inventory-badge {{ $statusClass }}">
                                        {{ $status }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="inventory-row-actions">

                                        <a
                                            href="{{ route('items.edit', [
                                                'item' => $item->id,
                                                'studio' => $namaStudio
                                            ]) }}"
                                            class="inventory-action-link"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('items.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus barang {{ addslashes($item->nama_barang) }}?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <input
                                                type="hidden"
                                                name="studio"
                                                value="{{ $studio }}"
                                            >

                                            <button
                                                type="submit"
                                                class="inventory-action-link inventory-action-delete"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- JIKA BARANG KOSONG --}}
            <div class="inventory-empty">

                <h4>
                    {{ request('search') ? 'Barang tidak ditemukan' : 'Belum ada barang inventaris' }}
                </h4>

                <p>
                    @if (request('search'))
                        Tidak ada barang yang cocok dengan kata kunci pencarian.
                        Coba kata kunci lain.
                    @else
                        Belum ada barang yang terdaftar untuk {{ $namaStudio }}.
                        Tambahkan barang untuk mulai mengelola inventaris.
                    @endif
                </p>

                @if (!request('search'))
                    <a
                        href="{{ route('items.create', ['studio' => $namaStudio]) }}"
                        class="inventory-btn"
                    >
                        + Tambah Barang Pertama
                    </a>
                @endif

            </div>

        @endif

    </div>

</div>

@endsection
