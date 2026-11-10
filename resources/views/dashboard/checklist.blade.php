<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checklist Pemeriksaan | Logbook Studio</title>

   <link rel="icon" type="image/png"

      href="{{ asset('images/logbook-logo.png') }}?v=2">

    <style>

        * {

            box-sizing: border-box;

        }

        body {

            margin: 0;

            padding: 20px;

            font-family: "Segoe UI", Arial, sans-serif;

            background: #f7f6f0;

            color: #263d39;

        }

        .checklist-page {

            max-width: 1500px;

            margin: auto;

        }

        /* HEADER */

        .checklist-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 22px;

        }

        .checklist-header h2 {

            margin: 0;

            font-size: 25px;

            font-weight: 700;

            color: #245b56;

        }

        .checklist-header p {

            margin: 6px 0 0;

            color: #788783;

            font-size: 13px;

        }

        .header-info {

            display: flex;

            align-items: center;

            justify-content: flex-end;

            gap: 10px;

            flex-shrink: 0;

        }

        .date-badge,

        .user-badge {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 11px 16px;

            border-radius: 10px;

            font-size: 13px;

            font-weight: 600;

            white-space: nowrap;

            min-height: 42px;

        }

        .date-badge {

            background: #e8efea;

            color: #245b56;

        }

        .user-badge {

            background: #245b56;

            color: #fff;

        }

        /* ALERT */

        .checklist-alert {

            padding: 12px 16px;

            border-radius: 9px;

            margin-bottom: 18px;

            font-size: 13px;

        }

        .checklist-alert.success {

            position: fixed;

            top: 22px;

            left: 50%;

            transform: translateX(-50%);

            z-index: 9999;

            width: max-content;

            max-width: min(90vw, 520px);

            padding: 14px 22px;

            margin: 0;

            border: 1px solid #b9ddc2;

            border-radius: 12px;

            background: #e4f2e8;

            color: #28623c;

            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.14);

            text-align: center;

            opacity: 1;

            visibility: visible;

            transition: opacity .45s ease, transform .45s ease, visibility .45s ease;

        }

        .checklist-alert.success.hide {

            opacity: 0;

            visibility: hidden;

            transform: translate(-50%, -12px);

        }

        .checklist-alert.error {

            background: #fbe9e7;

            color: #a33c32;

        }

        /* POPUP KONFIRMASI DAN BERHASIL */
        .checklist-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(18, 32, 29, 0.38);
            -webkit-backdrop-filter: blur(6px);
            backdrop-filter: blur(6px);
        }

        .checklist-modal {
            width: 100%;
            max-width: 430px;
            padding: 30px 28px 26px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 18px 60px rgba(0, 0, 0, 0.22);
            text-align: center;
            animation: checklistModalIn .2s ease-out;
        }

        .checklist-modal-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 30px;
            font-weight: 700;
        }

        .success-icon {
            color: #24734d;
            background: #e5f5eb;
        }

        .question-icon {
            color: #245b56;
            background: #e8f1ee;
        }

        .checklist-modal h3 {
            margin: 0 0 9px;
            color: #173f3b;
            font-size: 20px;
            font-weight: 700;
        }

        .checklist-modal p {
            margin: 0;
            color: #687873;
            font-size: 14px;
            line-height: 1.6;
        }

        .checklist-modal-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 25px;
        }

        .checklist-modal-primary,
        .checklist-modal-secondary {
            min-width: 125px;
            padding: 11px 18px;
            border: 0;
            border-radius: 9px;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .checklist-modal-primary {
            color: #fff;
            background: #245b56;
        }

        .checklist-modal-primary:hover {
            background: #194944;
        }

        .checklist-modal-secondary {
            color: #34524c;
            background: #edf1ef;
        }

        .checklist-modal-secondary:hover {
            background: #e1e9e5;
        }

        @keyframes checklistModalIn {
            from { opacity: 0; transform: translateY(10px) scale(.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* LAYOUT */

        .checklist-layout {

            display: grid;

            grid-template-columns: minmax(300px, 0.9fr) minmax(0, 1.5fr);

            gap: 20px;

            align-items: start;

        }

        .checklist-card {

            background: #fff;

            border: 1px solid #e8ece8;

            border-radius: 14px;

            padding: 20px;

            box-shadow: 0 3px 12px rgba(30, 60, 50, 0.04);

            min-width: 0;

        }

        .card-heading {

            margin-bottom: 16px;

        }

        .card-heading h3 {

            margin: 0;

            color: #245b56;

            font-size: 17px;

            font-weight: 700;

        }

        .card-heading p {

            margin: 5px 0 0;

            font-size: 12px;

            color: #89948f;

        }

        /* TABEL PERSONEL */

        .crew-table {

            width: 100%;

            border-collapse: collapse;

            font-size: 13px;

        }

        .crew-table th {

            background: #edf3ef;

            color: #315c52;

            font-weight: 700;

            text-align: left;

            padding: 11px 8px;

        }

        .crew-table td {

            padding: 10px 8px;

            border-bottom: 1px solid #edf0ed;

            vertical-align: middle;

        }

        .crew-table th:first-child,

        .crew-table td:first-child {

            width: 35px;

            text-align: center;

        }

        .crew-table input {

            width: 100%;

            min-width: 80px;

            border: 1px solid #dce4de;

            border-radius: 7px;

            padding: 9px;

            font-size: 13px;

            outline: none;

        }

        .crew-table input:focus,

        .form-control:focus,

        .daily-note:focus {

            border-color: #6c9b8e;

            box-shadow: 0 0 0 3px rgba(108, 155, 142, 0.12);

        }

        /* BAGIAN KANAN */

        .right-content {

            display: flex;

            flex-direction: column;

            gap: 20px;

            min-width: 0;

        }

        .item-form-grid {

            display: grid;

            grid-template-columns: 1.15fr 1fr 1.2fr;

            gap: 14px;

            align-items: stretch;

        }

        .troubleshooting-note {

            width: 100%;

            min-height: 92px;

            resize: vertical;

            border: 1px solid #dce4de;

            border-radius: 8px;

            padding: 11px;

            font-family: inherit;

            font-size: 13px;

            color: #344b44;

            outline: none;

            background: #fff;

        }

        .troubleshooting-note:focus {

            border-color: #6c9b8e;

            box-shadow: 0 0 0 3px rgba(108, 155, 142, 0.12);

        }

        .field-panel {

            background: #f8faf8;

            border: 1px solid #e8eee9;

            border-radius: 10px;

            padding: 15px;

            min-width: 0;

        }

        .field-panel label {

            display: block;

            font-size: 13px;

            font-weight: 700;

            color: #45665c;

            margin-bottom: 10px;

        }

        .form-control {

            width: 100%;

            border: 1px solid #dce4de;

            background: #fff;

            border-radius: 8px;

            padding: 11px;

            font-size: 13px;

            color: #344b44;

            outline: none;

        }

        .condition-options {

            display: flex;

            gap: 10px;

            flex-wrap: wrap;

        }

        .condition-option {

            display: flex;

            align-items: center;

            gap: 7px;

            padding: 10px 12px;

            background: #fff;

            border: 1px solid #dce4de;

            border-radius: 8px;

            font-size: 13px;

            cursor: pointer;

        }

        .condition-option input {

            accent-color: #39766a;

        }

        .condition-option:has(input:checked) {

            border-color: #6c9b8e;

            background: #edf5f0;

        }

        /* BARANG DIPERIKSA */

        .checked-items {

            margin-top: 18px;

            border-top: 1px solid #edf0ed;

            padding-top: 15px;

        }

        .checked-items h4 {

            margin: 0 0 10px;

            color: #45665c;

            font-size: 13px;

        }

        .checked-item-row {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 10px;

            padding: 9px 0;

            border-bottom: 1px solid #f0f2f0;

            font-size: 12px;

        }

        .condition-badge {

            padding: 4px 9px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 700;

            white-space: nowrap;

        }

        .condition-good {

            color: #28623c;

            background: #e4f2e8;

        }

        .condition-bad {

            color: #a33c32;

            background: #fbe9e7;

        }

        .condition-error {

            color: #8a5a00;

            background: #fff2cc;

        }

        .empty-state {

            color: #929c97;

            font-size: 12px;

            padding: 10px 0;

        }

        /* KETERANGAN */

        .daily-note {

            width: 100%;

            min-height: 125px;

            resize: vertical;

            border: 1px solid #dce4de;

            border-radius: 8px;

            padding: 12px;

            font-family: inherit;

            font-size: 13px;

            outline: none;

        }

        /* TOMBOL SIMPAN */

        .btn-submit {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border: none;

            background: #245b56;

            color: #fff;

            padding: 11px 18px;

            border-radius: 8px;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;

            margin-top: 14px;

            transition: 0.2s;

        }

        .btn-submit:hover {

            background: #194740;

        }

        .btn-submit:disabled {

            opacity: 0.5;

            cursor: not-allowed;

        }

        /* TOMBOL KEMBALI */

        .btn-back {

            display: flex;

            width: fit-content;

            align-items: center;

            justify-content: center;

            gap: 8px;

            margin-top: 10px;

            padding: 10px 16px;

            background: #f1f5f2;

            color: #245b56;

            border: 1px solid #dce8e0;

            border-radius: 8px;

            font-size: 13px;

            font-weight: 600;

            text-decoration: none;

            transition: 0.2s;

        }

        .btn-back:hover {

            background: #e3ede7;

            color: #194740;

        }

        /* KETERANGAN DAN TANDA TANGAN */

        .bottom-panels {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 20px;

            align-items: stretch;

        }

        .signature-space {

            min-height: 160px;

            display: flex;

            flex-direction: column;

            justify-content: flex-end;

            align-items: center;

        }

        .signature-name {

            font-size: 14px;

            font-weight: 700;

            color: #263d39;

            text-align: center;

            margin-bottom: 8px;

        }

        .signature-line {

            border-top: 1px solid #78837c;

            width: 75%;

            margin-bottom: 8px;

        }

        .signature-caption {

            text-align: center;

            color: #89948f;

            font-size: 12px;

        }

        .signature-upload {

    width: 100%;

    text-align: center;

    margin-bottom: 18px;

}

.signature-preview {

    width: 100%;

    max-width: 260px;

    height: 140px;

    object-fit: contain;

    display: none;

    margin: 0 auto 12px;

    border: 1px dashed #b9cbc1;

    border-radius: 10px;

    background: #f8faf8;

    padding: 8px;

}

.signature-placeholder {

    width: 100%;

    max-width: 260px;

    height: 140px;

    margin: 0 auto 12px;

    border: 1px dashed #b9cbc1;

    border-radius: 10px;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    gap: 8px;

    color: #89948f;

    background: #f8faf8;

    font-size: 12px;

}

.btn-upload {

    display: inline-block;

    padding: 10px 16px;

    border-radius: 8px;

    background: #245b56;

    color: white;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;

}

.btn-upload:hover {

    background: #194740;

}

.signature-upload input[type="file"] {

    display: none;

}

        /* SIMPAN SEMUA */

        .save-all-section {

            margin-top: 20px;

            padding: 20px;

            background: #fff;

            border: 1px solid #e8ece8;

            border-radius: 14px;

            box-shadow: 0 3px 12px rgba(30, 60, 50, 0.04);

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

        }

        .save-all-info h3 {

            margin: 0;

            color: #245b56;

            font-size: 16px;

        }

        .save-all-info p {

            margin: 5px 0 0;

            color: #89948f;

            font-size: 12px;

        }

        .btn-save-all {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            border: none;

            background: #245b56;

            color: #fff;

            padding: 13px 22px;

            border-radius: 9px;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            white-space: nowrap;

            transition: 0.2s;

        }

        .btn-save-all:hover {

            background: #194740;

            transform: translateY(-1px);

        }

        /* RESPONSIVE */

        @media (max-width: 900px) {

            .checklist-layout {

                grid-template-columns: 1fr;

            }

        }

        @media (max-width: 700px) {

            .bottom-panels {

                grid-template-columns: 1fr;

            }

            .checklist-header {

                align-items: flex-start;

            }

            .save-all-section {

                align-items: stretch;

                flex-direction: column;

            }

            .btn-save-all {

                width: 100%;

            }

        }

        @media (max-width: 550px) {

            body {

                padding: 12px;

            }

            .item-form-grid {

                grid-template-columns: 1fr;

            }

            .checklist-card {

                padding: 15px;

            }

            .checklist-header {

                flex-direction: column;

            }

            .header-info {

                width: 100%;

                justify-content: flex-start;

                flex-wrap: wrap;

            }

            .date-badge,

            .user-badge {

                font-size: 12px;

                padding: 10px 12px;

            }

        }


        /* TABEL DATA & KONDISI PERALATAN */
        .equipment-table-wrap {
            width: 100%;
            overflow-x: auto;
            margin-top: 8px;
        }

        .equipment-table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
            table-layout: fixed;
            color: #263d39;
            font-size: 12px;
        }

        .equipment-table th {
            padding: 12px 9px;
            text-align: left;
            font-weight: 700;
            border-bottom: 1px solid #e8ece8;
            white-space: nowrap;
        }

        .equipment-table td {
            padding: 9px;
            border-bottom: 1px solid #edf0ed;
            vertical-align: middle;
        }

        .equipment-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .equipment-table .number-col { width: 5%; }
        .equipment-table .name-col { width: 39%; }
        .equipment-table .condition-col { width: 10%; text-align: center; }
        .equipment-table .note-col { width: 26%; }

        .equipment-table .good-heading { color: #159447; text-align: center; }
        .equipment-table .error-heading { color: #e87522; text-align: center; }
        .equipment-table .bad-heading { color: #dc3545; text-align: center; }

        .equipment-radio {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 24px;
            margin: 0;
            cursor: pointer;
        }

        .equipment-radio input {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: #245b56;
            cursor: pointer;
        }

        .equipment-note {
            width: 100%;
            min-width: 100px;
            border: 0;
            border-radius: 7px;
            background: #f1f2f1;
            padding: 7px 9px;
            font: inherit;
            color: #344b44;
            outline: none;
        }

        .equipment-note:focus {
            background: #fff;
            border: 1px solid #6c9b8e;
            box-shadow: 0 0 0 3px rgba(108, 155, 142, 0.12);
        }

        .equipment-hint {
            margin: 14px 0 0;
            color: #89948f;
            font-size: 12px;
        }

        @media (max-width: 550px) {
            .equipment-table { min-width: 700px; }
        }

    </style>

</head>

<body>

<div class="checklist-page">

    {{-- HEADER --}}

    <div class="checklist-header">

        <div>

            <h2>Checklist Pemeriksaan</h2>

            <p>Pemeriksaan harian {{ $studio }}</p>

        </div>

        <div class="header-info">

            <div class="date-badge">

                <span>📅</span>

                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}

            </div>

            <div class="user-badge">

                <span>👤</span>

                {{ auth()->user()->name ?? 'Pengguna' }}

            </div>

        </div>

    </div>

    {{-- NOTIFIKASI --}}

    @if(session('success'))
        <div class="checklist-modal-backdrop" id="successModal" role="dialog" aria-modal="true" aria-labelledby="successModalTitle">
            <div class="checklist-modal">
                <div class="checklist-modal-icon success-icon">✓</div>
                <h3 id="successModalTitle">Berhasil Disimpan!</h3>
                <p>{{ session('success') }}</p>
                <button type="button" class="checklist-modal-primary" id="successModalClose">Oke</button>
            </div>
        </div>
    @endif

    @if($errors->any())

        <div class="checklist-alert error">

            <strong>Periksa kembali data yang dimasukkan:</strong>

            <ul style="margin: 6px 0 0 18px;">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- POPUP KONFIRMASI SEBELUM MENYIMPAN --}}
    <div class="checklist-modal-backdrop" id="confirmSaveModal" style="display:none;" role="dialog" aria-modal="true" aria-labelledby="confirmSaveTitle">
        <div class="checklist-modal">
            <div class="checklist-modal-icon question-icon">?</div>
            <h3 id="confirmSaveTitle">Konfirmasi Penyimpanan</h3>
            <p>Apakah kamu yakin ingin menyimpan seluruh pemeriksaan?</p>
            <div class="checklist-modal-actions">
                <button type="button" class="checklist-modal-secondary" id="cancelSaveButton">Batal</button>
                <button type="button" class="checklist-modal-primary" id="confirmSaveButton">Ya, Simpan</button>
            </div>
        </div>
    </div>

    {{-- FORM UTAMA --}}

    <form id="checklistMainForm" action="{{ route('dashboard.checklist.all') }}"

      method="POST"

      enctype="multipart/form-data">

        @csrf

        <input type="hidden" name="studio" value="{{ $studio }}">

        <div class="checklist-layout">

            {{-- PERSONEL UNIT KERJA --}}

            <section class="checklist-card">

                <div class="card-heading">

                    <h3>Personel Unit Kerja</h3>

                    <p>Isi nama crew untuk masing-masing unit kerja.</p>

                </div>

                <div style="overflow-x: auto;">

                    <table class="crew-table">

                        <thead>

                            <tr>

                                <th>No.</th>

                                <th>Unit Kerja</th>

                                <th>Nama Crew</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($crewList as $index => $crew)

                                <tr>

                                    <td>{{ $index + 1 }}</td>

                                    <td><strong>{{ $crew }}</strong></td>

                                    <td>

                                        <input

                                            type="text"

                                            name="crew[{{ $crew }}]"

                                            value="{{ old('crew.' . $crew, '') }}"

                                            placeholder="Nama crew..."

                                        >

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                {{-- TOMBOL KEMBALI DI BAWAH TOMBOL SIMPAN --}}

                <a href="{{ url('/dashboard') }}" class="btn-back">

                    <span>←</span>

                    Kembali ke Dashboard

                </a>

            </section>

            {{-- BAGIAN KANAN --}}

            <div class="right-content">

                {{-- DATA & BARANG PERALATAN --}}
                <section class="checklist-card">
                    <div class="card-heading">
                        <h3>Data &amp; Barang Peralatan</h3>
                        <p>Pilih kondisi masing-masing barang dan isi keterangan jika diperlukan.</p>
                    </div>

                    <div style="display:flex; justify-content:flex-end; margin: 4px 0 12px;">
                        <span style="font-size:12px; color:#788783;">Checklist pemeriksaan</span>
                    </div>

                    <div class="equipment-table-wrap">
                        <table class="equipment-table">
                            <thead>
                                <tr>
                                    <th class="number-col">No.</th>
                                    <th class="name-col">Nama Barang</th>
                                    <th class="condition-col good-heading">Baik</th>
                                    <th class="condition-col error-heading">Error</th>
                                    <th class="condition-col bad-heading">Rusak</th>
                                    <th class="note-col">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $index => $item)
                                    @php
                                        // Form selalu tampil kosong saat halaman dibuka kembali.
                                        // Data yang sudah disimpan tetap berada di database dan laporan.
                                        // old() hanya mengisi ulang jika validasi gagal.
                                        $kondisiTerpilih = old(
                                            'pemeriksaan.' . $item->id . '.kondisi',
                                            ''
                                        );
                                        $catatanBarang = old(
                                            'pemeriksaan.' . $item->id . '.catatan',
                                            ''
                                        );
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $item->nama_barang }}</strong></td>

                                        @foreach(['Baik', 'Error', 'Rusak'] as $condition)
                                            <td class="condition-col">
                                                <label class="equipment-radio" title="{{ $condition }}">
                                                    <input
                                                        type="radio"
                                                        name="pemeriksaan[{{ $item->id }}][kondisi]"
                                                        value="{{ $condition }}"
                                                        {{ $kondisiTerpilih === $condition ? 'checked' : '' }}
                                                        aria-label="{{ $item->nama_barang }} - {{ $condition }}"
                                                    >
                                                </label>
                                            </td>
                                        @endforeach

                                        <td>
                                            <input
                                                type="text"
                                                class="equipment-note"
                                                name="pemeriksaan[{{ $item->id }}][catatan]"
                                                value="{{ $catatanBarang }}"
                                                maxlength="1000"
                                                placeholder="Isi..."
                                                aria-label="Keterangan {{ $item->nama_barang }}"
                                            >
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:#89948f; padding:18px;">
                                            Belum ada data peralatan untuk studio ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <p class="equipment-hint">
                        * Daftar barang mengikuti seluruh data inventaris yang sudah ada.
                    </p>
                </section>

                {{-- KETERANGAN DAN TANDA TANGAN --}}

                <div class="bottom-panels">

                    {{-- KETERANGAN HARI INI --}}

                    <section class="checklist-card">

                        <div class="card-heading">

                            <h3>Keterangan Hari Ini</h3>

                            <p>Catatan umum mengenai kegiatan atau hasil pemeriksaan hari ini.</p>

                        </div>

                        <textarea

                            name="keterangan"

                            class="daily-note"

                            placeholder="Tuliskan keterangan pemeriksaan hari ini..."

                        >{{ old('keterangan', '') }}</textarea>

                    </section>

                    {{-- TANDA TANGAN PETUGAS --}}

                    <section class="checklist-card">

                        <div class="card-heading">

                            <h3>Tanda Tangan Petugas</h3>

                            <p>Identitas petugas yang melakukan pemeriksaan.</p>

                        </div>

                        <div class="signature-space">

    <div class="signature-upload">

        <div
            class="signature-placeholder"
            id="signaturePlaceholder"
            style="display:flex;" 
        >
            <span style="font-size: 30px;">📷</span>
            <span>Belum ada foto tanda tangan</span>
        </div>

        <img
            id="signaturePreview"
            class="signature-preview"
            alt="Preview tanda tangan petugas"
            src="" 
            style="display:none;" 
        >

        <label for="signaturePhoto" class="btn-upload">

            📁 Pilih Foto

        </label>

        <input

            type="file"

            name="foto_tanda_tangan"

            id="signaturePhoto"

            accept="image/jpeg,image/png,image/webp"

        >

    </div>

    <div class="signature-name">

        {{ auth()->user()->name ?? 'Petugas' }}

    </div>

    <div class="signature-line"></div>

    <div class="signature-caption">

        Nama jelas dan tanda tangan

    </div>

</div>

                        </div>

                    </section>

                </div>

            </div>

        </div>

        {{-- SIMPAN SEMUA PEMERIKSAAN --}}

        <div class="save-all-section">

            <div class="save-all-info">

                <h3>Simpan Seluruh Pemeriksaan</h3>

                <p>Simpan data personel, kondisi barang, trouble shooting, keterangan harian, dan tanda tangan sekaligus.</p>

            </div>

            <button type="submit" class="btn-save-all">

                <span>💾</span>

                Simpan Semua Pemeriksaan

            </button>

        </div>

    </form>

</div>

<script>

    document.addEventListener('DOMContentLoaded', function () {
        const checklistForm = document.getElementById('checklistMainForm');
        const confirmModal = document.getElementById('confirmSaveModal');
        const cancelSaveButton = document.getElementById('cancelSaveButton');
        const confirmSaveButton = document.getElementById('confirmSaveButton');
        const successModal = document.getElementById('successModal');
        const successModalClose = document.getElementById('successModalClose');

        // Minta konfirmasi sebelum form benar-benar dikirim.
        if (checklistForm && confirmModal) {
            checklistForm.addEventListener('submit', function (event) {
                if (checklistForm.dataset.confirmed === 'yes') {
                    return;
                }

                event.preventDefault();
                confirmModal.style.display = 'flex';
            });
        }

        if (cancelSaveButton && confirmModal) {
            cancelSaveButton.addEventListener('click', function () {
                confirmModal.style.display = 'none';
            });
        }

        if (confirmSaveButton && checklistForm && confirmModal) {
            confirmSaveButton.addEventListener('click', function () {
                confirmSaveButton.disabled = true;
                confirmSaveButton.textContent = 'Menyimpan...';
                checklistForm.dataset.confirmed = 'yes';
                confirmModal.style.display = 'none';
                checklistForm.submit();
            });
        }

        // Setelah controller berhasil menyimpan dan redirect, tampilkan popup sukses.
        if (successModal) {
            document.body.style.overflow = 'hidden';

            const closeSuccessModal = function () {
                successModal.remove();
                document.body.style.overflow = '';
            };

            if (successModalClose) {
                successModalClose.addEventListener('click', closeSuccessModal);
            }

            // Popup sukses tertutup otomatis setelah 3 detik.
            window.setTimeout(closeSuccessModal, 3000);
        }
    });

    const signatureInput = document.getElementById('signaturePhoto');

    const signaturePreview = document.getElementById('signaturePreview');

    const signaturePlaceholder = document.getElementById('signaturePlaceholder');

    if (signatureInput && signaturePreview && signaturePlaceholder) {

    signatureInput.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) {

            signaturePreview.style.display = 'none';

            signaturePlaceholder.style.display = 'flex';

            return;

        }

        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {

            alert('Pilih foto dengan format JPG, PNG, atau WEBP.');

            this.value = '';

            return;

        }

        const reader = new FileReader();

        reader.onload = function (event) {

            signaturePreview.src = event.target.result;

            signaturePreview.style.display = 'block';

            signaturePlaceholder.style.display = 'none';

        };

        reader.readAsDataURL(file);

    });
    }

</script>

</body>

</html>