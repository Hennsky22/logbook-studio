<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemeriksaan | Logbook Studio</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f7f6f0;
            color: #26352f;
        }

        header {
            background: white;
            border-bottom: 1px solid #e8e9e1;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .brand { font-size: 18px; font-weight: 750; }

        .brand small {
            display: block;
            color: #78837c;
            font-size: 11px;
            font-weight: 400;
            margin-top: 4px;
        }

        a { text-decoration: none; }

        .back {
            color: #245b56;
            font-size: 13px;
            font-weight: 650;
        }

        main {
            max-width: 1100px;
            width: 88%;
            margin: 35px auto 50px;
        }

        .hero {
            background: #245b56;
            color: white;
            border-radius: 22px;
            padding: 32px;
            margin-bottom: 25px;
        }

        .tag {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 30px;
            background: rgba(255,255,255,.14);
            font-size: 11px;
            margin-bottom: 16px;
        }

        .hero h1 {
            font-size: clamp(25px, 3vw, 34px);
            margin: 0 0 12px;
        }

        .hero p {
            color: #d7e5df;
            font-size: 14px;
            line-height: 1.8;
            margin: 0;
        }

        .filter {
            background: white;
            border: 1px solid #e8e9e1;
            border-radius: 16px;
            padding: 22px;
            margin-bottom: 25px;
        }

        .filter h2 {
            font-size: 17px;
            margin: 0 0 16px;
        }

        .filter-form {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .field {
            flex: 1;
            min-width: 200px;
        }

        .field label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        input[type="date"] {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #e1e5dc;
            border-radius: 9px;
            font: inherit;
            font-size: 13px;
        }

        .button {
            display: inline-block;
            border: none;
            border-radius: 9px;
            padding: 12px 16px;
            background: #245b56;
            color: white;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .button.secondary {
            background: #e5ede0;
            color: #245b56;
        }

        .heading {
            margin: 28px 0 18px;
        }

        .heading h2 {
            font-size: 21px;
            margin-bottom: 7px;
        }

        .heading p {
            color: #78837c;
            font-size: 13px;
            line-height: 1.7;
        }

        .table-wrap {
            background: white;
            border: 1px solid #e8e9e1;
            border-radius: 16px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 16px 18px;
            border-bottom: 1px solid #eeeeea;
            font-size: 12px;
            vertical-align: top;
            line-height: 1.7;
        }

        th {
            background: #edf0e7;
            color: #526459;
            text-transform: uppercase;
            letter-spacing: .4px;
            font-size: 10px;
            white-space: nowrap;
        }

        tbody tr:last-child td { border-bottom: none; }

        .status {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
        }

        .status.baik {
            color: #27643a;
            background: #e4f2e5;
        }

        .status.rusak {
            color: #923b31;
            background: #f9e5e2;
        }

        .status.perlu {
            color: #89651d;
            background: #f8edd0;
        }

        .empty {
            background: white;
            border: 1px solid #e8e9e1;
            border-radius: 16px;
            text-align: center;
            padding: 40px 20px;
            color: #78837c;
            line-height: 1.8;
            font-size: 13px;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination nav > div {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            background: white;
            border: 1px solid #e8e9e1;
            color: #245b56;
            font-size: 12px;
        }

        footer {
            margin-top: 35px;
            padding-top: 20px;
            border-top: 1px solid #e8e9e1;
            color: #78837c;
            font-size: 11px;
        }

        @media (max-width: 650px) {
            header {
                padding: 16px 5%;
                flex-wrap: wrap;
            }

            main {
                width: 92%;
                margin-top: 24px;
            }

            .hero { padding: 24px; }

            .filter { padding: 17px; }

            .filter-form {
                align-items: stretch;
                flex-direction: column;
            }

            .field { min-width: 0; }

            .button { text-align: center; }

            th, td { padding: 13px; }

            footer { line-height: 1.7; }
        }
    </style>
</head>

<body>
    <header>
        <a href="{{ route('dashboard.user') }}" class="brand">
            Logbook Studio
            <small>Broadcast Studio Workspace</small>
        </a>

        <a href="{{ route('dashboard.user') }}" class="back">
            ← Kembali ke Dashboard
        </a>
    </header>

    <main>
        <section class="hero">
            <span class="tag">Dokumentasi Pemeriksaan</span>
            <h1>Riwayat Pemeriksaan</h1>
            <p>
                Lihat catatan kondisi peralatan studio yang telah
                diperiksa. Riwayat tersimpan berdasarkan tanggal
                dan dapat ditelusuri kembali.
            </p>
        </section>

        <section class="filter">
            <h2>Filter berdasarkan tanggal</h2>

            <form action="{{ route('dashboard.history') }}"
                  method="GET"
                  class="filter-form">

                <div class="field">
                    <label for="tanggal">Tanggal pemeriksaan</label>

                    <input
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="{{ $tanggal }}"
                    >
                </div>

                <button class="button" type="submit">
                    Cari Riwayat
                </button>

                <a class="button secondary"
                   href="{{ route('dashboard.history') }}">
                    Semua Tanggal
                </a>
            </form>
        </section>

        <section>
            <div class="heading">
                <h2>Catatan Pemeriksaan</h2>
                <p>
                    @if ($tanggal)
                        Menampilkan pemeriksaan tanggal
                        {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y') }}.
                    @else
                        Menampilkan catatan pemeriksaan terbaru.
                    @endif
                </p>
            </div>

            @if ($riwayat->isEmpty())
                <div class="empty">
                    <h3 style="margin-bottom:8px;">Belum ada riwayat</h3>
                    <p>
                        Tidak ditemukan catatan pemeriksaan untuk
                        pilihan tanggal tersebut.
                    </p>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Kondisi</th>
                                <th>Catatan</th>
                                <th>Diperiksa Oleh</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($riwayat as $record)
                                @php
                                    $statusClass = match ($record->kondisi) {
                                        'Baik' => 'baik',
                                        'Rusak' => 'rusak',
                                        default => 'perlu',
                                    };
                                @endphp

                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($record->tanggal_pemeriksaan)->locale('id')->translatedFormat('d M Y') }}
                                    </td>

                                    <td>
                                        {{ $record->item?->nama_barang ?? 'Barang sudah tidak tersedia' }}
                                    </td>

                                    <td>
                                        {{ $record->item?->kategori ?? '—' }}
                                    </td>

                                    <td>
                                        <span class="status {{ $statusClass }}">
                                            {{ $record->kondisi }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $record->catatan ?: 'Tidak ada catatan' }}
                                    </td>

                                    <td>
                                        {{ $record->user?->name ?? 'Pengguna tidak tersedia' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $riwayat->links() }}
                </div>
            @endif
        </section>

        <footer>
            © {{ date('Y') }} Logbook Studio · Portal Pengguna
        </footer>
    </main>
</body>
</html>