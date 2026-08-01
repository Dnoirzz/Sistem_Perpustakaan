<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Input Nomor HP / WA (Fase 6) -->
        <div>
            <x-input-label for="no_hp" :value="__('Nomor HP')" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user->no_hp)" placeholder="Contoh: 081234567890" />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
            <p class="mt-1 text-xs text-gray-500">Gunakan nomor HP aktif agar dapat menerima notifikasi melalui WhatsApp/Telegram.</p>
        </div>

        <!-- Input Telegram Chat ID -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="telegram_chat_id" :value="__('Telegram Chat ID')" />
                <button type="button" 
                        onclick="document.getElementById('modal-help-chatid').classList.remove('hidden')" 
                        class="text-xs text-sky-600 hover:text-sky-800 font-semibold inline-flex items-center gap-1 hover:underline">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Bingung cari Chat ID? Klik di sini
                </button>
            </div>
            
            <div class="mt-1 flex gap-2">
                <x-text-input id="telegram_chat_id" name="telegram_chat_id" type="text" class="block w-full font-mono" :value="old('telegram_chat_id', $user->telegram_chat_id)" placeholder="Contoh: 123456789" />
                @php 
                    $rawBot = \App\Models\AppSetting::get('telegram_bot_username', 'SipusPolnep_bot');
                    $cleanBot = ltrim(trim($rawBot), '@') ?: 'SipusPolnep_bot';
                @endphp
                <a href="https://t.me/{{ $cleanBot }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-xs rounded-xl inline-flex items-center gap-1.5 shrink-0 transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/></svg>
                    Buka Bot
                </a>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('telegram_chat_id')" />
            <p class="mt-1 text-xs text-gray-500">
                Isi dengan Telegram Chat ID Anda agar notifikasi dikirim otomatis via Telegram. 
                Jangan lupa klik tombol <strong>"Buka Bot"</strong> dan pilih <strong>START</strong> di Telegram.
            </p>
        </div>

        <!-- Detail Data Berdasarkan Role -->
        @if($user->isMahasiswa() && $user->mahasiswa)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase">Nomor Induk Mahasiswa (NIM)</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $user->mahasiswa->nim }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase">Program Studi</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $user->mahasiswa->prodi->nama_prodi ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase">Semester</span>
                    <span class="text-sm font-semibold text-slate-800">Semester {{ $user->mahasiswa->semester }}</span>
                </div>
            </div>
        @elseif($user->isDosen() && $user->dosen)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase">Nomor Induk Pegawai (NIP)</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $user->dosen->nip }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase">Program Studi</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $user->dosen->prodi->nama_prodi ?? '-' }}</span>
                </div>
            </div>
        @elseif($user->isPetugas() && $user->petugas)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase">Nomor Induk Pegawai (NIP)</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $user->petugas->nip }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-slate-500 uppercase">Jabatan / Staf</span>
                    <span class="text-sm font-semibold text-slate-800">{{ $user->petugas->jabatan ?? 'Staf Perpustakaan' }}</span>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-650 font-semibold text-emerald-600"
                >{{ __('Berhasil disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
