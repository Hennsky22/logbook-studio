<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Monitoring Publik | Logbook Studio</title>
<link rel="icon" href="{{ asset('images/logbook-logo.png') }}">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    background: #f2f8f7;
    color: #19343a;
    font-family: "DM Sans", sans-serif;
    font-size: 13px;
}

.wrap {
    width: min(1460px, 96%);
    margin: auto;
    padding: 18px 0 12px;
}

.nav {
    height: 54px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 9px;
}

.brand img {
    width: 43px;
    height: 43px;
    object-fit: contain;
}

.brand b {
    font-size: 16px;
}

.brand small {
    display: block;
    color: #82999b;
    font-size: 10px;
}

.pill {
    background: #dff3ee;
    color: #087b6c;
    border-radius: 20px;
    padding: 8px 14px;
    font-size: 10px;
    font-weight: 800;
}

/* HERO */
.hero {
    height: 136px;
    border-radius: 17px;
    padding: 25px 28px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    overflow: hidden;
    background: linear-gradient(110deg, #087b6b, #0b9e8b 68%, #14b7a2);
    position: relative;
    box-shadow: 0 10px 25px #0b75631c;
}

.hero:after {
    content: "";
    position: absolute;
    width: 300px;
    height: 220px;
    right: 90px;
    top: -55px;
    border: 1px solid #ffffff30;
    border-radius: 50%;
    transform: rotate(-25deg);
    box-shadow: 0 0 0 22px #ffffff08, 0 0 0 45px #ffffff08;
}

.hero h1 {
    font-size: 31px;
    margin: 0 0 6px;
    letter-spacing: -.8px;
}

.hero p {
    margin: 0;
    font-size: 13px;
    color: #e0fffa;
}

.hero-camera {
    font-size: 64px;
    opacity: .9;
    margin-right: 36px;
    z-index: 1;
}

/* FILTER */
.filters {
    margin: 14px 0 19px;
    background: white;
    border: 1px solid #e1ece9;
    border-radius: 14px;
    padding: 11px 15px;
    display: flex;
    align-items: end;
    gap: 12px;
    box-shadow: 0 4px 12px #183d3508;
}

.filters label {
    display: grid;
    gap: 4px;
    color: #70888a;
    font-size: 10px;
}

.filters input,
.filters select {
    height: 40px;
    min-width: 190px;
    border: 1px solid #dce8e5;
    border-radius: 8px;
    padding: 0 10px;
    color: #24454a;
    background: #fff;
    font: inherit;
    font-size: 12px;
}

.btn {
    height: 40px;
    border: 0;
    border-radius: 8px;
    padding: 0 18px;
    background: #078778;
    color: #fff;
    font-weight: 800;
    font-size: 11px;
    cursor: pointer;
}

.btn:hover {
    background: #075f57;
}

.btn-reset {
    height: 40px;
    padding: 0 14px;
    background: #edf3f1;
    color: #526b6b;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
}

/* STUDIO GRID */
.grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 17px;
    align-items: start;
}

.card {
    background: #fff;
    border: 1px solid #e2ece9;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 7px 18px #173c3310;
    min-width: 0;
}

/* GAMBAR STUDIO */
.photo {
    height: 190px;
    position: relative;
    overflow: hidden;
    background: #e5f5f1;
}

.photo img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
    object-position: center;
    transition: transform .35s ease;
}

.card:hover .photo img {
    transform: scale(1.04);
}

.photo:after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0, 35, 35, .22),
        transparent 55%
    );
    pointer-events: none;
}

.round-icon {
    position: absolute;
    bottom: -18px;
    left: 18px;
    width: 42px;
    height: 42px;
    border: 3px solid white;
    border-radius: 50%;
    background: #087f70;
    color: white;
    display: grid;
    place-items: center;
    font-size: 17px;
    z-index: 2;
}

/* CARD CONTENT */
.card-content {
    padding: 20px 15px 0;
}

.card-title-row {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    align-items: center;
}

.card h2 {
    font-size: 15px;
    margin: 0;
    font-weight: 800;
}

.badge {
    white-space: nowrap;
    border-radius: 20px;
    padding: 5px 9px;
    font-size: 9px;
    font-weight: 800;
}

.complete {
    background: #d9f5e7;
    color: #13854d;
}

.incomplete {
    background: #fff0d9;
    color: #b66b08;
}

.examiner {
    margin: 5px 0 10px;
    color: #819394;
    font-size: 10px;
}

.equipment-title {
    border-top: 1px solid #e7efed;
    padding: 10px 2px 7px;
    font-size: 11px;
    font-weight: 800;
    color: #38565a;
}

.preview-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.preview-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    padding: 6px 2px;
    color: #536b6d;
    font-size: 11px;
    border-bottom: 1px solid #f0f4f3;
}

.preview-list li span:first-child {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.status {
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 9px;
    font-weight: 800;
    white-space: nowrap;
}

.baik {
    background: #d4f3df;
    color: #13834c;
}

.error {
    background: #ffe7bd;
    color: #a86600;
}

.rusak {
    background: #ffd9dc;
    color: #c12c39;
}

.belum {
    background: #edf1f1;
    color: #738184;
}

/* DETAIL */
.detail-link {
    display: block;
    text-align: center;
    padding: 11px;
    border-top: 1px solid #edf2f0;
    margin-top: 5px;
    color: #078778;
    text-decoration: none;
    font-size: 11px;
    font-weight: 800;
}

.detail-link:hover {
    background: #f2fbf8;
}

.footer {
    text-align: center;
    color: #91a5a5;
    font-size: 10px;
    padding: 17px 0 5px;
}

/* RESPONSIVE */
@media(max-width: 900px) {
    .grid {
        grid-template-columns: 1fr 1fr;
    }

    .hero-camera {
        margin-right: 5px;
    }
}

@media(max-width: 620px) {
    .wrap {
        width: 94%;
    }

    .grid {
        grid-template-columns: 1fr;
    }

    .hero {
        height: 112px;
        padding: 20px;
    }

    .hero h1 {
        font-size: 25px;
    }

    .hero-camera {
        font-size: 42px;
    }

    .filters {
        flex-wrap: wrap;
    }

    .filters label,
    .filters input,
    .filters select {
        width: 100%;
    }

    .filters .btn {
        flex: 1;
    }

    .photo {
        height: 190px;
    }
}
</style>
</head>

<body>
<div class="wrap">

    <!-- NAVBAR -->
    <header class="nav">
        <div class="brand">
            <img src="{{ asset('images/logbook-logo.png') }}" alt="Logo">
            <div>
                <b>Logbook Studio</b>
                <small>Studio Equipment Inspection</small>
            </div>
        </div>

        <span class="pill">● Monitoring Publik</span>
    </header>

    <!-- HERO -->
    <section class="hero">
        <div>
            <h1>Monitoring Publik</h1>
            <p>Informasi kondisi peralatan dan aktivitas studio secara real-time</p>
        </div>

        <div class="hero-camera">▣</div>
    </section>

    <!-- FILTER -->
    <form class="filters"
          method="GET"
          action="{{ route('monitoring.public') }}"
          id="filter-form">

        <label>
            Pilih Tanggal
            <input
                type="date"
                name="tanggal"
                id="tanggal"
                value="{{ $tanggal }}"
            >
        </label>

        <label>
            Pilih Studio
            <select name="studio" id="studio">
                <option value="">Semua Studio</option>

                <option value="master-control-room"
                    @selected($studioFilter === 'master-control-room')>
                    Studio Master Control Room
                </option>

                <option value="berita"
                    @selected($studioFilter === 'berita')>
                    Studio Berita
                </option>

                <option value="penyiaran"
                    @selected($studioFilter === 'penyiaran')>
                    Studio Penyiaran
                </option>
            </select>
        </label>

        <button class="btn" type="submit">
            ↻ &nbsp; Refresh
        </button>
    </form>

    <!-- STUDIO CARDS -->
    <main class="grid" id="studio-cards">

        @foreach($cards as $card)

            @php
                $photo = match($card['slug']) {
                    'master-control-room' => 'images/studios/mcr.jpeg',
                    'berita' => 'images/studios/berita.jpeg',
                    'penyiaran' => 'images/studios/penyiaran.jpeg',
                    default => 'images/studios/mcr.jpeg'
                };

                $symbol = match($card['slug']) {
                    'master-control-room' => '▥',
                    'berita' => '▣',
                    default => '▶'
                };
            @endphp

            <article class="card">

                <!-- FOTO STUDIO SESUAI DASHBOARD USER -->
                <div class="photo">
                    <img
                        src="{{ asset($photo) }}"
                        alt="{{ $card['nama'] }}"
                        loading="lazy"
                    >

                    <span class="round-icon">
                        {{ $symbol }}
                    </span>
                </div>

                <!-- INFORMASI STUDIO -->
                <div class="card-content">

                    <div class="card-title-row">

                        <h2>{{ $card['nama'] }}</h2>

                        <span class="badge {{ $card['lengkap'] ? 'complete' : 'incomplete' }}">
                            {{ $card['lengkap'] ? '✓ Lengkap' : '! Belum Lengkap' }}
                        </span>

                    </div>

                    <p class="examiner">
                        Diperiksa oleh:
                        {{ $card['petugas']->isNotEmpty()
                            ? $card['petugas']->implode(', ')
                            : '-' }}
                    </p>

                    <div class="equipment-title">
                        ◇ &nbsp;Daftar Peralatan
                    </div>

                    <ul class="preview-list">

                        @forelse($card['items']->take(3) as $item)

                            @php
                                $condition = strtolower(
                                    (string) $item->monitoring_pemeriksaan?->kondisi
                                );

                                $statusClass = match($condition) {
                                    'baik' => 'baik',
                                    'error' => 'error',
                                    'rusak' => 'rusak',
                                    default => 'belum'
                                };

                                $statusText = $condition
                                    ? ucfirst($condition)
                                    : 'Belum dicek';
                            @endphp

                            <li>
                                <span>{{ $item->nama_barang }}</span>

                                <span class="status {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </li>

                        @empty

                            <li>
                                <span>Belum ada barang terdaftar.</span>
                            </li>

                        @endforelse

                    </ul>

                </div>

                <!-- TOMBOL DETAIL -->
                <a
                    class="detail-link"
                    href="{{ route('monitoring.public.detail', [
                        'studio' => $card['slug'],
                        'tanggal' => $tanggal
                    ]) }}"
                >
                    Lihat Detail →
                </a>

            </article>

        @endforeach

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        © {{ date('Y') }} Logbook Studio &nbsp;·&nbsp; Monitoring Publik
    </footer>

</div>

<!-- AUTO REFRESH DATA -->
<script>
const dataUrl = @json(route('monitoring.public.data'));

const form = document.getElementById('filter-form');

async function refreshCards() {

    const params = new URLSearchParams({
        tanggal: document.getElementById('tanggal').value,
        studio: document.getElementById('studio').value
    });

    try {

        const response = await fetch(
            `${dataUrl}?${params}`,
            {
                headers: {
                    'Accept': 'application/json'
                },
                cache: 'no-store'
            }
        );

        if (!response.ok) return;

        const data = await response.json();

        const cards = document.querySelectorAll('.card');

        data.cards.forEach((card, index) => {

            const element = cards[index];

            if (!element) return;

            // UPDATE STATUS
            const badge = element.querySelector('.badge');

            badge.textContent = card.lengkap
                ? '✓ Lengkap'
                : '! Belum Lengkap';

            badge.className = 'badge ' +
                (card.lengkap ? 'complete' : 'incomplete');

            // UPDATE PETUGAS
            const examiner = element.querySelector('.examiner');

            examiner.textContent =
                'Diperiksa oleh: ' +
                (card.petugas.length
                    ? card.petugas.join(', ')
                    : '-');

            // UPDATE DAFTAR PERALATAN
            const list = element.querySelector('.preview-list');

            list.innerHTML = card.items.slice(0, 3).map(item => {

                const value = String(
                    item.kondisi || ''
                ).toLowerCase();

                const cls = [
                    'baik',
                    'error',
                    'rusak'
                ].includes(value)
                    ? value
                    : 'belum';

                const label = value
                    ? value.charAt(0).toUpperCase() + value.slice(1)
                    : 'Belum dicek';

                return `
                    <li>
                        <span>${escapeText(item.nama_barang)}</span>
                        <span class="status ${cls}">${label}</span>
                    </li>
                `;

            }).join('') || `
                <li>
                    <span>Belum ada barang terdaftar.</span>
                </li>
            `;

        });

    } catch (e) {
        console.error('Gagal memperbarui monitoring:', e);
    }
}

// MENGAMANKAN TEKS DARI DATA SERVER
function escapeText(value) {

    return String(value ?? '').replace(
        /[&<>"']/g,
        c => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[c])
    );

}

// FILTER TANGGAL DAN STUDIO
form.addEventListener('submit', e => {

    e.preventDefault();

    const url = new URL(window.location.href);

    url.searchParams.set(
        'tanggal',
        document.getElementById('tanggal').value
    );

    const studio = document.getElementById('studio').value;

    if (studio) {
        url.searchParams.set('studio', studio);
    } else {
        url.searchParams.delete('studio');
    }

    window.location.href = url;

});

// GANTI STUDIO OTOMATIS
document.getElementById('studio').addEventListener(
    'change',
    () => form.requestSubmit()
);

// REFRESH DATA SETIAP 5 DETIK
setInterval(refreshCards, 5000);

</script>

</body>
</html>
