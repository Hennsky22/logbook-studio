
@extends('layouts.app')

@section('content')
<div class="page-container loan-page">
    <div class="page-heading">
        <div>
            <h1>Tambah Peminjaman Barang</h1>
            <p>Catat peminjaman peralatan untuk kegiatan siaran dan operasional studio.</p>
        </div>

        <a href="{{ route('loans.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="loan-alert">
            <strong>Periksa kembali data yang dimasukkan.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="loan-card">
        <div class="loan-card-header">
            <div>
                <h2>Form Peminjaman</h2>
                <p>Lengkapi informasi barang, kegiatan, dan petugas.</p>
            </div>
            <span class="loan-icon">↗</span>
        </div>

        <form action="{{ route('loans.store') }}" method="POST">
            @csrf

            <div class="loan-form-grid">
                <div class="loan-field">
                    <label for="logbook_id">ID Siaran / Operasional <span>*</span></label>
                    <select id="logbook_id" name="logbook_id" required>
                        <option value="">Pilih kegiatan</option>
                        @foreach ($logbooks as $logbook)
                            <option value="{{ $logbook->id }}"
                                @selected(old('logbook_id') == $logbook->id)>
                                {{ $logbook->id }} — {{ $logbook->nama_kegiatan }}
                                ({{ $logbook->tanggal?->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="loan-field">
                    <label for="item_id">Barang <span>*</span></label>
                    <select id="item_id" name="item_id" required>
                        <option value="">Pilih barang</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}"
                                @selected(old('item_id') == $item->id)>
                                {{ $item->id }} — {{ $item->nama_barang }}
                                ({{ $item->kategori }})
                            </option>
                        @endforeach
                    </select>
                    <small>Hanya barang berstatus tersedia yang ditampilkan.</small>
                </div>

                <div class="loan-field">
                    <label for="user_id">Petugas <span>*</span></label>
                    <select id="user_id" name="user_id" required>
                        <option value="">Pilih petugas</option>
                        @foreach ($petugas as $user)
                            <option value="{{ $user->id }}"
                                @selected(old('user_id') == $user->id)>
                                {{ $user->id }} — {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="loan-field">
                    <label for="tanggal_pinjam">Tanggal Peminjaman <span>*</span></label>
                    <input
                        id="tanggal_pinjam"
                        type="date"
                        name="tanggal_pinjam"
                        value="{{ old('tanggal_pinjam', now()->format('Y-m-d')) }}"
                        required
                    >
                </div>

                <div class="loan-field">
                    <label for="tanggal_rencana_kembali">Rencana Pengembalian</label>
                    <input
                        id="tanggal_rencana_kembali"
                        type="date"
                        name="tanggal_rencana_kembali"
                        value="{{ old('tanggal_rencana_kembali') }}"
                    >
                </div>

                <div class="loan-field">
                    <label>Kondisi Awal</label>
                    <div class="loan-info">
                        Kondisi barang diambil otomatis dari data inventaris saat disimpan.
                    </div>
                </div>
            </div>

            <div class="loan-form-footer">
                <p><span>*</span> Wajib diisi</p>

                <div class="loan-actions">
                    <a href="{{ route('loans.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Peminjaman
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.loan-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 28px 32px;
    color: #243447;
}

.loan-page .page-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
}

.loan-page .page-heading h1 {
    font-size: 28px;
    margin: 0 0 8px;
    font-weight: 700;
}

.loan-page .page-heading p,
.loan-card-header p {
    margin: 0;
    color: #718096;
    line-height: 1.6;
}

.loan-card {
    background: #fff;
    border: 1px solid #e5ebf0;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(27, 47, 67, .04);
    overflow: hidden;
}

.loan-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 28px;
    border-bottom: 1px solid #edf1f5;
}

.loan-card-header h2 {
    margin: 0 0 7px;
    font-size: 19px;
}

.loan-icon {
    width: 44px;
    height: 44px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    background: #e1f5f1;
    color: #087f73;
    font-size: 23px;
}

.loan-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 24px;
    padding: 28px;
}

.loan-field {
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 9px;
}

.loan-field label {
    font-size: 14px;
    font-weight: 600;
    color: #344256;
}

.loan-field label span,
.loan-form-footer p span {
    color: #d64545;
}

.loan-field input,
.loan-field select {
    width: 100%;
    box-sizing: border-box;
    min-height: 46px;
    padding: 11px 13px;
    border: 1px solid #d9e2ea;
    border-radius: 9px;
    background: #fff;
    color: #263648;
    font: inherit;
    outline: none;
}

.loan-field input:focus,
.loan-field select:focus {
    border-color: #0b887c;
    box-shadow: 0 0 0 3px rgba(11, 136, 124, .12);
}

.loan-field small {
    color: #8190a1;
    font-size: 12px;
}

.loan-info {
    min-height: 46px;
    box-sizing: border-box;
    padding: 12px 14px;
    border-radius: 9px;
    background: #f1f8f7;
    color: #39716c;
    font-size: 13px;
    line-height: 1.5;
}

.loan-form-footer {
    border-top: 1px solid #edf1f5;
    padding: 20px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.loan-form-footer p {
    margin: 0;
    color: #718096;
    font-size: 13px;
}

.loan-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.loan-page .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    padding: 10px 18px;
    border-radius: 9px;
    border: 1px solid transparent;
    text-decoration: none;
    font: inherit;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    box-sizing: border-box;
}

.loan-page .btn-primary {
    background: #087f73;
    color: white;
}

.loan-page .btn-primary:hover {
    background: #066b62;
}

.loan-page .btn-secondary {
    background: white;
    border-color: #d9e2ea;
    color: #435166;
}

.loan-page .btn-secondary:hover {
    background: #f6f8fa;
}

.loan-alert {
    margin-bottom: 20px;
    padding: 16px 20px;
    border-radius: 10px;
    border: 1px solid #f2caca;
    background: #fff5f5;
    color: #a52c2c;
}

.loan-alert ul {
    margin-bottom: 0;
}

@media (max-width: 700px) {
    .loan-page {
        padding: 20px 14px;
    }

    .loan-page .page-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .loan-form-grid {
        grid-template-columns: 1fr;
        padding: 20px;
        gap: 19px;
    }

    .loan-card-header {
        padding: 20px;
    }

    .loan-form-footer {
        padding: 20px;
        align-items: stretch;
        flex-direction: column;
    }

    .loan-actions {
        flex-direction: column-reverse;
    }

    .loan-actions .btn {
        width: 100%;
    }
}
</style>
@endsection
