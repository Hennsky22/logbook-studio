<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Studio | Logbook Studio</title>

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
            padding: 20px 7%;
            border-bottom: 1px solid #e8e9e1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .brand { font-weight: 750; font-size: 18px; }
        .brand small {
            display: block;
            color: #78837c;
            font-size: 11px;
            font-weight: 400;
            margin-top: 4px;
        }

        .back {
            color: #245b56;
            font-size: 13px;
            text-decoration: none;
            font-weight: 600;
        }

        main {
            max-width: 1100px;
            width: 88%;
            margin: 35px auto;
        }

        .intro {
            background: #245b56;
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 28px;
        }

        .intro p {
            color: #d7e5df;
            font-size: 14px;
            line-height: 1.7;
        }

        .count {
            display: inline-block;
            background: rgba(255,255,255,.14);
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 12px;
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
            padding: 17px 20px;
            border-bottom: 1px solid #eeeeea;
            font-size: 13px;
        }

        th {
            background: #edf0e7;
            color: #526459;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        tr:last-child td { border-bottom: none; }

        .empty {
            padding: 45px 20px;
            text-align: center;
            color: #78837c;
            font-size: 14px;
        }

        footer {
            margin-top: 28px;
            color: #78837c;
            font-size: 11px;
        }

        @media (max-width: 600px) {
            header { padding: 18px 6%; }
            main { width: 92%; margin-top: 24px; }
            .intro { padding: 23px; }
            th, td { padding: 14px; }
        }
    </style>
</head>
<body>
    <header>
        <div class="brand">
            Logbook Studio
            <small>Broadcast Studio Workspace</small>
        </div>

        <a class="back" href="{{ route('dashboard.user') }}">
            ← Kembali ke Dashboard
        </a>
    </header>

    <main>
        <section class="intro">
            <h1>Inventaris Studio</h1>
            <p>
                Lihat daftar peralatan studio dan informasi kondisi
                inventaris yang tersedia.
            </p>

            <span class="count">
                Total {{ $items->count() }} barang
            </span>
        </section>

        <h2 style="font-size:20px; margin-bottom:16px;">
            Daftar Peralatan
        </h2>

        <div class="table-wrap">
            @if ($items->isEmpty())
                <div class="empty">
                    Belum ada data barang yang tersedia.
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori }}</td>
                                
<td>
    {{ $item->kondisi_barang ?? 'Belum ditentukan' }}
</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <footer>
            © {{ date('Y') }} Logbook Studio · Portal Pengguna
        </footer>
    </main>
</body>
</html>
