@php
    // Menentukan nama studio yang ditampilkan pada halaman detail.
    $judulStudio = match ($studioSlug) {
        'master-control-room' => 'Master Control Room',
        'berita' => 'Studio Berita',
        'penyiaran' => 'Studio 9',
        default => $studioNama,
    };

    // Membagi daftar peralatan menjadi dua kolom.
    $equipmentChunks = collect($items ?? [])->values()->chunk(11);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail {{ $judulStudio }} | Logbook Studio</title>
    <link rel="icon" href="{{ asset('images/logbook-logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        (function () {
            try {
                document.documentElement.dataset.theme = localStorage.getItem('logbook-theme') || 'light';
            } catch (e) {
                document.documentElement.dataset.theme = 'light';
            }
        })();
    </script>
    <style>
        :root {
            color-scheme: light;
            --page:#f2f8f7; --surface:#fff; --soft:#f7fbf9;
            --text:#18383d; --secondary:#405b5e; --muted:#7c9293;
            --line:#e1ece9; --thead:#e5f1ed; --row:#e8efed;
            --teal:#078778; --shadow:0 5px 18px #183d350c;
        }
        :root[data-theme="dark"] {
            color-scheme:dark;
            --page:#101b1d; --surface:#19292b; --soft:#203537;
            --text:#edf8f5; --secondary:#d0e0dc; --muted:#9ab2ae;
            --line:#304746; --thead:#24413f; --row:#30413f;
            --teal:#11a995; --shadow:0 5px 18px #00000025;
        }
        * { box-sizing:border-box; }
        html, body { width:100%; height:100%; min-height:100%; margin:0; }
        body {
            overflow:hidden; background:var(--page); color:var(--text);
            font-family:"DM Sans",sans-serif; transition:background .25s,color .25s;
        }
        .page {
            width:98%; max-width:1800px; height:100vh; height:100dvh; min-height:0; margin:auto;
            padding:10px 0 8px; display:flex; flex-direction:column; gap:9px;
        }

        /* Navbar */
        .nav { height:46px; flex:0 0 46px; display:flex; justify-content:space-between; align-items:center; }
        .brand { display:flex; align-items:center; gap:10px; }
        .brand img { width:43px; height:43px; object-fit:contain; }
        .brand b { display:block; font-size:17px; font-weight:800; }
        .brand small { display:block; color:var(--muted); font-size:11px; }
        .back { color:var(--teal); text-decoration:none; font-size:13px; font-weight:800; }

        /* Judul studio */
        .hero {
            flex:0 0 90px; padding:17px 25px; border-radius:14px;
            background:linear-gradient(110deg,#087b6b,#0b9e8b); color:#fff;
            display:flex; flex-direction:column; justify-content:center;
        }
        .hero h1 { margin:0 0 6px; font-size:29px; font-weight:800; }
        .hero p { margin:0; font-size:14px; color:#e0fff8; }

        /* Informasi tanggal dan pemeriksaan */
        .meta { flex:0 0 38px; display:flex; align-items:center; gap:10px; overflow:hidden; }
        .meta span {
            height:36px; display:flex; align-items:center; padding:0 13px;
            border:1px solid var(--line); border-radius:9px; background:var(--surface);
            color:var(--muted); font-size:12px; white-space:nowrap;
        }
        .meta strong { color:var(--text); }

        /* Panel utama */
        .panels {
            flex:1; min-height:0; display:grid;
            grid-template-columns:minmax(300px,.9fr) minmax(0,1.8fr); gap:15px;
        }
        .panel {
            min-width:0; min-height:0; background:var(--surface);
            border:1px solid var(--line); border-radius:14px; overflow:hidden;
            box-shadow:var(--shadow); display:flex; flex-direction:column;
            transition:background .25s;
        }
        .panel-head {
            flex:0 0 50px; height:50px; padding:0 17px;
            background:var(--soft); border-bottom:1px solid var(--line);
            display:flex; align-items:center; justify-content:space-between;
        }
        .panel-head h2 { margin:0; font-size:21px; font-weight:800; }
        .count { color:var(--muted); font-size:14px; white-space:nowrap; }

        /* Tabel crew */
        .table-wrap { flex:1; min-height:0; overflow:hidden; }
        table { width:100%; border-collapse:collapse; table-layout:fixed; }
        th {
            height:42px; padding:0 12px; background:var(--thead); color:var(--text);
            text-align:left; font-size:14px; font-weight:800; white-space:nowrap;
        }
        td {
            height:35px; padding:5px 12px; border-bottom:1px solid var(--row);
            color:var(--secondary); font-size:13px; font-weight:500;
            overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
        }
        th:first-child, td:first-child { width:55px; text-align:center; }
        .crew-table { height:100%; }
        .crew-table th:nth-child(2) { width:40%; }
        .crew-table th:nth-child(3) { width:auto; }
        .crew-table tbody tr { height:calc((100% - 42px) / 8); }
        .crew-table tbody td:nth-child(2) { font-size:16px; font-weight:700; color:var(--text); }
        .crew-table tbody td:nth-child(3) { font-size:14px; }

        /* Dua tabel peralatan; scroll hanya di dalam masing-masing kolom */
        .equipment-grid {
            flex:1; min-height:0; display:grid;
            grid-template-columns:minmax(0,1fr) minmax(0,1fr); overflow:hidden;
        }
        .equipment-column {
            min-width:0; min-height:0; overflow-y:auto; overflow-x:hidden;
            scrollbar-width:thin; scrollbar-color:var(--muted) var(--soft);
        }
        .equipment-column + .equipment-column { border-left:1px solid var(--line); }
        .equipment-column thead th { position:sticky; top:0; z-index:3; }
        .equipment-table th:nth-child(2) { width:68%; }
        .equipment-table th:nth-child(3) { width:32%; }

        /* Font dan baris barang diperbesar untuk mengurangi ruang kosong */
        .equipment-table th {
            height:50px; padding:0 14px; font-size:17px; font-weight:800;
        }
        .equipment-table tbody tr { height:50px; }
        .equipment-table td {
            height:50px; padding:9px 14px; font-size:17px; font-weight:700;
        }
        .equipment-table td:first-child { font-size:16px; font-weight:800; }

        /*
         * Ukuran huruf barang konsisten pada mode normal dan fullscreen.
         * Kapasitas kolom kiri dihitung dari tinggi panel oleh JavaScript.
         */
        @media (min-width:761px) {
            .equipment-column {
                overflow-y:auto;
                overflow-x:hidden;
                scrollbar-width:thin;
                scrollbar-color:var(--muted) var(--soft);
            }
            .equipment-table {
                height:100%;
                display:flex;
                flex-direction:column;
                table-layout:fixed;
            }
            .equipment-table thead {
                display:block;
                flex:0 0 50px;
            }
            .equipment-table thead tr {
                display:grid;
                grid-template-columns:12% 56% 32%;
                height:100%;
            }
            .equipment-table thead th,
            .equipment-table tbody td {
                width:auto !important;
            }
            .equipment-table thead th {
                display:flex;
                align-items:center;
                height:100%;
                min-width:0;
            }
            .equipment-table tbody {
                display:flex;
                flex:1 1 0;
                flex-direction:column;
                min-height:0;
            }
            .equipment-table tbody tr {
                display:grid;
                grid-template-columns:12% 56% 32%;
                flex:1 0 50px;
                min-height:50px;
                height:auto !important;
            }
            .equipment-table tbody td {
                display:flex;
                align-items:center;
                min-width:0;
                height:auto !important;
                min-height:50px;
                padding:8px 10px;
                font-size:17px !important;
            }
            .equipment-table tbody td:first-child {
                justify-content:center;
                text-align:center;
                font-size:16px !important;
            }
            .equipment-table tbody td:nth-child(2) {
                white-space:normal;
                overflow-wrap:anywhere;
            }
            .equipment-table .condition {
                font-size:14px !important;
                min-width:108px;
                padding:7px 11px;
            }
        }

        /* Label kondisi */
        .condition {
            display:inline-block; min-width:105px; padding:7px 12px;
            border-radius:20px; text-align:center; font-size:14px; font-weight:800;
        }
        .baik { background:#d4f3df; color:#13834c; }
        .error { background:#ffe7bd; color:#a86600; }
        .rusak { background:#ffd9dc; color:#c12c39; }
        .belum { background:#edf1f1; color:#738184; }
        :root[data-theme="dark"] .baik { background:#164b37; color:#7ce2aa; }
        :root[data-theme="dark"] .error { background:#59421c; color:#ffd37b; }
        :root[data-theme="dark"] .rusak { background:#5a2930; color:#ff9da6; }
        :root[data-theme="dark"] .belum { background:#344547; color:#c0d0ce; }
        tbody tr:hover { background:var(--soft); }
        .empty { text-align:center!important; color:var(--muted); height:60px; }
        .footer { flex:0 0 16px; text-align:center; color:var(--muted); font-size:11px; }

        /* Layar desktop yang lebih pendek */
        @media (min-width:761px) and (max-height:850px) {
            .page { gap:8px; padding:8px 0; }
            .hero { flex-basis:80px; }
            .panel-head { flex-basis:44px; height:44px; }
            /* Ukuran tulisan barang tetap sama saat fullscreen maupun normal. */
            .equipment-table th { height:50px; font-size:17px; padding:0 14px; }
            .equipment-table tbody tr, .equipment-table td { height:50px; }
            .equipment-table td { font-size:17px; padding:8px 10px; }
            .equipment-table .condition { min-width:108px; padding:7px 11px; font-size:14px; }
            .crew-table tbody td { height:auto; padding:5px 12px; }
        }

        /* Tampilan mobile */
        @media (max-width:760px) {
            body { overflow:auto; }
            .page { height:auto; min-height:100vh; width:94%; }
            .hero h1 { font-size:22px; }
            .meta { flex-wrap:wrap; height:auto; flex-basis:auto; }
            .panels { grid-template-columns:1fr; grid-template-rows:auto auto; }
            .panel { min-height:300px; }
            .table-wrap { overflow:auto; }
            .equipment-grid { grid-template-columns:1fr; overflow:visible; }
            .equipment-column { max-height:420px; }
            .equipment-column + .equipment-column { border-left:0; border-top:1px solid var(--line); }
            .crew-table tbody tr { height:auto; }
            .equipment-table tbody tr, .equipment-table td { height:54px; }
        }
    </style>
</head>
<body>
<div class="page">
    <header class="nav">
        <div class="brand">
            <img src="{{ asset('images/logbook-logo.png') }}" alt="Logo">
            <div>
                <b>Logbook Studio</b>
                <small>Studio Equipment Inspection</small>
            </div>
        </div>
        <a class="back" href="{{ route('monitoring.public', ['tanggal' => $tanggal]) }}">← Kembali ke Monitoring</a>
    </header>

    <section class="hero">
        <h1>{{ $judulStudio }}</h1>
        <p>Detail crew bertugas dan kondisi seluruh peralatan studio.</p>
    </section>

    <div class="meta">
        <span>▦ &nbsp;Tanggal: <strong>&nbsp;{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong></span>
        <span>▣ &nbsp;Peralatan diperiksa: <strong>&nbsp;{{ $jumlahDiperiksa }}/{{ $totalBarang }}</strong></span>
        <span id="last-update">◷ &nbsp;Pembaruan otomatis setiap 5 detik</span>
    </div>

    <main class="panels">
        <!-- DATA CREW -->
        <section class="panel">
            <div class="panel-head">
                <h2>1. Data Crew</h2>
                <span class="count" id="crew-count">{{ count($crew ?? []) }} personel</span>
            </div>
            <div class="table-wrap">
                <table class="crew-table">
                    <thead>
                        <tr><th>No.</th><th>Unit Kerja</th><th>Nama Crew</th></tr>
                    </thead>
                    <tbody id="crew-body">
                        @forelse($crew as $i => $personel)
                            @php
                                // Mendukung data crew berbentuk array maupun object.
                                $unitKerja = data_get($personel, 'unit_kerja')
                                    ?? data_get($personel, 'unit')
                                    ?? data_get($personel, 'nama_unit')
                                    ?? (is_string($i) ? $i : (is_array($personel) ? ($personel[0] ?? '-') : '-'));
                                $namaCrew = data_get($personel, 'nama')
                                    ?? data_get($personel, 'nama_crew')
                                    ?? data_get($personel, 'nama_personel')
                                    ?? data_get($personel, 'crew')
                                    ?? data_get($personel, 'keterangan')
                                    ?? (is_array($personel) ? ($personel[1] ?? '-') : (is_string($personel) ? $personel : '-'));
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $unitKerja ?: '-' }}</td>
                                <td>{{ $namaCrew ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="empty">Belum ada data crew pada tanggal ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- KONDISI BARANG: 11 BARANG KIRI, 10 BARANG KANAN -->
        <section class="panel">
            <div class="panel-head">
                <h2>2. Kondisi Barang</h2>
                <span class="count" id="item-count">{{ $jumlahDiperiksa }}/{{ $totalBarang }} diperiksa</span>
            </div>
            <div class="equipment-grid" id="equipment-grid">
                @forelse($equipmentChunks as $chunkIndex => $chunk)
                    <div class="equipment-column">
                        <table class="equipment-table">
                            <thead>
                                <tr><th>No.</th><th>Nama Peralatan</th><th>Kondisi</th></tr>
                            </thead>
                            <tbody>
                                @foreach($chunk as $item)
                                    @php
                                        $condition = strtolower((string) data_get($item, 'monitoring_pemeriksaan.kondisi', ''));
                                        $class = in_array($condition, ['baik', 'error', 'rusak'], true) ? $condition : 'belum';
                                        $label = $condition ? ucfirst($condition) : 'Belum dicek';
                                        $nomor = ($chunkIndex * 11) + $loop->iteration;
                                    @endphp
                                    <tr>
                                        <td>{{ $nomor }}</td>
                                        <td title="{{ data_get($item, 'nama_barang', '-') }}">{{ data_get($item, 'nama_barang', '-') }}</td>
                                        <td><span class="condition {{ $class }}">{{ $label }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                    <div class="equipment-column">
                        <table class="equipment-table">
                            <thead><tr><th>No.</th><th>Nama Peralatan</th><th>Kondisi</th></tr></thead>
                            <tbody><tr><td colspan="3" class="empty">Belum ada barang terdaftar di studio ini.</td></tr></tbody>
                        </table>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <footer class="footer">© {{ date('Y') }} Logbook Studio · Monitoring Publik</footer>
</div>

<script>
const endpoint = @json(route('monitoring.public.detail.data', ['studio' => $studioSlug]));
const tanggal = @json($tanggal);

function esc(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#039;'
    }[char]));
}

function conditionBadge(value) {
    const condition = String(value || '').toLowerCase();
    const css = ['baik','error','rusak'].includes(condition) ? condition : 'belum';
    const label = condition ? condition.charAt(0).toUpperCase() + condition.slice(1) : 'Belum dicek';
    return `<span class="condition ${css}">${esc(label)}</span>`;
}

function renderCrew(crew) {
    const body = document.getElementById('crew-body');
    document.getElementById('crew-count').textContent = `${crew.length} personel`;
    if (!crew.length) {
        body.innerHTML = `<tr><td colspan="3" class="empty">Belum ada data crew pada tanggal ini.</td></tr>`;
        return;
    }
    body.innerHTML = crew.map((personel, index) => {
        const isObject = personel !== null && typeof personel === 'object';
        const unitKerja = isObject
            ? (personel.unit_kerja ?? personel.unit ?? personel.nama_unit ?? personel[0] ?? '-')
            : (typeof index === 'string' ? index : '-');
        const namaCrew = isObject
            ? (personel.nama ?? personel.nama_crew ?? personel.nama_personel ?? personel.crew ?? personel.keterangan ?? personel[1] ?? '-')
            : (typeof personel === 'string' ? personel : '-');
        return `<tr><td>${index + 1}</td><td>${esc(unitKerja || '-')}</td><td>${esc(namaCrew || '-')}</td></tr>`;
    }).join('');
}

function renderItems(items) {
    const grid = document.getElementById('equipment-grid');
    if (!items.length) {
        grid.innerHTML = `
            <div class="equipment-column">
                <table class="equipment-table">
                    <thead><tr><th>No.</th><th>Nama Peralatan</th><th>Kondisi</th></tr></thead>
                    <tbody><tr><td colspan="3" class="empty">Belum ada barang terdaftar di studio ini.</td></tr></tbody>
                </table>
            </div>`;
        return;
    }
    // Kapasitas kolom kiri mengikuti tinggi panel, bukan angka 11 yang tetap.
    const headerHeight = 50;
    const minimumRowHeight = 50;
    const availableHeight = Math.max(100, grid.getBoundingClientRect().height - headerHeight);
    const capacity = Math.max(1, Math.floor(availableHeight / minimumRowHeight));
    const leftItems = items.slice(0, capacity);
    const rightItems = items.slice(capacity);
    const chunks = [leftItems, rightItems];
    grid.innerHTML = chunks.filter(chunk => chunk.length).map(chunk => `
        <div class="equipment-column">
            <table class="equipment-table">
                <thead><tr><th>No.</th><th>Nama Peralatan</th><th>Kondisi</th></tr></thead>
                <tbody>
                    ${chunk.map(item => `
                        <tr>
                            <td></td>
                            <td title="${esc(item.nama_barang)}">${esc(item.nama_barang)}</td>
                            <td>${conditionBadge(item.kondisi)}</td>
                        </tr>`).join('')}
                </tbody>
            </table>
        </div>`).join('');
    let nomor = 1;
    grid.querySelectorAll('tbody tr').forEach(row => {
        const cell = row.querySelector('td:first-child');
        if (cell && !row.querySelector('.empty')) cell.textContent = nomor++;
    });
}

async function refreshDetail() {
    try {
        const response = await fetch(`${endpoint}?tanggal=${encodeURIComponent(tanggal)}`, {
            headers:{'Accept':'application/json'}, cache:'no-store'
        });
        if (!response.ok) return;
        const data = await response.json();
        const crew = Array.isArray(data.crew)
            ? data.crew
            : (data.crew && typeof data.crew === 'object'
                ? Object.entries(data.crew).map(([unit, value]) => ({unit_kerja:unit, nama:value}))
                : []);
        renderCrew(crew);
        renderItems(Array.isArray(data.items) ? data.items : []);
        document.getElementById('item-count').textContent = `${data.jumlah_diperiksa}/${data.total_barang} diperiksa`;
        document.getElementById('last-update').textContent = `◷ Terakhir diperbarui ${data.updated_at}`;
    } catch (error) {
        console.error('Gagal memperbarui data:', error);
    }
}

function syncTheme() {
    try {
        document.documentElement.dataset.theme = localStorage.getItem('logbook-theme') || 'light';
    } catch (error) {
        console.error(error);
    }
}

syncTheme();
window.addEventListener('storage', event => {
    if (event.key === 'logbook-theme') syncTheme();
});
window.addEventListener('pageshow', syncTheme);

// Muat data sejak awal dan hitung ulang saat ukuran layar/fullscreen berubah.
refreshDetail();

let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(refreshDetail, 120);
});
document.addEventListener('fullscreenchange', () => {
    setTimeout(refreshDetail, 150);
});

// Pantau perubahan tinggi panel, termasuk saat toolbar Chrome menghilang/muncul.
if ('ResizeObserver' in window) {
    const panelObserver = new ResizeObserver(() => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(refreshDetail, 120);
    });
    const equipmentGrid = document.getElementById('equipment-grid');
    if (equipmentGrid) panelObserver.observe(equipmentGrid);
    const panels = document.querySelector('.panels');
    if (panels) panelObserver.observe(panels);
}

if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(() => refreshDetail());
}
setInterval(refreshDetail, 5000);
</script>
</body>
</html>
