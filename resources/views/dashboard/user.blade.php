<!DOCTYPE html>

<html lang="id">

<head>

    <link rel="icon" type="image/png"

      href="{{ asset('images/logbook-logo.png') }}?v=2">

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard User | Logbook Studio</title>

    <style>

        :root {

            --teal: #087f73;

            --teal-dark: #075f57;

            --teal-light: #e5f5f1;

            --background: #f6f8f8;

            --white: #ffffff;

            --text: #243532;

            --muted: #73817e;

            --border: #e5ecea;

        }

        * {

            box-sizing: border-box;

            margin: 0;

            padding: 0;

        }

        body {

            font-family: "Segoe UI", Arial, sans-serif;

            background: var(--background);

            color: var(--text);

            min-height: 100vh;

        }

        a {

            color: inherit;

            text-decoration: none;

        }

        .navbar {

            min-height: 76px;

            padding: 0 7%;

            background: var(--white);

            border-bottom: 1px solid var(--border);

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

        }

        .brand {

            display: flex;

            align-items: center;

            gap: 12px;

        }

        .brand-icon {

            width: 44px;

            height: 44px;

            display: grid;

            place-items: center;

            background: var(--teal);

            color: white;

            border-radius: 13px;

            font-size: 25px;

        }

        .brand-name {

            font-size: 17px;

            font-weight: 750;

        }

        .brand-subtitle {

            color: var(--muted);

            font-size: 11px;

            margin-top: 4px;

        }

        .nav-right {

            display: flex;

            align-items: center;

            gap: 20px;

        }

        .user-profile {

            display: flex;

            align-items: center;

            gap: 10px;

        }

        .avatar {

            width: 40px;

            height: 40px;

            display: grid;

            place-items: center;

            border-radius: 50%;

            background: var(--teal-light);

            color: var(--teal-dark);

            font-weight: 700;

        }

        .user-name {

            font-size: 13px;

            font-weight: 700;

        }

        .user-role {

            margin-top: 3px;

            color: var(--muted);

            font-size: 11px;

            text-transform: capitalize;

        }

        .logout-button {

            padding: 10px 15px;

            border: 1px solid var(--border);

            border-radius: 9px;

            background: white;

            color: var(--text);

            font-size: 12px;

            font-weight: 600;

            cursor: pointer;

        }

        .logout-button:hover {

            background: var(--teal-light);

            color: var(--teal-dark);

        }

        .container {

            width: 86%;

            max-width: 1180px;

            margin: 0 auto;

            padding: 35px 0 45px;

        }

        .breadcrumb {

            margin-bottom: 20px;

            color: var(--muted);

            font-size: 12px;

        }

        .welcome {

            position: relative;

            overflow: hidden;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 25px;

            padding: 36px 40px;

            border-radius: 20px;

            background: linear-gradient(120deg, #075f57, #0d9383);

            color: white;

        }

        .welcome-content {

            position: relative;

            z-index: 1;

        }

        .welcome-tag {

            display: inline-block;

            margin-bottom: 16px;

            padding: 7px 12px;

            border: 1px solid rgba(255,255,255,.25);

            border-radius: 30px;

            font-size: 10px;

            letter-spacing: 1px;

            text-transform: uppercase;

        }

        .welcome h1 {

            margin-bottom: 12px;

            font-size: clamp(25px, 3vw, 34px);

            line-height: 1.3;

        }

        .welcome p {

            max-width: 570px;

            color: #e0f2ee;

            font-size: 13px;

            line-height: 1.8;

        }

        .welcome-icon {

            display: grid;

            place-items: center;

            flex-shrink: 0;

            width: 100px;

            height: 100px;

            border: 1px solid rgba(255,255,255,.22);

            border-radius: 25px;

            background: rgba(255,255,255,.10);

            font-size: 49px;

        }

        .section-heading {

            display: flex;

            align-items: end;

            justify-content: space-between;

            gap: 15px;

            margin: 35px 0 18px;

        }

        .section-heading h2 {

            font-size: 21px;

            letter-spacing: -.4px;

        }

        .section-heading p {

            margin-top: 7px;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.7;

        }

        .section-label {

            color: var(--teal);

            font-size: 12px;

            font-weight: 700;

        }

        .studio-grid {

            display: grid;

            grid-template-columns: repeat(3, minmax(0, 1fr));

            gap: 20px;

        }

        .studio-card {

            display: flex;

            flex-direction: column;

            min-width: 0;

            overflow: hidden;

            background: white;

            border: 1px solid var(--border);

            border-radius: 17px;

            transition: transform .2s ease, box-shadow .2s ease;

        }

        .studio-card:hover {

            transform: translateY(-4px);

            box-shadow: 0 12px 28px rgba(25, 70, 62, .09);

        }

        .studio-visual {

            position: relative;

            display: grid;

            place-items: center;

            height: 175px;

            overflow: hidden;

            background: linear-gradient(135deg, #e5f5f1, #d3e9e3);

        }

        .studio-visual img {

            width: 100%;

            height: 100%;

            object-fit: cover;

        }

        .studio-placeholder {

            display: grid;

            place-items: center;

            gap: 9px;

            color: var(--teal-dark);

        }

        .studio-placeholder span {

            font-size: 46px;

        }

        .studio-placeholder small {

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 1px;

        }

        .studio-content {

            display: flex;

            flex: 1;

            flex-direction: column;

            padding: 22px;

        }

        .studio-number {

            margin-bottom: 11px;

            color: var(--teal);

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1.2px;

        }

        .studio-content h3 {

            margin-bottom: 9px;

            font-size: 17px;

            line-height: 1.4;

        }

        .studio-content p {

            flex: 1;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.8;

        }

        .studio-button {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            width: 100%;

            margin-top: 22px;

            padding: 12px 14px;

            border: 0;

            border-radius: 9px;

            background: var(--teal);

            color: white;

            font-size: 12px;

            font-weight: 700;

            transition: **background** .2s ease;

        }

        .studio-button:hover {

            background: var(--teal-dark);

        }

        .info-panel {

            display: flex;

            align-items: flex-start;

            gap: 15px;

            margin-top: 25px;

            padding: 20px 22px;

            border: 1px solid #dcece7;

            border-radius: 14px;

            background: #edf7f3;

        }

        .info-icon {

            font-size: 23px;

        }

        .info-panel h3 {

            margin-bottom: 5px;

            font-size: 13px;

        }

        .info-panel p {

            color: #61766e;

            font-size: 12px;

            line-height: 1.8;

        }

        footer {

            display: flex;

            justify-content: space-between;

            gap: 12px;

            margin-top: 35px;

            padding-top: 18px;

            border-top: 1px solid var(--border);

            color: var(--muted);

            font-size: 11px;

        }

        @media (max-width: 900px) {

            .studio-grid {

                grid-template-columns: repeat(2, minmax(0, 1fr));

            }

        }

        @media (max-width: 600px) {

            .navbar {

                padding: 15px 5%;

                flex-wrap: wrap;

            }

            .nav-right {

                width: 100%;

                justify-content: space-between;

                gap: 10px;

            }

            .container {

                width: 90%;

                padding-top: 25px;

            }

            .welcome {

                padding: 28px 24px;

            }

            .welcome-icon {

                display: none;

            }

            .studio-grid {

                grid-template-columns: 1fr;

            }

            .studio-visual {

                height: 190px;

            }

            .section-heading {

                align-items: flex-start;

                flex-direction: column;

            }

            footer {

                flex-direction: column;

            }

        }

    </style>

</head>

<body>

    <header class="navbar">

        <a href="{{ route('dashboard.user') }}" class="brand">

            <img

    src="{{ asset('images/logbook-logo.png') }}"

    alt="Logo Logbook Studio"

    class="brand-icon"

>

            <div>

                <div class="brand-name">Logbook Studio</div>

                <div class="brand-subtitle">Studio Equipment Inspection</div>

            </div>

        </a>

        <div class="nav-right">
<div class="user-profile">

                <div class="avatar">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <div>

                    <div class="user-name">

                        {{ auth()->user()->name }}

                    </div>

                    <div class="user-role">

                        {{ str_replace('_', ' ', auth()->user()->role) }}

                    </div>

                </div>

            </div>

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button type="submit" class="logout-button">

                    Keluar ↗

                </button>

            </form>

        </div>

    </header>

    <main class="container">

        <div class="breadcrumb">

            Workspace / Dashboard / Pilih Studio

        </div>

        <section class="welcome">

            <div class="welcome-content">

                <span class="welcome-tag">Workspace Pengguna</span>

                <h1>

                    Halo, {{ auth()->user()->name }}!

                    <br>Siap memeriksa peralatan?

                </h1>

                <p>

                    Pilih studio tempat kamu bertugas untuk melihat

                    daftar peralatan dan mengisi checklist kondisi barang.

                    Pastikan pemeriksaan dilakukan dengan teliti.

                </p>

            </div>

            <div class="welcome-icon" aria-hidden="true">✓</div>

        </section>

        <section>

            <div class="section-heading">

                <div>

                    <h2>Pilih Studio</h2>

                    <p>

                        Pilih salah satu studio untuk memulai pemeriksaan

                        kondisi peralatan.

                    </p>

                </div>

                <span class="section-label">3 Studio Tersedia</span>

            </div>

            <div class="studio-grid">

                {{-- Master Control Room --}}

                <article class="studio-card">

                    <div class="studio-visual">

                        <img

                            src="{{ asset('images/studios/mcr.jpeg') }}"

                            alt="Master Control Room"

                            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"

                        >

                        <div class="studio-placeholder" style="display:none;">

                            <span>🎛️</span>

                            <small>MASTER CONTROL ROOM</small>

                        </div>

                    </div>

                    <div class="studio-content">

                        <div class="studio-number">STUDIO 01</div>

                        <h3>Master Control Room</h3>

                        <p>

                            Periksa kondisi perangkat kontrol, monitor,

                            dan peralatan pendukung ruang kendali.

                        </p>

                        <a

                            href="{{ route('dashboard.checklist', ['studio' => 'Studio Master Control Room']) }}"

                            class="studio-button"

                        >

                            Mulai Pemeriksaan <span>→</span>

                        </a>

                    </div>

                </article>

                {{-- Studio Berita --}}

                <article class="studio-card">

                    <div class="studio-visual">

                        <img

                            src="{{ asset('images/studios/berita.jpeg') }}"

                            alt="Studio Berita"

                            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"

                        >

                        <div class="studio-placeholder" style="display:none;">

                            <span>🎥</span>

                            <small>STUDIO BERITA</small>

                        </div>

                    </div>

                    <div class="studio-content">

                        <div class="studio-number">STUDIO 02</div>

                        <h3>Studio Berita</h3>

                        <p>

                            Periksa kondisi kamera, mikrofon, pencahayaan,

                            dan peralatan produksi berita.

                        </p>

                        <a

                            href="{{ route('dashboard.checklist', ['studio' => 'Studio Berita']) }}"

                            class="studio-button"

                        >

                            Mulai Pemeriksaan <span>→</span>

                        </a>

                    </div>

                </article>

                {{-- Studio Penyiaran --}}

                <article class="studio-card">

                    <div class="studio-visual">

                        <img

                            src="{{ asset('images/studios/penyiaran.jpeg') }}"

                            alt="Studio Penyiaran"

                            onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"

                        >

                        <div class="studio-placeholder" style="display:none;">

                            <span>🎙️</span>

                            <small>STUDIO PENYIARAN</small>

                        </div>

                    </div>

                    <div class="studio-content">

                        <div class="studio-number">STUDIO 03</div>

                        <h3>Studio Penyiaran</h3>

                        <p>

                            Periksa kondisi mikrofon, mixer audio,

                            headphone, dan peralatan penyiaran.

                        </p>

                        <a

                            href="{{ route('dashboard.checklist', ['studio' => 'Studio Penyiaran']) }}"

                            class="studio-button"

                        >

                            Mulai Pemeriksaan <span>→</span>

                        </a>

                    </div>

                </article>

            </div>

        </section>

        <section class="info-panel">

            <div class="info-icon">ℹ️</div>

            <div>

                <h3>Petunjuk pemeriksaan</h3>

                <p>

                    Pilih studio yang sesuai sebelum mengisi checklist.

                    Catat kondisi barang dengan benar dan tambahkan

                    keterangan jika terdapat kerusakan atau kendala.

                </p>

            </div>

        </section>

        <footer>

            <span>© {{ date('Y') }} Logbook Studio</span>

            <span>Workspace Pemeriksaan Peralatan Studio</span>

        </footer>

    </main>

</body>

</html>
