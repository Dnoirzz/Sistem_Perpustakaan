@php
    $selectedRole = old('role_name', \App\Models\User::ROLE_MAHASISWA);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - SIPUS PSDKU POLNEP</title>
    
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
    </style>
</head>
<body>
    <div class="register-layout">
        <aside class="visual-pane" aria-hidden="true">
            <div class="visual-box"></div>
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
                <h1>Sign Up</h1>
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
                        <label for="name">Nama Lengkap</label>
                        <input id="name" type="text" name="name" class="field-input" value="{{ old('name') }}" placeholder="Nama lengkap" required>
                    </div>

                    <div class="field-group">
                        <label for="prodi_id">Program Studi</label>
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
                        <label for="nim">NIM</label>
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
                        <label for="semester">Semester</label>
                        <select id="semester" name="semester" data-required-for-mahasiswa="true">
                            <option value="" disabled selected>Pilih Semester</option>
                            @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" @selected(old('semester') == $i)>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="field-group dosen-only" data-dosen-field>
                        <label for="nip">NIP</label>
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
                        <label for="no_hp">No HP / WhatsApp</label>
                        <input id="no_hp" type="text" name="no_hp" class="field-input" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" inputmode="numeric" pattern="[0-9]{1,25}" maxlength="25" oninput="this.value=this.value.replace(/[^0-9]/g, '')" title="No HP hanya boleh berisi angka." required>
                    </div>

                    <div class="field-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" class="field-input" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>

                    <div class="field-group">
                        <label for="password">Password</label>
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
                        <label for="password_confirmation">Konfirmasi Password</label>
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
                    Sudah memiliki akun? <a class="signin-link" href="{{ route('login') }}">Log In</a>
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

        if (passwordInput) {
            updatePasswordRules(passwordInput.value);
            passwordInput.addEventListener('input', function () {
                updatePasswordRules(passwordInput.value);
            });
        }

        bindPasswordToggle(passwordInput, passwordToggle, 'Tampilkan password', 'Sembunyikan password');
        bindPasswordToggle(passwordConfirmationInput, passwordConfirmationToggle, 'Tampilkan konfirmasi password', 'Sembunyikan konfirmasi password');
    </script>
</body>
</html>
