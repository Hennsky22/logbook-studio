<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png"

      href="{{ asset('images/logbook-logo.png') }}?v=2">

    <title>Login | Logbook Studio</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --teal: #087f75;
            --teal-dark: #064e49;
            --text: #243746;
            --muted: #81909c;
            --border: #e3eaed;
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f3f7f8;
            color: var(--text);
        }

        .login-container {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 0.9fr;
            background: white;
        }

        /* BAGIAN KIRI */

        .brand-panel {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 65px 9%;
            color: white;
            background:
                radial-gradient(
                    circle at 10% 90%,
                    rgba(18, 190, 164, 0.25),
                    transparent 35%
                ),
                linear-gradient(145deg, #073b3a, #075e56 65%, #087f75);
        }

        .brand-panel::before,
        .brand-panel::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 50%;
            pointer-events: none;
        }

        .brand-panel::before {
            width: 550px;
            height: 550px;
            right: -300px;
            top: -180px;
        }

        .brand-panel::after {
            width: 450px;
            height: 450px;
            left: -300px;
            bottom: -200px;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            max-width: 540px;
            margin: auto;
            width: 100%;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 48px;
        }

        .logo-icon {
            width: 58px;
            height: 58px;
            flex: 0 0 58px;
            display: block;
            object-fit: contain;
            padding: 6px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .brand-logo h2 {
            font-size: 23px;
            letter-spacing: -0.5px;
        }

        .brand-logo p {
            font-size: 12px;
            margin-top: 5px;
            color: #b9d8d5;
        }

        .brand-heading {
            font-size: clamp(30px, 3.3vw, 43px);
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .brand-heading span {
            color: #72e0ca;
        }

        .brand-description {
            max-width: 440px;
            color: #c6dfdc;
            line-height: 1.8;
            font-size: 15px;
            margin-bottom: 38px;
        }

        .features {
            display: grid;
            gap: 24px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .feature-icon {
            width: 45px;
            height: 45px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: #8ae6d4;
            font-size: 21px;
        }

        .feature h3 {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .feature p {
            font-size: 12px;
            color: #b9d8d5;
            line-height: 1.6;
        }

        .brand-footer {
            position: relative;
            z-index: 1;
            margin-top: 45px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            color: #b9d8d5;
            font-size: 11px;
        }

        /* BAGIAN KANAN */

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 45px 10%;
            background: #ffffff;
        }

        .login-card {
            width: 100%;
            max-width: 410px;
        }

        .mobile-logo {
            display: none;
        }


        /* LOGO TVRI DI ATAS FORM LOGIN */
        .tvri-logo {
            width: 190px;
            height: auto;
            display: block;
            margin: 0 auto 12px;
        }

        .login-heading,
        .login-subtitle {
            text-align: center;
        }

        .login-heading {
            font-size: 30px;
            letter-spacing: -0.8px;
            margin-bottom: 10px;
            color: #172f3a;
        }

        .login-subtitle {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 35px;
        }

        .alert-error {
            padding: 12px 14px;
            border-radius: 9px;
            margin-bottom: 20px;
            color: #b42318;
            background: #fff0ee;
            border: 1px solid #f8d2cc;
            font-size: 13px;
            line-height: 1.7;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 650;
            margin-bottom: 9px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap input {
            width: 100%;
            height: 49px;
            padding: 0 44px 0 15px;
            border: 1px solid var(--border);
            border-radius: 10px;
            outline: none;
            background: #fff;
            font: inherit;
            font-size: 13px;
            color: var(--text);
            transition: 0.2s;
        }

        .input-wrap input::placeholder {
            color: #a1adb5;
        }

        .input-wrap input:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(8, 127, 117, 0.1);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #84949e;
            font-size: 17px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #84949e;
            font-size: 12px;
            cursor: pointer;
            padding: 5px;
        }

        .password-toggle:hover {
            color: var(--teal);
        }

        .password-input {
            padding-right: 60px !important;
        }

        .login-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 2px 0 25px;
        }

        .remember-option {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #526570;
            font-size: 12px;
            cursor: pointer;
        }

        .remember-option input {
            accent-color: var(--teal);
            width: 15px;
            height: 15px;
        }

        .login-button {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            width: 100%;
            min-height: 51px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(100deg, #087f75, #06665e);
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 18px rgba(8, 127, 117, 0.2);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-note {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 27px;
            color: #96a1a8;
            font-size: 11px;
            text-align: center;
        }

        .login-note::before,
        .login-note::after {
            content: "";
            height: 1px;
            background: var(--border);
            flex: 1;
        }

        .login-bottom {
            margin-top: 42px;
            text-align: center;
            color: #9aa6ad;
            font-size: 11px;
            line-height: 1.8;
        }

        @media (max-width: 900px) {
            .login-container {
                grid-template-columns: 0.85fr 1fr;
            }

            .brand-panel {
                padding: 45px 8%;
            }

            .form-panel {
                padding: 40px 7%;
            }

            .brand-logo {
                margin-bottom: 35px;
            }

            .feature p {
                font-size: 11px;
            }
        }

        @media (max-width: 650px) {
            .login-container {
                display: block;
                min-height: 100vh;
            }

            .brand-panel {
                display: none;
            }

            .form-panel {
                min-height: 100vh;
                padding: 32px 24px;
                background: #f5f9f9;
            }

            .login-card {
                max-width: 430px;
                padding: 30px 24px;
                background: white;
                border: 1px solid #edf1f2;
                border-radius: 18px;
                box-shadow: 0 10px 35px rgba(23, 65, 70, 0.06);
            }

            .mobile-logo {
                display: flex;
                align-items: center;
                gap: 11px;
                margin-bottom: 35px;
            }

            .mobile-logo .logo-icon {
                width: 43px;
                height: 43px;
                flex-basis: 43px;
                padding: 5px;
                background: #ffffff;
                border: 1px solid #e3eaed;
            }

            .mobile-logo h2 {
                font-size: 17px;
            }

            .mobile-logo p {
                font-size: 10px;
                margin-top: 4px;
                color: var(--muted);
            }

            .login-heading {
                font-size: 27px;
            }

            .login-subtitle {
                margin-bottom: 28px;
            }

            .login-bottom {
                margin-top: 28px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <section class="brand-panel">
        <div class="brand-content">

            <div class="brand-logo">
                <img
                    class="logo-icon"
                    src="{{ asset('images/logbook-logo.png') }}"
                    alt="Logo Logbook Studio"
                >
                <div>
                    <h2>Logbook Studio</h2>
                    <p>Broadcast Management System</p>
                </div>
            </div>

            <h1 class="brand-heading">
                Semua aktivitas studio,<br>
                <span>tercatat lebih mudah.</span>
            </h1>

            <p class="brand-description">
                Kelola aktivitas studio, dokumentasi, dan laporan
                operasional dalam satu sistem yang terintegrasi.
            </p>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">▤</div>
                    <div>
                        <h3>Pencatatan Kegiatan</h3>
                        <p>Catat aktivitas dan operasional studio dengan mudah.</p>
                    </div>
                </div>

                <div class="feature">
                    <div class="feature-icon">▣</div>
                    <div>
                        <h3>Monitoring Studio</h3>
                        <p>Kelola catatan Studio Berita, Penyiaran, dan MCR.</p>
                    </div>
                </div>

                <div class="feature">
                    <div class="feature-icon">▥</div>
                    <div>
                        <h3>Laporan Operasional</h3>
                        <p>Susun catatan kegiatan secara terstruktur.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="brand-footer">
            © {{ date('Y') }} Logbook Studio · Sistem Informasi Operasional
        </div>
    </section>

    <section class="form-panel">
        <div class="login-card">

            <div class="mobile-logo">
                <img
                    class="logo-icon"
                    src="{{ asset('images/logbook-logo.png') }}"
                    alt="Logo Logbook Studio"
                >
                <div>
                    <h2>Logbook Studio</h2>
                    <p>Broadcast Management System</p>
                </div>
            </div>

            <svg class="tvri-logo" viewBox="0 0 220 130" role="img" aria-labelledby="tvriTitle">
                <title id="tvriTitle">Logo TVRI</title>
                <circle cx="157" cy="51" r="43" fill="#123f8c"/>
                <text x="17" y="69"
                      font-family="Arial, Helvetica, sans-serif"
                      font-size="61" font-weight="800"
                      letter-spacing="-5" fill="#123f8c">TV</text>
                <text x="119" y="69"
                      font-family="Arial, Helvetica, sans-serif"
                      font-size="57" font-weight="800"
                      letter-spacing="-4" fill="#ffffff">RI</text>
                <path d="M66 91 C83 121, 171 126, 204 81"
                      fill="none" stroke="#168bd2"
                      stroke-width="7" stroke-linecap="round"/>
            </svg>

            <h1 class="login-heading">Selamat Datang!</h1>
            <p class="login-subtitle">
                Silakan masuk menggunakan akun Anda untuk melanjutkan.
            </p>

            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>

                    <div class="input-wrap">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Masukkan email Anda"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required
                            autofocus
                        >
                        <span class="input-icon">✉</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="password-input"
                            placeholder="Masukkan password Anda"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                        >
                            Lihat
                        </button>
                    </div>
                </div>

                <div class="login-options">
                    <label class="remember-option">
                        <input type="checkbox" name="remember" value="1">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="login-button">
                    Masuk ke Dashboard <span>→</span>
                </button>
            </form>

            <div class="login-note">
                Akses khusus petugas dan administrator
            </div>

            <div class="login-bottom">
                Pastikan Anda menggunakan akun yang terdaftar.<br>
                Jika mengalami kendala, hubungi administrator.
            </div>

        </div>
    </section>

</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';

        passwordInput.type = isHidden ? 'text' : 'password';
        togglePassword.textContent = isHidden ? 'Sembunyi' : 'Lihat';

        togglePassword.setAttribute(
            'aria-label',
            isHidden ? 'Sembunyikan password' : 'Tampilkan password'
        );
    });
</script>

</body>
</html>