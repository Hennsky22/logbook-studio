@extends('layouts.app')







@section('title', 'Laporan Logbook')







@section('page-title', 'Laporan Logbook')







@section('content')







<style>



    .report-heading {



        display: flex;



        justify-content: space-between;



        align-items: center;



        gap: 16px;



        flex-wrap: wrap;



        margin-bottom: 24px;



    }







    .report-heading h1 {



        margin: 0 0 7px;



        color: #183b50;



        font-size: 25px;



    }







    .report-heading p {



        margin: 0;



        color: #718096;



        font-size: 13px;



    }







    .report-filter-grid {



        display: grid;



        grid-template-columns: repeat(3, minmax(0, 1fr));



        gap: 18px;



        align-items: end;



    }







    .report-filter-actions {



        display: flex;



        gap: 8px;



        flex-wrap: wrap;



    }







    .report-summary {



        margin-bottom: 24px;



    }







    .report-section {



        margin-top: 26px;



    }







    .report-section-header {



        display: flex;



        justify-content: space-between;



        align-items: center;



        gap: 12px;



        flex-wrap: wrap;



        margin-bottom: 18px;



    }







    .report-section-header h3 {



        margin: 0 0 6px;



        color: #183b50;



        font-size: 18px;



    }







    .report-section-header p {



        margin: 0;



        color: #718096;



        font-size: 12px;



    }







    .report-table-scroll {



        overflow-x: auto;



        width: 100%;



    }







    .report-data-table {



        width: 100%;



        border-collapse: collapse;



        font-size: 12px;



    }







    .report-data-table th {



        padding: 14px;



        text-align: left;



        white-space: nowrap;



        color: #60717e;



        background: #f7fafb;



        font-size: 10px;



        letter-spacing: .4px;



    }







    .report-data-table td {



        padding: 14px;



        border-top: 1px solid #edf1f3;



        color: #334155;



        vertical-align: top;



    }







    .report-data-table tbody tr:hover {



        background: #fbfdfd;



    }







    .report-status {



        display: inline-block;



        padding: 6px 10px;



        border-radius: 20px;



        font-size: 10px;



        font-weight: 700;



        white-space: nowrap;



    }







    .report-status-good {



        background: #e8f6ed;



        color: #237443;



    }







    .report-status-bad {



        background: #ffebeb;



        color: #b83232;



    }







    .report-status-neutral {



        background: #edf2f7;



        color: #526171;



    }







    .report-muted {



        margin-top: 5px;



        color: #82909b;



        font-size: 11px;



        line-height: 1.6;



    }







    .report-empty {



        padding: 28px 16px !important;



        text-align: center;



        color: #718096 !important;



        line-height: 1.8;



    }







    .report-signature {



        width: 90px;



        height: 75px;



        object-fit: contain;



        padding: 4px;



        background: #f8fafb;



        border: 1px solid #e5eaed;



        border-radius: 7px;



        cursor: pointer;



    }







    .report-signature-link {



        display: inline-block;



    }







    .signature-empty {



        color: #9aa5b1;



        font-size: 11px;



    }







    @media (max-width: 800px) {



        .report-filter-grid {



            grid-template-columns: 1fr;



        }



    }







    @media print {
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body * {
            visibility: hidden !important;
        }

        .report-print-area,
        .report-print-area * {
            visibility: visible !important;
        }

        .report-print-area {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }

        .sidebar,
        .app-sidebar,
        .topbar,
        .report-filter,
        .report-print-button,
        .btn,
        form {
            display: none !important;
        }

        .report-print-area .card {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
            break-inside: auto !important;
            page-break-inside: auto !important;
        }

        .report-table-scroll {
            overflow: visible !important;
            width: 100% !important;
        }

        .report-data-table {
            width: 100% !important;
            font-size: 8px !important;
            page-break-inside: auto;
        }

        .report-data-table thead {
            display: table-header-group;
        }

        .report-data-table tr {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .report-data-table th,
        .report-data-table td {
            padding: 6px !important;
            color: #1f2937 !important;
        }

        .report-signature {
            width: 60px !important;
            height: 48px !important;
        }

        .report-heading h1,
        .report-section-header h3 {
            color: #183b50 !important;
        }

        .report-status {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
    }



</style>

<div class="report-print-area">







<div class="page-heading report-heading">



    <div>



        <h1>Laporan Logbook</h1>



        <p>Rekap aktivitas dan hasil pemeriksaan kondisi barang seluruh studio.</p>



    </div>







    <button



        type="button"



        class="btn report-print-button"



        onclick="window.print()"



    >



        Cetak Laporan



    </button>



</div>







{{-- FILTER LAPORAN --}}



<div class="card report-filter">



    <h3 class="card-title">Filter Laporan</h3>







    <form action="{{ route('reports.index') }}" method="GET">



        <div class="report-filter-grid">







            <div class="form-group">



                <label for="studio">Pilih Studio</label>







                <select name="studio" id="studio" class="form-control">



                    <option value="">Semua Studio</option>







                    <option value="berita" @selected(request('studio') === 'berita')>



                        Studio Berita



                    </option>







                    <option value="penyiaran" @selected(request('studio') === 'penyiaran')>



                        Studio Penyiaran



                    </option>







                    <option value="mcr" @selected(request('studio') === 'mcr')>



                        Master Control Room



                    </option>



                </select>



            </div>







            <div class="form-group">



                <label for="tanggal_mulai">Tanggal Mulai</label>







                <input



                    type="date"



                    id="tanggal_mulai"



                    name="tanggal_mulai"



                    class="form-control"



                    value="{{ request('tanggal_mulai') }}"



                >



            </div>







            <div class="form-group">



                <label for="tanggal_akhir">Tanggal Akhir</label>







                <input



                    type="date"



                    id="tanggal_akhir"



                    name="tanggal_akhir"



                    class="form-control"



                    value="{{ request('tanggal_akhir') }}"



                >



            </div>







            <div class="report-filter-actions">



                <button type="submit" class="btn">



                    Terapkan Filter



                </button>







                <a href="{{ route('reports.index') }}" class="btn btn-outline">



                    Reset



                </a>



            </div>







        </div>



    </form>



</div>







{{-- RINGKASAN LOGBOOK --}}



<div class="dashboard-cards report-summary">







    <div class="card stat-card">



        <div class="stat-icon">▤</div>



        <p>Total Kegiatan</p>



        <h2>{{ $totalLogbook }}</h2>



        <small>Sesuai filter yang dipilih</small>



    </div>







    <div class="card stat-card">



        <div class="stat-icon">✓</div>



        <p>Kondisi Normal</p>



        <h2>{{ $totalNormal }}</h2>



        <small>Kegiatan dengan kondisi normal</small>



    </div>







    <div class="card stat-card">



        <div class="stat-icon">!</div>



        <p>Perlu Perbaikan</p>



        <h2>{{ $totalPerluPerbaikan }}</h2>



        <small>Kegiatan yang perlu ditangani</small>



    </div>







    <div class="card stat-card">



        <div class="stat-icon">◷</div>



        <p>Belum Selesai</p>



        <h2>{{ $totalBelumSelesai }}</h2>



        <small>Kegiatan yang belum selesai</small>



    </div>







</div>







{{-- TABEL LOGBOOK --}}



<div class="card report-section">







    <div class="report-section-header">



        <div>



            <h3>Detail Kegiatan</h3>



            <p>Ditemukan {{ $totalLogbook }} catatan kegiatan.</p>



        </div>



    </div>







    <div class="report-table-scroll">



        <table class="report-data-table">







            <thead>



                <tr>



                    <th>TANGGAL</th>



                    <th>STUDIO</th>



                    <th>WAKTU</th>



                    <th>NAMA KEGIATAN</th>



                    <th>PETUGAS</th>



                    <th>KONDISI AKHIR</th>



                </tr>



            </thead>







            <tbody>



                @forelse ($logbooks as $logbook)



                    <tr>



                        <td>



                            {{ \Carbon\Carbon::parse($logbook->tanggal)->format('d/m/Y') }}



                        </td>







                        <td>



                            @switch($logbook->studio)



                                @case('berita')



                                    Studio Berita



                                    @break







                                @case('penyiaran')



                                    Studio Penyiaran



                                    @break







                                @case('mcr')



                                    Master Control Room



                                    @break







                                @default



                                    {{ $logbook->studio }}



                            @endswitch



                        </td>







                        <td>



                            {{ substr($logbook->jam_mulai, 0, 5) }}



                            –



                            {{ substr($logbook->jam_selesai, 0, 5) }}



                        </td>







                        <td>{{ $logbook->nama_kegiatan }}</td>







                        <td>{{ $logbook->petugas }}</td>







                        <td>



                            <span class="report-status report-status-neutral">



                                {{ $logbook->kondisi_akhir ?: 'Belum diisi' }}



                            </span>



                        </td>



                    </tr>



                @empty



                    <tr>



                        <td colspan="6" class="report-empty">



                            Tidak ada data logbook untuk filter ini.



                        </td>



                    </tr>



                @endforelse



            </tbody>







        </table>



    </div>



</div>







{{-- RINGKASAN CHECKLIST --}}



<div class="dashboard-cards report-summary report-section">







    <div class="card stat-card">



        <div class="stat-icon">▤</div>



        <p>Total Pemeriksaan Barang</p>



        <h2>{{ $totalPemeriksaan }}</h2>



        <small>Catatan pemeriksaan sesuai filter</small>



    </div>







    <div class="card stat-card">



        <div class="stat-icon">✓</div>



        <p>Barang Kondisi Baik</p>



        <h2>{{ $totalKondisiBaik }}</h2>



        <small>Hasil pemeriksaan berkondisi baik</small>



    </div>







    <div class="card stat-card">



        <div class="stat-icon">!</div>



        <p>Barang Kondisi Rusak</p>



        <h2>{{ $totalKondisiRusak }}</h2>



        <small>Barang yang perlu ditindaklanjuti</small>



    </div>







</div>







{{-- TABEL LAPORAN PEMERIKSAAN BARANG --}}



<div class="card report-section">







    <div class="report-section-header">



        <div>



            <h3>Laporan Pemeriksaan Kondisi Barang</h3>



            <p>



                Ditemukan {{ $totalPemeriksaan }} catatan pemeriksaan.



                Riwayat tanggal sebelumnya tetap ditampilkan.



            </p>



        </div>



    </div>







    <div class="report-table-scroll">







        <table class="report-data-table">







            <thead>



                <tr>



                    <th>TANGGAL</th>



                    <th>STUDIO</th>



                    <th>NAMA BARANG</th>



                    <th>KONDISI</th>



                    <th>KETERANGAN BARANG</th>
<th>PETUGAS PEMERIKSA</th>



                    <th>TANDA TANGAN</th>



                </tr>



            </thead>







            <tbody>







                @forelse ($pemeriksaan as $hasil)







                    <tr>







                        <td>



                            {{ \Carbon\Carbon::parse($hasil->tanggal_pemeriksaan)->format('d/m/Y') }}



                        </td>







                        <td>



                            {{ $hasil->item->studio ?? 'Studio tidak diketahui' }}



                        </td>







                        <td>



                            <strong>



                                {{ $hasil->item->nama_barang ?? 'Barang tidak ditemukan' }}



                            </strong>







                            @if ($hasil->item)



                                <div class="report-muted">



                                    ID Barang: {{ $hasil->item->id }}



                                </div>



                            @endif



                        </td>







                        <td>



                            @if ($hasil->kondisi === 'Baik')



                                <span class="report-status report-status-good">



                                    Baik



                                </span>



                            @elseif ($hasil->kondisi === 'Rusak')



                                <span class="report-status report-status-bad">



                                    Rusak



                                </span>



                            @else



                                <span class="report-status report-status-neutral">



                                    {{ $hasil->kondisi }}



                                </span>



                            @endif



                        </td>







                        {{-- KETERANGAN KHUSUS BARANG / TROUBLE SHOOTING --}}
                        <td>
                            @if (!empty($hasil->catatan))
                                {{ $hasil->catatan }}
                            @else
                                <span class="report-muted">Tidak ada catatan barang</span>
                            @endif
                        </td>
<td>



                            {{ $hasil->user->name ?? 'Pengguna tidak ditemukan' }}



                        </td>







                        <td>



                            @if (!empty($hasil->foto_tanda_tangan))



                                <a



                                    href="{{ asset('storage/' . $hasil->foto_tanda_tangan) }}"



                                    target="\_blank"



                                    rel="noopener noreferrer"



                                    class="report-signature-link"



                                    title="Lihat foto tanda tangan"



                                >



                                    <img



                                        src="{{ asset('storage/' . $hasil->foto_tanda_tangan) }}"



                                        alt="Foto tanda tangan petugas"



                                        class="report-signature"



                                        loading="lazy"



                                    >



                                </a>



                            @else



                                <span class="signature-empty">



                                    Belum ada foto



                                </span>



                            @endif



                        </td>







                    </tr>







                @empty







                    <tr>



                        <td colspan="7" class="report-empty">



                            Belum ada hasil pemeriksaan barang untuk filter ini.



                            <br>



                            Pastikan petugas sudah menyimpan checklist dari akun User.



                        </td>



                    </tr>







                @endforelse







            </tbody>







        </table>







    </div>



</div>











{{-- LAPORAN PENYELESAIAN CHECKLIST --}}



<div class="card report-section">



    <div class="report-section-header">

        <div>

            <h3>Laporan Penyelesaian Checklist</h3>

            <p>

                Riwayat kepala studio yang menyimpan seluruh pemeriksaan

                beserta waktu penyelesaiannya.

            </p>

        </div>

    </div>



    <div class="report-table-scroll">

        <table class="report-data-table">

            <thead>

                <tr>

                    <th>TANGGAL</th>

                    <th>STUDIO</th>

                    <th>KEPALA STUDIO</th>

                    <th>WAKTU SUBMIT</th>

                    <th>STATUS</th>

                </tr>

            </thead>



            <tbody>

                @forelse ($laporanPenyelesaian as $laporan)

                    <tr>

                        <td>

                            {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}

                        </td>



                        <td>{{ $laporan->studio }}</td>



                        <td>

                            <strong>

                                {{ $laporan->nama_kepala_studio ?? 'Pengguna tidak ditemukan' }}

                            </strong>

                        </td>



                        <td>

                            {{ $laporan->waktu_submit

                                ? $laporan->waktu_submit->format('H:i:s') . ' WIB'

                                : '-' }}

                        </td>



                        <td>

                            <span class="report-status report-status-good">

                                Sudah Disubmit

                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="report-empty">

                            Belum ada data penyelesaian checklist.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>



</div>





{{-- LAPORAN PERSONEL UNIT KERJA --}}



<div class="card report-section">



    <div class="report-section-header">

        <div>

            <h3>Laporan Personel Unit Kerja</h3>

            <p>

                Daftar personel yang bertugas berdasarkan studio

                dan tanggal pemeriksaan.

            </p>

        </div>

    </div>



    <div class="report-table-scroll">

        <table class="report-data-table">

            <thead>

                <tr>

                    <th>TANGGAL</th>

                    <th>STUDIO</th>

                    <th>UNIT KERJA</th>

                    <th>NAMA CREW</th>

                </tr>

            </thead>



            <tbody>

                @forelse ($personelUnitKerja as $personel)

                    <tr>

                        <td>

                            {{ \Carbon\Carbon::parse($personel->tanggal)->format('d/m/Y') }}

                        </td>



                        <td>{{ $personel->studio }}</td>



                        <td>

                            <strong>{{ $personel->nama_crew }}</strong>

                        </td>



                        <td>

                            @if (!empty($personel->keterangan))

                                {{ $personel->keterangan }}

                            @else

                                <span class="report-muted">Belum diisi</span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="report-empty">

                            Belum ada data personel unit kerja untuk filter ini.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>



</div>





</div>


{{-- LAPORAN KETERANGAN HARI INI (GLOBAL) --}}
<div class="card report-section">
    <div class="report-section-header">
        <div>
            <h3>Laporan Keterangan Hari Ini</h3>
            <p>Keterangan umum kegiatan atau kondisi studio yang diisi petugas, terpisah dari catatan masing-masing barang.</p>
        </div>
    </div>

    <div class="report-table-scroll">
        <table class="report-data-table">
            <thead>
                <tr>
                    <th>TANGGAL</th>
                    <th>STUDIO</th>
                    <th>PETUGAS</th>
                    <th>KETERANGAN HARI INI</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporanKeteranganHarian as $catatan)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($catatan->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $catatan->studio }}</td>
                        <td><strong>{{ $catatan->user->name ?? 'Pengguna tidak ditemukan' }}</strong></td>
                        <td>{{ $catatan->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="report-empty">
                            Belum ada keterangan harian untuk filter ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tombolCetak = document.querySelector('.report-print-button');

        if (tombolCetak) {
            tombolCetak.addEventListener('click', function () {
                window.print();
            });
        }
    });
</script>

@endsection
