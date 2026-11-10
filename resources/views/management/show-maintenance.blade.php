
@extends('layouts.app')

@section('title', 'Detail Pemeliharaan')
@section('page-title', 'Detail Pemeliharaan')

@section('content')
<div class="maintenance-page">

    
<div class="maintenance-heading" style="display:flex; justify-content:space-between; align-items:center; width:100%; gap:20px;">
    <div>
        <h2>Detail Pemeliharaan</h2>
        <p>Informasi lengkap kerusakan dan perbaikan peralatan.</p>
    </div>

    <a href="{{ route('maintenance.index') }}"
       class="btn"
       style="margin-left:auto; flex-shrink:0;">
        Kembali
    </a>
</div>


    <div class="maintenance-card">
        <div class="maintenance-card-heading">
            <h3>Catatan Pemeliharaan #{{ $pemeliharaan->id }}</h3>
            <p>Informasi barang dan riwayat penanganan.</p>
        </div>

        <div style="padding:24px;">
            <div class="table-wrapper">
                <table>
                    <tbody>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $pemeliharaan->item->nama_barang ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Rusak</th>
                            <td>{{ $pemeliharaan->tanggal_rusak?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Perbaikan</th>
                            <td>{{ $pemeliharaan->tanggal_perbaikan?->format('d/m/Y') ?? 'Belum diperbaiki' }}</td>
                        </tr>
                        <tr>
                            <th>Kerusakan</th>
                            <td>{{ $pemeliharaan->kerusakan ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Penanganan</th>
                            <td>{{ $pemeliharaan->penanganan ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="maintenance-status">
                                    {{ $pemeliharaan->status ?? 'Menunggu Perbaikan' }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-grid" style="margin-top:28px;">
                <div class="form-group">
                    <label>Foto Sebelum Perbaikan</label>

                    @if ($pemeliharaan->foto_awal)
                        <a href="{{ asset('storage/'.$pemeliharaan->foto_awal) }}"
                           target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('storage/'.$pemeliharaan->foto_awal) }}"
                                 alt="Foto sebelum perbaikan"
                                 style="max-width:100%;width:320px;border-radius:10px;">
                        </a>
                    @else
                        <p>Belum ada foto.</p>
                    @endif
                </div>

                <div class="form-group">
                    <label>Foto Sesudah Perbaikan</label>

                    @if ($pemeliharaan->foto_sesudah)
                        <a href="{{ asset('storage/'.$pemeliharaan->foto_sesudah) }}"
                           target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('storage/'.$pemeliharaan->foto_sesudah) }}"
                                 alt="Foto sesudah perbaikan"
                                 style="max-width:100%;width:320px;border-radius:10px;">
                        </a>
                    @else
                        <p>Belum ada foto.</p>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('maintenance.edit', $pemeliharaan->id) }}"
                   class="btn">
                    Edit Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
