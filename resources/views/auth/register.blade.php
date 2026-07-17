@php
    $selectedRole = old('role_name', \App\Models\User::ROLE_MAHASISWA);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIPUS PSDKU POLNEP</title>
    
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

        .register-layout {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1.15fr;
        }

        .register-pane {
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
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--action);
            letter-spacing: -0.5px;
        }

        .subtext {
            margin: 0.5rem 0 1.5rem;
            font-size: 0.9rem;
            color: var(--text-subtle);
        }

        .status-box {
            margin-bottom: 1.2rem;
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

        .role-switch {
            margin-bottom: 1.2rem;
        }

        .role-switch-label {
            display: block;
            margin-bottom: 0.45rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .role-switch-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .role-button {
            border: 1.5px solid var(--field-border);
            background: var(--field-bg);
            color: var(--text-subtle);
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.65rem 0.5rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .role-button.is-active {
            background: #e9edff;
            border-color: var(--action);
            color: var(--action);
        }

        .field-group {
            margin-bottom: 1rem;
        }

        .field-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 0.45rem;
            color: var(--text-main);
        }

        .required-asterisk {
            color: #ea4335;
            margin-left: 3px;
            font-size: 0.85rem;
        }

        .field-input,
        .field-password-wrap input,
        .field-group select {
            width: 100%;
            border: 1.5px solid var(--field-border);
            background: var(--field-bg);
            border-radius: 10px;
            padding: 0.75rem 0.9rem;
            font-size: 0.86rem;
            font-family: inherit;
            color: var(--text-main);
            outline: none;
            transition: all 0.2s;
        }

        .field-input:focus,
        .field-password-wrap input:focus,
        .field-group select:focus {
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

        .password-rules {
            list-style: none;
            margin: 0.65rem 0 0;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.45rem 1.2rem;
        }

        .password-rule {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.72rem;
            color: #69717d;
        }

        .password-rule-dot {
            width: 0.85rem;
            height: 0.85rem;
            border: 2px solid #7c8696;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
            background: transparent;
        }

        .password-rule.is-valid {
            color: #2658bb;
        }

        .password-rule.is-valid .password-rule-dot {
            border-color: #2658bb;
            background: radial-gradient(circle, #2658bb 32%, transparent 36%);
        }

        .signup-button {
            width: 100%;
            margin-top: 1rem;
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

        .signup-button:hover {
            background: var(--action-hover);
            transform: translateY(-1px);
        }

        .signup-button:active {
            transform: translateY(0);
        }

        .signin-note {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-subtle);
        }

        .signin-link {
            color: var(--link);
            text-decoration: none;
            font-weight: 600;
        }

        .signin-link:hover {
            text-decoration: underline;
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
            line-height: 1.5;
        }

        .hidden {
            display: none;
        }

        @media (max-width: 980px) {
            .register-layout {
                grid-template-columns: 1fr;
            }

            .visual-pane {
                display: none;
            }

            .register-pane {
                padding: 3rem 1.5rem;
            }

            .form-shell h1 {
                font-size: 2rem;
            }
        }

        @media (min-width: 981px) {
            .register-layout {
                height: 100vh;
                overflow: hidden;
            }

            .register-pane {
                height: 100vh;
                overflow-y: auto;
                align-items: flex-start;
                padding: 4rem 1.5rem;
            }

            /* Sleek custom scrollbar */
            .register-pane::-webkit-scrollbar {
                width: 6px;
            }
            .register-pane::-webkit-scrollbar-track {
                background: transparent;
            }
            .register-pane::-webkit-scrollbar-thumb {
                background: #c0c7d2;
                border-radius: 10px;
            }
            .register-pane::-webkit-scrollbar-thumb:hover {
                background: #96a0ad;
            }
        }

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(19, 27, 46, 0.6);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            animation: fadeIn 0.3s forwards ease;
        }

        /* Modal Container */
        .modal-card {
            background: #ffffff;
            border-radius: 24px;
            width: min(440px, 90%);
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transform: scale(0.9);
            opacity: 0;
            animation: slideIn 0.35s 0.1s forwards cubic-bezier(0.34, 1.56, 0.64, 1);
            font-family: "Outfit", sans-serif;
        }

        /* Success Icon */
        .modal-icon-wrap {
            width: 80px;
            height: 80px;
            background: #e6f7f8;
            color: #00a5c0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .modal-icon-wrap svg {
            width: 42px;
            height: 42px;
        }

        /* Text Styles */
        .modal-card h2 {
            margin: 0 0 0.75rem;
            font-size: 1.6rem;
            font-weight: 800;
            color: #141b2b;
        }

        .modal-card p {
            margin: 0 0 2rem;
            font-size: 0.95rem;
            color: #707882;
            line-height: 1.6;
        }

        /* Modal Button */
        .modal-button {
            width: 100%;
            border: 0;
            background: #00a5c0;
            color: #ffffff;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.9rem 1.5rem;
            font-size: 0.95rem;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(0, 165, 192, 0.25);
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
        }

        .modal-button:hover {
            background: #007b91;
            transform: translateY(-1px);
        }

        .modal-button:active {
            transform: translateY(0);
        }

        /* Animations */
        @keyframes fadeIn {
            to { opacity: 1; }
        }

        @keyframes slideIn {
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    @if (session('registration_success'))
        <div class="modal-overlay" id="successModal">
            <div class="modal-card">
                <div class="modal-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h2>Registrasi Berhasil!</h2>
                <p>Akun anggota perpustakaan digital Anda telah berhasil dibuat. Silakan masuk untuk mengakses layanan.</p>
                <a href="{{ route('login') }}" class="modal-button">Ke Halaman Login</a>
            </div>
        </div>
    @endif
    <div class="register-layout">
        <aside class="visual-pane" aria-hidden="true">
            <div style="width: min(220px, 55%); aspect-ratio: 1/1; margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: center; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1.5px solid rgba(255, 255, 255, 0.25); border-radius: 24px; padding: 2rem; box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.1), 0 10px 25px rgba(0, 0, 0, 0.05);">
                <img src="{{ asset('img/logo_polnep.webp') }}" style="width: 100%; height: 100%; object-fit: contain;" alt="Logo POLNEP">
            </div>
            <div class="visual-text">
                <h2>SIPUS PSDKU POLNEP</h2>
                <p>Akses pustaka digital dan layanan akademik Sukamara dalam satu platform terpadu.</p>
            </div>
        </aside>

        <section class="register-pane">
            <div class="form-shell">
                <a href="{{ url('/') }}" class="back-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Kembali ke Beranda
                </a>
                <h1>Daftar</h1>
                <p class="subtext">Buat akun anggota perpustakaan digital.</p>

                @if (session('success'))
                    <div class="status-box success">{{ session('success') }}</div>
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

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <input type="hidden" name="role_name" id="roleNameInput" value="{{ $selectedRole }}">

                    <div class="role-switch">
                        <label class="role-switch-label">Daftar sebagai</label>
                        <div class="role-switch-buttons">
                            <button
                                type="button"
                                class="role-button @if ($selectedRole === \App\Models\User::ROLE_MAHASISWA) is-active @endif"
                                data-role-button
                                data-role-value="{{ \App\Models\User::ROLE_MAHASISWA }}"
                            >
                                Mahasiswa
                            </button>
                            <button
                                type="button"
                                class="role-button @if ($selectedRole === \App\Models\User::ROLE_DOSEN) is-active @endif"
                                data-role-button
                                data-role-value="{{ \App\Models\User::ROLE_DOSEN }}"
                            >
                                Dosen
                            </button>
                        </div>
                    </div>

                    <div class="field-group">
                        <label for="name">Nama Lengkap<span class="required-asterisk">*</span></label>
                        <input id="name" type="text" name="name" class="field-input" value="{{ old('name') }}" placeholder="Nama lengkap" required>
                    </div>

                    <div class="field-group">
                        <label for="prodi_id">Program Studi<span class="required-asterisk">*</span></label>
                        <select id="prodi_id" name="prodi_id" required>
                            <option value="" disabled selected>Pilih Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->prodi_id }}" @selected(old('prodi_id') == $prodi->prodi_id)>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group mahasiswa-only" data-mahasiswa-field>
                        <label for="nim">NIM<span class="required-asterisk">*</span></label>
                        <input
                            id="nim"
                            type="text"
                            name="nim"
                            class="field-input"
                            value="{{ old('nim') }}"
                            placeholder="Contoh: 3202210001"
                            inputmode="numeric"
                            pattern="[0-9]{10}"
                            maxlength="10"
                            minlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g, '')"
                            title="NIM harus 10 angka."
                            data-required-for-mahasiswa="true"
                        >
                    </div>

                    <div class="field-group mahasiswa-only" data-mahasiswa-field>
                        <label for="semester">Semester<span class="required-asterisk">*</span></label>
                        <select id="semester" name="semester" data-required-for-mahasiswa="true">
                            <option value="" disabled selected>Pilih Semester</option>
                            @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" @selected(old('semester') == $i)>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="field-group dosen-only" data-dosen-field>
                        <label for="nip">NIP<span class="required-asterisk">*</span></label>
                        <input
                            id="nip"
                            type="text"
                            name="nip"
                            class="field-input"
                            value="{{ old('nip') }}"
                            placeholder="Contoh: 198603012020121001"
                            inputmode="numeric"
                            pattern="[0-9]{18}"
                            maxlength="18"
                            minlength="18"
                            oninput="this.value=this.value.replace(/[^0-9]/g, '')"
                            title="NIP harus 18 angka."
                            data-required-for-dosen="true"
                        >
                    </div>

                    <div class="field-group">
                        <label for="no_hp">No HP / WhatsApp<span class="required-asterisk">*</span></label>
                        <input id="no_hp" type="text" name="no_hp" class="field-input" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" inputmode="numeric" pattern="[0-9]{1,25}" maxlength="25" oninput="this.value=this.value.replace(/[^0-9]/g, '')" title="No HP hanya boleh berisi angka." required>
                    </div>

                    <div class="field-group">
                        <label for="email">Email<span class="required-asterisk">*</span></label>
                        <input id="email" type="email" name="email" class="field-input" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>

                    <div class="field-group">
                        <label for="password">Password<span class="required-asterisk">*</span></label>
                        <div class="field-password-wrap">
                            <input id="password" type="password" name="password" placeholder="Buat password" required>
                            <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M2 12c2.2-4 5.5-6 10-6s7.8 2 10 6c-2.2 4-5.5 6-10 6s-7.8-2-10-6Z" stroke="currentColor" stroke-width="1.7"/>
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.7"/>
                                    <path class="eye-slash" d="M4 4l16 16" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                        <ul class="password-rules" id="passwordRules">
                            <li class="password-rule" data-password-rule="min">
                                <span class="password-rule-dot" aria-hidden="true"></span>
                                Min. 8 Karakter
                            </li>
                            <li class="password-rule" data-password-rule="lower">
                                <span class="password-rule-dot" aria-hidden="true"></span>
                                Huruf kecil
                            </li>
                            <li class="password-rule" data-password-rule="upper">
                                <span class="password-rule-dot" aria-hidden="true"></span>
                                Huruf kapital
                            </li>
                            <li class="password-rule" data-password-rule="number">
                                <span class="password-rule-dot" aria-hidden="true"></span>
                                Angka
                            </li>
                        </ul>
                    </div>

                    <div class="field-group">
                        <label for="password_confirmation">Konfirmasi Password<span class="required-asterisk">*</span></label>
                        <div class="field-password-wrap">
                            <input id="password_confirmation" type="password" name="password_confirmation" class="field-input" placeholder="Ulangi password" required>
                            <button type="button" class="toggle-password" id="togglePasswordConfirmation" aria-label="Tampilkan konfirmasi password">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M2 12c2.2-4 5.5-6 10-6s7.8 2 10 6c-2.2 4-5.5 6-10 6s-7.8-2-10-6Z" stroke="currentColor" stroke-width="1.7"/>
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.7"/>
                                    <path class="eye-slash" d="M4 4l16 16" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="signup-button">Daftar</button>
                </form>

                <p class="signin-note">
                    Sudah memiliki akun? <a class="signin-link" href="{{ route('login') }}">Masuk</a>
                </p>
            </div>
        </section>
    </div>

    <script>
        const roleButtons = document.querySelectorAll('[data-role-button]');
        const roleNameInput = document.getElementById('roleNameInput');
        const mahasiswaFieldGroups = document.querySelectorAll('[data-mahasiswa-field]');
        const mahasiswaRequiredFields = document.querySelectorAll('[data-required-for-mahasiswa="true"]');
        const dosenFieldGroups = document.querySelectorAll('[data-dosen-field]');
        const dosenRequiredFields = document.querySelectorAll('[data-required-for-dosen="true"]');

        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('togglePassword');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const passwordConfirmationToggle = document.getElementById('togglePasswordConfirmation');
        const passwordRuleMin = document.querySelector('[data-password-rule="min"]');
        const passwordRuleLower = document.querySelector('[data-password-rule="lower"]');
        const passwordRuleUpper = document.querySelector('[data-password-rule="upper"]');
        const passwordRuleNumber = document.querySelector('[data-password-rule="number"]');

        function applyRole(roleName) {
            roleNameInput.value = roleName;

            roleButtons.forEach((button) => {
                const isActive = button.dataset.roleValue === roleName;
                button.classList.toggle('is-active', isActive);
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });

            const isMahasiswa = roleName === '{{ \App\Models\User::ROLE_MAHASISWA }}';
            const isDosen = roleName === '{{ \App\Models\User::ROLE_DOSEN }}';

            mahasiswaFieldGroups.forEach((group) => {
                group.classList.toggle('hidden', !isMahasiswa);
            });

            mahasiswaRequiredFields.forEach((field) => {
                field.required = isMahasiswa;
                field.disabled = !isMahasiswa;
            });

            dosenFieldGroups.forEach((group) => {
                group.classList.toggle('hidden', !isDosen);
            });

            dosenRequiredFields.forEach((field) => {
                field.required = isDosen;
                field.disabled = !isDosen;
            });
        }

        roleButtons.forEach((button) => {
            button.addEventListener('click', () => applyRole(button.dataset.roleValue));
        });

        applyRole(roleNameInput.value || '{{ \App\Models\User::ROLE_MAHASISWA }}');

        function updatePasswordRules(passwordValue) {
            if (!passwordRuleMin || !passwordRuleLower || !passwordRuleUpper || !passwordRuleNumber) {
                return;
            }

            const checks = {
                min: passwordValue.length >= 8,
                lower: /[a-z]/.test(passwordValue),
                upper: /[A-Z]/.test(passwordValue),
                number: /[0-9]/.test(passwordValue),
            };

            passwordRuleMin.classList.toggle('is-valid', checks.min);
            passwordRuleLower.classList.toggle('is-valid', checks.lower);
            passwordRuleUpper.classList.toggle('is-valid', checks.upper);
            passwordRuleNumber.classList.toggle('is-valid', checks.number);
        }

        function bindPasswordToggle(inputEl, toggleEl, showLabel, hideLabel) {
            if (!inputEl || !toggleEl) {
                return;
            }

            toggleEl.classList.toggle('is-visible', inputEl.type === 'text');

            toggleEl.addEventListener('click', function () {
                const isHidden = inputEl.type === 'password';
                inputEl.type = isHidden ? 'text' : 'password';
                toggleEl.setAttribute('aria-label', isHidden ? hideLabel : showLabel);
                toggleEl.classList.toggle('is-visible', isHidden);
            });
        }

        function validatePasswordStrength() {
            const passwordValue = passwordInput.value;
            if (!passwordValue) {
                passwordInput.setCustomValidity("");
                return;
            }
            const hasMin = passwordValue.length >= 8;
            const hasLower = /[a-z]/.test(passwordValue);
            const hasUpper = /[A-Z]/.test(passwordValue);
            const hasNumber = /[0-9]/.test(passwordValue);

            if (!hasMin) {
                passwordInput.setCustomValidity("password minimal harus 8 karakter");
            } else if (!hasLower) {
                passwordInput.setCustomValidity("password harus mengandung setidaknya satu huruf kecil");
            } else if (!hasUpper) {
                passwordInput.setCustomValidity("password harus mengandung setidaknya satu huruf kapital");
            } else if (!hasNumber) {
                passwordInput.setCustomValidity("password harus mengandung setidaknya satu angka");
            } else {
                passwordInput.setCustomValidity("");
            }
        }

        function validatePasswordConfirmation() {
            if (!passwordConfirmationInput.value) {
                passwordConfirmationInput.setCustomValidity("");
                return;
            }
            if (passwordConfirmationInput.value !== passwordInput.value) {
                passwordConfirmationInput.setCustomValidity("password tidak cocok");
            } else {
                passwordConfirmationInput.setCustomValidity("");
            }
        }

        if (passwordInput) {
            updatePasswordRules(passwordInput.value);
            validatePasswordStrength();
            passwordInput.addEventListener('input', function () {
                updatePasswordRules(passwordInput.value);
                validatePasswordStrength();
                if (passwordConfirmationInput) {
                    validatePasswordConfirmation();
                }
            });
        }

        if (passwordConfirmationInput) {
            validatePasswordConfirmation();
            passwordConfirmationInput.addEventListener('input', function () {
                validatePasswordConfirmation();
            });
        }

        bindPasswordToggle(passwordInput, passwordToggle, 'Tampilkan password', 'Sembunyikan password');
        bindPasswordToggle(passwordConfirmationInput, passwordConfirmationToggle, 'Tampilkan konfirmasi password', 'Sembunyikan konfirmasi password');

        // Translate native validation error tooltips to Indonesian
        const formInputs = document.querySelectorAll('#registerForm input, #registerForm select');
        formInputs.forEach(input => {
            input.addEventListener('invalid', function (e) {
                // If it is already a custom error set by our code (like password strength or match), preserve it
                if (this.validity.customError) {
                    return;
                }

                // Clear any previous custom validity
                this.setCustomValidity('');

                if (this.id === 'email') {
                    if (this.validity.valueMissing) {
                        this.setCustomValidity('Email wajib diisi');
                    } else {
                        this.setCustomValidity('Format email tidak valid');
                    }
                    return;
                }

                if (this.validity.valueMissing) {
                    let fieldName = document.querySelector(`label[for="${this.id}"]`)?.textContent || 'kolom ini';
                    fieldName = fieldName.replace('*', '').split('/')[0].trim();
                    if (this.tagName === 'SELECT') {
                        this.setCustomValidity(`${fieldName} wajib dipilih`);
                    } else {
                        this.setCustomValidity(`${fieldName} wajib diisi`);
                    }
                } else if (this.validity.patternMismatch || this.validity.tooShort || this.validity.tooLong) {
                    if (this.id === 'nim') {
                        this.setCustomValidity('NIM harus berisi 10 digit angka');
                    } else if (this.id === 'nip') {
                        this.setCustomValidity('NIP harus berisi 18 digit angka');
                    } else if (this.id === 'no_hp') {
                        this.setCustomValidity('Nomor HP hanya boleh berisi angka');
                    } else {
                        this.setCustomValidity('Format input tidak valid');
                    }
                }
            });

            // Clear custom validity on interaction so browser can re-evaluate
            input.addEventListener('input', function () {
                if (this.id !== 'password' && this.id !== 'password_confirmation') {
                    this.setCustomValidity('');
                }
                if (this.id === 'email' && this.validity.typeMismatch) {
                    this.setCustomValidity('Format email tidak valid');
                }
            });
            input.addEventListener('change', function () {
                if (this.id !== 'password' && this.id !== 'password_confirmation') {
                    this.setCustomValidity('');
                }
                if (this.id === 'email' && this.validity.typeMismatch) {
                    this.setCustomValidity('Format email tidak valid');
                }
            });
        });
    </script>
</body>
</html>
