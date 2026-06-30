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
            <x-input-label for="no_hp" :value="__('Nomor HP / WhatsApp')" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user->no_hp)" placeholder="Contoh: 081234567890" />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
            <p class="mt-1 text-xs text-gray-500">Gunakan nomor HP aktif agar dapat menerima notifikasi WhatsApp otomatis.</p>
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
