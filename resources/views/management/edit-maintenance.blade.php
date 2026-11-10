
    @extends('layouts.app')

    @section('title', 'Edit Pemeliharaan')
    @section('page-title', 'Edit Pemeliharaan')

    @section('content')
    <div class="maintenance-page">

        
    <div class="maintenance-heading" style="display:flex; justify-content:space-between; align-items:center; width:100%; gap:20px;">
        <div>
            <h2>Form Edit Pemeliharaan</h2>
            <p>Ubah informasi yang diperlukan, lalu simpan.</p>
        </div>

        <a href="{{ route('maintenance.index') }}"
        class="btn"
        style="margin-left:auto; flex-shrink:0;">
            Kembali
        </a>
    </div>


        <div class="maintenance-card">
            <div class="maintenance-card-heading">
            </div>

            <form action="{{ route('maintenance.update', $pemeliharaan->id) }}"
                method="POST"
                enctype="multipart/form-data"
                style="padding:24px;">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="maintenance-alert maintenance-alert-error">
                        <ul style="padding-left:20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="item_id">Barang</label>
                    <select name="item_id" id="item_id" class="form-control" required>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}"
                                @selected(old('item_id', $pemeliharaan->item_id) == $item->id)>
                                {{ $item->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="tanggal_rusak">Tanggal Rusak</label>
                        <input type="date"
                            name="tanggal_rusak"
                            id="tanggal_rusak"
                            class="form-control"
                            value="{{ old('tanggal_rusak', $pemeliharaan->tanggal_rusak?->format('Y-m-d')) }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_perbaikan">Tanggal Perbaikan</label>
                        <input type="date"
                            name="tanggal_perbaikan"
                            id="tanggal_perbaikan"
                            class="form-control"
                            value="{{ old('tanggal_perbaikan', $pemeliharaan->tanggal_perbaikan?->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="kerusakan">Kerusakan</label>
                    <textarea name="kerusakan"
                            id="kerusakan"
                            class="form-control"
                            rows="4"
                            required>{{ old('kerusakan', $pemeliharaan->kerusakan) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="penanganan">Penanganan</label>
                    <textarea name="penanganan"
                            id="penanganan"
                            class="form-control"
                            rows="4">{{ old('penanganan', $pemeliharaan->penanganan) }}</textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="foto_awal">Foto Sebelum Perbaikan</label>

                        @if ($pemeliharaan->foto_awal)
                            <p>Foto saat ini:</p>
                            <img src="{{ asset('storage/'.$pemeliharaan->foto_awal) }}"
                                alt="Foto sebelum perbaikan"
                                style="width:120px;max-height:120px;object-fit:cover;border-radius:8px;margin:10px 0;">
                        @endif

                        <input type="file"
                            name="foto_awal"
                            id="foto_awal"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp">

                        <small>Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>

                    <div class="form-group">
                        <label for="foto_sesudah">Foto Sesudah Perbaikan</label>

                        @if ($pemeliharaan->foto_sesudah)
                            <p>Foto saat ini:</p>
                            <img src="{{ asset('storage/'.$pemeliharaan->foto_sesudah) }}"
                                alt="Foto sesudah perbaikan"
                                style="width:120px;max-height:120px;object-fit:cover;border-radius:8px;margin:10px 0;">
                        @endif

                        <input type="file"
                            name="foto_sesudah"
                            id="foto_sesudah"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp">

                        <small>Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('maintenance.index') }}" class="btn btn-outline">
                        Batal
                    </a>

                    <button type="submit" class="btn">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
