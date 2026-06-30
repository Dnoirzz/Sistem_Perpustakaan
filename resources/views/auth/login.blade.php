<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - SIPUS PSDKU POLNEP</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --left-bg: #f9f9ff;
            --right-bg: #00a5c0; /* POLNEP Brand Turquoise */
            --text-main: #141b2b; /* POLNEP On-Surface */
            --text-subtle: #707882; /* POLNEP Outline */
            --field-bg: #ffffff;
            --field-border: #c0c7d2; /* POLNEP Outline Variant */
            --action: #00a5c0; /* POLNEP Brand Turquoise */
            --action-hover: #007b91; /* POLNEP Brand Dark Turquoise */
            --link: #00a5c0;
            --error-bg: #fde8e8;
            --error-border: #f8caca;
            --error-text: #9c2c2c;
            --success-bg: #e7f8ee;
            --success-border: #bce8cf;
            --success-text: #236d43;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Outfit", sans-serif;
            color: var(--text-main);
            background: var(--left-bg);
        }

        .login-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1.15fr;
        }

        .login-pane {
            background: var(--left-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2.5rem 1.5rem;
        }

        .form-shell {
            width: 100%;
            max-width: 420px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-subtle);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--action);
        }

        .back-link svg {
            transition: transform 0.2s;
        }

        .back-link:hover svg {
            transform: translateX(-4px);
        }

        .form-shell h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--action);
            letter-spacing: -0.5px;
        }

        .form-shell p.subtitle {
            margin: 0.5rem 0 2rem;
            font-size: 0.9rem;
            color: var(--text-subtle);
        }

        .status-box {
            margin-bottom: 1.5rem;
            border-radius: 8px;
            padding: 0.85rem 1rem;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .status-box ul {
            margin: 0;
            padding-left: 1.2rem;
        }

        .status-box.success {
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
        }

        .status-box.error {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: var(--error-text);
        }

        .field-group {
            margin-bottom: 1.2rem;
        }

        .field-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.45rem;
            color: var(--text-main);
        }

        .field-input,
        .field-password-wrap input {
            width: 100%;
            border: 1.5px solid var(--field-border);
            background: var(--field-bg);
            border-radius: 10px;
            padding: 0.8rem 1rem;
            font-size: 0.88rem;
            font-family: inherit;
            color: var(--text-main);
            outline: none;
            transition: all 0.2s;
        }

        .field-input:focus,
        .field-password-wrap input:focus {
            border-color: var(--action);
            box-shadow: 0 0 0 3px rgba(0, 96, 154, 0.15);
        }

        .field-input::placeholder,
        .field-password-wrap input::placeholder {
            color: #96a0ad;
        }

        .field-password-wrap {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.5rem;
            height: 1.5rem;
            border: 0;
            background: transparent;
            color: #6f7884;
            cursor: pointer;
            padding: 0;
        }

        .toggle-password .eye-slash {
            display: none;
        }

        .toggle-password.is-visible .eye-slash {
            display: block;
        }

        .helper-row {
            margin-top: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-main);
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 0.95rem;
            height: 0.95rem;
            margin: 0;
            border-radius: 4px;
            border: 1.5px solid var(--field-border);
            accent-color: var(--action);
        }

        .helper-link,
        .signup-link {
            color: var(--link);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .helper-link:hover,
        .signup-link:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            border: 0;
            background: var(--action);
            color: #fff;
            font-weight: 700;
            border-radius: 10px;
            letter-spacing: 0.2px;
            padding: 0.85rem 1rem;
            font-size: 0.9rem;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 96, 154, 0.2);
            transition: all 0.2s;
        }

        .login-button:hover {
            background: var(--action-hover);
            transform: translateY(-1px);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .signup-note {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-subtle);
        }

        .visual-pane {
            background: var(--right-bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .visual-pane::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.15), transparent);
            pointer-events: none;
        }

        .visual-box {
            width: min(320px, 75%);
            aspect-ratio: 1 / 1;
            border: 12px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            position: relative;
            margin-bottom: 2rem;
        }

        .visual-box::before,
        .visual-box::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 70%;
            height: 12px;
            background: rgba(255, 255, 255, 0.2);
            transform-origin: center;
        }

        .visual-box::before {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        .visual-box::after {
            transform: translate(-50%, -50%) rotate(-45deg);
        }

        .visual-text h2 {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 0 0 0.5rem;
        }

        .visual-text p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 320px;
            margin: 0 auto;
            line-relaxed: true;
        }

        @media (max-width: 980px) {
            .login-layout {
                grid-template-columns: 1fr;
            }

            .visual-pane {
                display: none;
            }

            .login-pane {
                padding: 3rem 1.5rem;
            }

            .form-shell h1 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-layout">
        <aside class="visual-pane" aria-hidden="true">
            <div class="visual-box"></div>
            <div class="visual-text">
                <h2>SIPUS PSDKU POLNEP</h2>
                <p>Akses pustaka digital dan layanan akademik Sukamara dalam satu platform terpadu.</p>
            </div>
        </aside>

        <section class="login-pane">
            <div class="form-shell">
                <a href="{{ url('/') }}" class="back-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Kembali ke Beranda
                </a>
                <h1>Log In</h1>
                <p class="subtitle">Masuk untuk mengakses layanan perpustakaan digital.</p>

                @if (session('status'))
                    <div class="status-box success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="status-box error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="field-group">
                        <label for="email">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="field-input"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>

                    <div class="field-group">
                        <label for="password">Password</label>
                        <div class="field-password-wrap">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Masukkan password"
                                required
                            >
                            <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M2 12c2.2-4 5.5-6 10-6s7.8 2 10 6c-2.2 4-5.5 6-10 6s-7.8-2-10-6Z" stroke="currentColor" stroke-width="1.7"/>
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.7"/>
                                    <path class="eye-slash" d="M4 4l16 16" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="helper-row">
                        <label class="remember-label" for="remember">
                            <input
                                id="remember"
                                type="checkbox"
                                name="remember"
                                value="1"
                                @checked(old('remember'))
                            >
                            Remember me
                        </label>
                        @if (Route::has('password.request'))
                            <a class="helper-link" href="{{ route('password.request') }}">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="login-button">Log In</button>
                </form>

                <p class="signup-note">
                    Belum memiliki akun? <a class="signup-link" href="{{ route('register') }}">Daftar Sekarang</a>
                </p>
            </div>
        </section>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('togglePassword');

        if (passwordInput && passwordToggle) {
            passwordToggle.classList.toggle('is-visible', passwordInput.type === 'text');

            passwordToggle.addEventListener('click', function () {
                const isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                passwordToggle.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
                passwordToggle.classList.toggle('is-visible', isHidden);
            });
        }
    </script>
</body>
</html>
