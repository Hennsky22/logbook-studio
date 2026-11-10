
@extends('layouts.app')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@section('content')
<style>
    .loan-detail-card {
        background: #fff;
        border: 1px solid #e6edf2;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(20,45,70,.04);
        overflow: hidden;
    }

    .loan-detail-heading {
        padding: 24px;
        border-bottom: 1px solid #e6edf2;
    }

    .loan-detail-heading h2 {
        margin: 0 0 8px;
        color: #243b53;
        font-size: 22px;
    }

    .loan-detail-heading p {
        margin: 0;
        color: #8293a7;
    }

    .loan-detail-grid {
        display: grid;
        grid-template-columns: repeat(2,minmax(0,1fr));
        gap: 22px;
        padding: 24px;
    }

    .loan-detail-label {
        display: block;
        margin-bottom: 7px;
        color: #8293a7;
        font-size: 13px;
    }

    .loan-detail-value {
        color: #243b53;
        font-size: 15px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    @media(max-width:600px) {
        .loan-detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="maintenance-page">
    <div class="maintenance-heading">
        <div class="maintenance-heading-text">
            <h2>Detail Peminjaman</h2>
            <p>Informasi lengkap peminjaman dan pengembalian barang.</p>
        </div>

        <a href="{{ route('loans.index') }}"
           class="btn maintenance-add-btn">
            Kembali
        </a>
    </div>

    <div class="loan-detail-card">
        <div class="loan-detail-heading">
            <h2>{{ $peminjaman->item->nama_barang ?? 'Barang tidak ditemukan' }}</h2>
            <p>Informasi transaksi peminjaman barang studio.</p>
        </div>

        <div class="loan-detail-grid">
            <div>
                <span class="loan-detail-label">Tanggal Peminjaman</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->tanggal_pinjam
                        ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y')
                        : '-' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Tanggal Rencana Kembali</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->tanggal_rencana_kembali
                        ? \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d/m/Y')
                        : '-' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Tanggal Pengembalian</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->tanggal_kembali
                        ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y')
                        : 'Belum dikembalikan' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Studio</span>
                <div class="loan-detail-value">
                    @php
                        $studio = $peminjaman->logbook->studio ?? '-';
                    @endphp

                    @if ($studio === 'berita')
                        Studio Berita
                    @elseif ($studio === 'penyiaran')
                        Studio Penyiaran
                    @elseif ($studio === 'mcr')
                        Master Control Room
                    @else
                        {{ $studio }}
                    @endif
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Kegiatan</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->logbook->nama_kegiatan ?? '-' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Peminjam</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->petugas->name
                        ?? $peminjaman->logbook->petugas
                        ?? '-' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Nama Barang</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->item->nama_barang ?? '-' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Serial Number</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->item->serial_number ?? '-' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Kondisi Awal</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->kondisi_awal ?? '-' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Kondisi Kembali</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->kondisi_kembali ?? '-' }}
                </div>
            </div>

            <div>
                <span class="loan-detail-label">Status Peminjaman</span>
                <div class="loan-detail-value">
                    {{ $peminjaman->status ?? 'Dipinjam' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
