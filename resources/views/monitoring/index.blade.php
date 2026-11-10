<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Monitoring Publik | Logbook Studio</title>
<link rel="icon" href="{{ asset('images/logbook-logo.png') }}">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<script>
(function () {
    try {
        document.documentElement.dataset.theme =
            localStorage.getItem('logbook-theme') || 'light';
    } catch (e) {
        document.documentElement.dataset.theme = 'light';
    }
})();
</script>

<style>
:root {
    color-scheme: light;
    --page:#f1f7f5;
    --surface:#ffffff;
    --soft:#f6faf8;
    --text:#18383d;
    --secondary:#496367;
    --muted:#819594;
    --line:#e1ece8;
    --teal:#078778;
    --teal-dark:#086e63;
    --shadow:0 8px 24px rgba(23,67,58,.07);
}
:root[data-theme="dark"] {
    color-scheme:dark;
    --page:#101b1d;
    --surface:#19292b;
    --soft:#203537;
    --text:#edf8f5;
    --secondary:#c8d9d5;
    --muted:#9ab2ae;
    --line:#304746;
    --teal:#11a995;
    --teal-dark:#0c8879;
    --shadow:0 8px 24px rgba(0,0,0,.2);
}
* { box-sizing:border-box; }
html,body { min-height:100%; margin:0; }
body {
    background:var(--page);
    color:var(--text);
    font-family:"DM Sans",sans-serif;
    transition:background .2s,color .2s;
}
.page {
    width:min(1500px,96%);
    margin:0 auto;
    padding:18px 0 24px;
}
.topbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    margin-bottom:20px;
}
.brand { display:flex; align-items:center; gap:11px; }
.brand img { width:48px; height:48px; object-fit:contain; }
.brand-title { font-size:19px; font-weight:800; line-height:1.2; }
.brand-subtitle { margin-top:3px; color:var(--muted); font-size:11px; }
.top-actions { display:flex; align-items:center; gap:9px; }
.theme-button,.filter-button {
    border:1px solid var(--line);
    background:var(--surface);
    color:var(--text);
    border-radius:10px;
    padding:10px 14px;
    font:700 12px "DM Sans",sans-serif;
    cursor:pointer;
}
.theme-button:hover,.filter-button:hover { border-color:var(--teal); }
.hero {
    padding:24px 28px;
    border-radius:17px;
    color:white;
    background:linear-gradient(115deg,#087568,#0b9e8b);
    box-shadow:var(--shadow);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-bottom:16px;
}
.hero h1 { margin:0 0 6px; font-size:28px; font-weight:800; }
.hero p { margin:0; color:#dcfff6; font-size:13px; }
.date-form {
    display:flex;
    align-items:center;
    gap:8px;
    flex-wrap:wrap;
}
.date-form label { font-size:11px; font-weight:700; }
.date-form input {
    border:1px solid rgba(255,255,255,.4);
    background:rgba(255,255,255,.14);
    color:white;
    border-radius:8px;
    padding:9px 10px;
    font:600 12px "DM Sans",sans-serif;
}
.date-form input::-webkit-calendar-picker-indicator { filter:invert(1); }
.date-form button {
    border:0;
    background:white;
    color:#087568;
    border-radius:8px;
    padding:10px 13px;
    font:800 11px "DM Sans",sans-serif;
    cursor:pointer;
}
.summary {
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:11px;
    margin-bottom:19px;
}
.stat {
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:12px;
    padding:14px 16px;
    box-shadow:var(--shadow);
}
.stat-label { color:var(--muted); font-size:10px; font-weight:700; }
.stat-value { margin-top:5px; color:var(--text); font-size:23px; font-weight:800; }
.section-heading {
    display:flex;
    justify-content:space-between;
    align-items:end;
    gap:12px;
    margin:0 0 12px;
}
.section-heading h2 { margin:0; font-size:19px; font-weight:800; }
.section-heading p { margin:0; color:var(--muted); font-size:11px; }
.studio-grid {
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:16px;
}
.studio-card {
    min-width:0;
    overflow:hidden;
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:15px;
    box-shadow:var(--shadow);
    display:flex;
    flex-direction:column;
}
.studio-image {
    height:175px;
    position:relative;
    overflow:hidden;
    background:var(--soft);
}
.studio-image img {
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
    transition:transform .35s;
}
.studio-card:hover .studio-image img { transform:scale(1.035); }
.image-fallback {
    width:100%; height:100%;
    display:flex; align-items:center; justify-content:center;
    color:var(--muted); font-size:13px; font-weight:700;
}
.studio-body { padding:15px 16px 16px; display:flex; flex:1; flex-direction:column; }
.studio-title-row {
    display:flex; align-items:flex-start; justify-content:space-between; gap:8px;
    margin-bottom:11px;
}
.studio-title { margin:0; font-size:17px; line-height:1.25; font-weight:800; }
.status {
    flex-shrink:0;
    padding:5px 8px;
    border-radius:30px;
    font-size:9px;
    font-weight:800;
}
.status.normal { background:#d9f5e5; color:#147848; }
.status.warning { background:#fff0c9; color:#946000; }
.status.danger { background:#ffe0e2; color:#b52e3b; }
:root[data-theme="dark"] .status.normal { background:#164b37; color:#8ce4b4; }
:root[data-theme="dark"] .status.warning { background:#59421c; color:#ffd37b; }
:root[data-theme="dark"] .status.danger { background:#5a2930; color:#ff9da6; }
.card-stats {
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:8px;
    margin-bottom:12px;
}
.card-stat {
    background:var(--soft);
    border:1px solid var(--line);
    border-radius:9px;
    padding:9px 10px;
}
.card-stat span { display:block; color:var(--muted); font-size:9px; font-weight:700; }
.card-stat strong { display:block; margin-top:3px; color:var(--text); font-size:17px; }
.progress-track {
    height:7px;
    overflow:hidden;
    background:var(--soft);
    border-radius:10px;
    margin:0 0 12px;
}
.progress-bar { height:100%; background:var(--teal); border-radius:10px; }
.crew-preview {
    border-top:1px solid var(--line);
    padding-top:10px;
    margin-top:auto;
}
.crew-label { margin-bottom:6px; color:var(--muted); font-size:10px; font-weight:800; }
.crew-list {
    min-height:38px;
    display:flex;
    flex-wrap:wrap;
    align-content:flex-start;
    gap:5px;
}
.crew-chip {
    max-width:100%;
    padding:5px 8px;
    border-radius:7px;
    background:var(--soft);
    border:1px solid var(--line);
    color:var(--secondary);
    font-size:10px;
    font-weight:600;
    overflow-wrap:anywhere;
}
.no-crew { color:var(--muted); font-size:10px; }
.detail-link {
    display:flex;
    justify-content:center;
    align-items:center;
    margin-top:13px;
    padding:11px;
    border-radius:9px;
    background:var(--teal);
    color:white;
    text-decoration:none;
    font-size:12px;
    font-weight:800;
    transition:background .2s;
}
.detail-link:hover { background:var(--teal-dark); }
.footer {
    padding:19px 0 4px;
    text-align:center;
    color:var(--muted);
    font-size:10px;
}
.updated { color:var(--muted); font-size:10px; text-align:right; margin-top:12px; }

@media(max-width:950px) {
    .studio-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .summary { grid-template-columns:repeat(3,minmax(0,1fr)); }
}
@media(max-width:620px) {
    .page { width:93%; padding-top:12px; }
    .topbar { align-items:flex-start; }
    .top-actions { flex-direction:column; align-items:stretch; }
    .hero { align-items:flex-start; flex-direction:column; padding:20px; }
    .hero h1 { font-size:23px; }
    .summary { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .studio-grid { grid-template-columns:1fr; }
    .studio-image { height:190px; }
}
</style>
</head>

<body>
<div class="page">

    <header class="topbar">
        <div class="brand">
            <img src="{{ asset('images/logbook-logo.png') }}" alt="Logo Logbook">
            <div>
                <div class="brand-title">Logbook Studio</div>
                <div class="brand-subtitle">Public Studio Monitoring</div>
            </div>
        </div>

        <div class="top-actions">
            <button type="button" class="theme-button" id="theme-toggle">
                <span id="theme-icon">🌙</span>
                <span id="theme-label">Mode Gelap</span>
            </button>
        </div>
    </header>

    <section class="hero">
        <div>
            <h1>Monitoring Studio</h1>
            <p>Pantau kondisi peralatan dan crew seluruh studio secara real-time.</p>
        </div>

        <form class="date-form" method="GET" action="{{ route('monitoring.public') }}">
            <label for="tanggal">Tanggal monitoring</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal }}">
            @if(!empty($studioFilter))
                <input type="hidden" name="studio" value="{{ $studioFilter }}">
            @endif
            <button type="submit">Tampilkan</button>
        </form>
    </section>

    <section class="summary" id="summary">
        <div class="stat">
            <div class="stat-label">TOTAL PERALATAN</div>
            <div class="stat-value" id="sum-total">{{ $summary['total'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">KONDISI BAIK</div>
            <div class="stat-value" id="sum-baik">{{ $summary['baik'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">KONDISI ERROR</div>
            <div class="stat-value" id="sum-error">{{ $summary['error'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">KONDISI RUSAK</div>
            <div class="stat-value" id="sum-rusak">{{ $summary['rusak'] ?? 0 }}</div>
        </div>
        <div class="stat">
            <div class="stat-label">BELUM DIPERIKSA</div>
            <div class="stat-value" id="sum-belum">{{ $summary['belum'] ?? 0 }}</div>
        </div>
    </section>

    <div class="section-heading">
        <div>
            <h2>Daftar Studio</h2>
            <p>Pilih studio untuk melihat detail crew dan kondisi peralatan.</p>
        </div>
        <p id="last-updated">Pembaruan otomatis setiap 5 detik</p>
    </div>

    <main class="studio-grid" id="studio-grid">
        @forelse($cards as $card)
            @php
                $image = match($card['slug']) {
                    'master-control-room' => 'images/studios/mcr.jpeg',
                    'berita' => 'images/studios/berita.jpeg',
                    'penyiaran' => 'images/studios/penyiaran.jpeg',
                    default => 'images/logbook-logo.png',
                };

                $displayName = match($card['slug']) {
                    'master-control-room' => 'Master Control Room',
                    'berita' => 'Studio Berita',
                    'penyiaran' => 'Studio 9',
                    default => $card['nama'],
                };

                $statusClass = ($card['lengkap'] ?? false)
                    ? 'normal'
                    : (($card['diperiksa'] ?? 0) > 0 ? 'warning' : 'danger');

                $statusLabel = ($card['lengkap'] ?? false)
                    ? 'LENGKAP'
                    : (($card['diperiksa'] ?? 0) > 0 ? 'BELUM LENGKAP' : 'BELUM DIPERIKSA');
            @endphp

            <article class="studio-card">
                <div class="studio-image">
                    <img src="{{ asset($image) }}" alt="{{ $card['nama'] }}"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="image-fallback" style="display:none;">Gambar studio belum tersedia</div>
                </div>

                <div class="studio-body">
                    <div class="studio-title-row">
                        <h3 class="studio-title">
                            {{ $displayName }}
                        </h3>
                        <span class="status {{ $statusClass }}">{{ $statusLabel }}</span>
                    </div>

                    <div class="card-stats">
                        <div class="card-stat">
                            <span>PERALATAN DIPERIKSA</span>
                            <strong class="checked">{{ $card['diperiksa'] }}</strong>
                        </div>
                        <div class="card-stat">
                            <span>TOTAL PERALATAN</span>
                            <strong class="total">{{ $card['total'] }}</strong>
                        </div>
                    </div>

                    <div class="progress-track">
                        <div class="progress-bar"
                             style="width:{{ $card['total'] > 0 ? min(100, ($card['diperiksa'] / $card['total']) * 100) : 0 }}%">
                        </div>
                    </div>

                    <div class="crew-preview">
                        <div class="crew-label">CREW BERTUGAS</div>
                        <div class="crew-list">
                            @forelse($card['crew'] as $namaCrew)
                                @if($namaCrew && $namaCrew !== '-')
                                    <span class="crew-chip">{{ $namaCrew }}</span>
                                @endif
                            @empty
                                <span class="no-crew">Belum ada crew tercatat.</span>
                            @endforelse
                        </div>
                    </div>

                    <a class="detail-link"
                       href="{{ route('monitoring.public.detail', ['studio' => $card['slug'], 'tanggal' => $tanggal]) }}">
                        Lihat Detail →
                    </a>
                </div>
            </article>
        @empty
            <p class="no-crew">Tidak ada studio yang ditemukan.</p>
        @endforelse
    </main>

    <footer class="footer">
        © {{ date('Y') }} Logbook Studio · Public Monitoring
    </footer>

</div>

<script>
const dataUrl = @json(route('monitoring.public.data'));
const selectedDate = @json($tanggal);
const selectedStudio = @json($studioFilter ?? '');

function applyTheme(theme) {
    document.documentElement.dataset.theme = theme;

    const dark = theme === 'dark';
    document.getElementById('theme-icon').textContent = dark ? '☀️' : '🌙';
    document.getElementById('theme-label').textContent = dark ? 'Mode Terang' : 'Mode Gelap';
}

function getTheme() {
    try {
        return localStorage.getItem('logbook-theme') || 'light';
    } catch(e) {
        return 'light';
    }
}

document.getElementById('theme-toggle').addEventListener('click', function() {
    const next = getTheme() === 'dark' ? 'light' : 'dark';

    try {
        localStorage.setItem('logbook-theme', next);
    } catch(e) {}

    applyTheme(next);
});

applyTheme(getTheme());

window.addEventListener('storage', function(event) {
    if (event.key === 'logbook-theme') {
        applyTheme(event.newValue || 'light');
    }
});

function esc(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#039;'
    }[char]));
}

function renderCard(card) {
    const image = {
        'master-control-room': "{{ asset('images/studios/mcr.jpeg') }}",
        'berita': "{{ asset('images/studios/berita.jpeg') }}",
        'penyiaran': "{{ asset('images/studios/penyiaran.jpeg') }}"
    }[card.slug] || "{{ asset('images/logbook-logo.png') }}";

    const total = Number(card.total || 0);
    const checked = Number(card.diperiksa || 0);
    const percentage = total > 0 ? Math.min(100, checked / total * 100) : 0;

    const complete = card.lengkap === true;
    const statusClass = complete ? 'normal' : (checked > 0 ? 'warning' : 'danger');
    const statusLabel = complete ? 'LENGKAP' : (checked > 0 ? 'BELUM LENGKAP' : 'BELUM DIPERIKSA');

    const crew = Array.isArray(card.crew) ? card.crew : [];
    const crewHtml = crew.length
        ? crew.filter(name => name && name !== '-').map(name =>
            `<span class="crew-chip">${esc(name)}</span>`
          ).join('')
        : '<span class="no-crew">Belum ada crew tercatat.</span>';

    const detailUrl = `/monitoring/${encodeURIComponent(card.slug)}?tanggal=${encodeURIComponent(selectedDate)}`;

    const studioName = ({
        'master-control-room': 'Master Control Room',
        'berita': 'Studio Berita',
        'penyiaran': 'Studio 9'
    })[card.slug] || String(card.nama || '');

    return `
        <article class="studio-card">
            <div class="studio-image">
                <img src="${image}" alt="${esc(studioName)}"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="image-fallback" style="display:none">Gambar studio belum tersedia</div>
            </div>
            <div class="studio-body">
                <div class="studio-title-row">
                    <h3 class="studio-title">${esc(studioName)}</h3>
                    <span class="status ${statusClass}">${statusLabel}</span>
                </div>
                <div class="card-stats">
                    <div class="card-stat">
                        <span>PERALATAN DIPERIKSA</span>
                        <strong class="checked">${checked}</strong>
                    </div>
                    <div class="card-stat">
                        <span>TOTAL PERALATAN</span>
                        <strong class="total">${total}</strong>
                    </div>
                </div>
                <div class="progress-track">
                    <div class="progress-bar" style="width:${percentage}%"></div>
                </div>
                <div class="crew-preview">
                    <div class="crew-label">CREW BERTUGAS</div>
                    <div class="crew-list">${crewHtml}</div>
                </div>
                <a class="detail-link" href="${detailUrl}">Lihat Detail →</a>
            </div>
        </article>
    `;
}

function updateSummary(summary) {
    if (!summary) return;
    document.getElementById('sum-total').textContent = summary.total ?? 0;
    document.getElementById('sum-baik').textContent = summary.baik ?? 0;
    document.getElementById('sum-error').textContent = summary.error ?? 0;
    document.getElementById('sum-rusak').textContent = summary.rusak ?? 0;
    document.getElementById('sum-belum').textContent = summary.belum ?? 0;
}

async function refreshMonitoring() {
    try {
        const params = new URLSearchParams({tanggal:selectedDate});
        if (selectedStudio) params.set('studio', selectedStudio);

        const response = await fetch(`${dataUrl}?${params.toString()}`, {
            headers:{'Accept':'application/json'},
            cache:'no-store'
        });

        if (!response.ok) return;

        const data = await response.json();
        const cards = Array.isArray(data.cards) ? data.cards : [];

        document.getElementById('studio-grid').innerHTML =
            cards.length
                ? cards.map(renderCard).join('')
                : '<p class="no-crew">Tidak ada studio yang ditemukan.</p>';

        updateSummary(data.summary);

        document.getElementById('last-updated').textContent =
            `Terakhir diperbarui ${data.updated_at || ''}`;

    } catch(error) {
        console.error('Monitoring refresh gagal:', error);
    }
}

setInterval(refreshMonitoring, 5000);
</script>

</body>
</html>
