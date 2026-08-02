<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Verifikasi Anggota Baru - SIPUS PSDKU POLNEP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#131b2e",
                        "surface": "#faf8ff",
                        "outline": "#777587",
                        "on-tertiary-fixed": "#40000d",
                        "secondary-fixed": "#6ffbbe",
                        "secondary-fixed-dim": "#4edea3",
                        "on-tertiary": "#ffffff",
                        "outline-variant": "#c7c4d8",
                        "surface-container-highest": "#dae2fd",
                        "surface-container-high": "#e2e7ff",
                        "on-error": "#ffffff",
                        "background": "#faf8ff",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-secondary-fixed": "#002113",
                        "tertiary-fixed-dim": "#ffb2b7",
                        "surface-variant": "#dae2fd",
                        "surface-container": "#eaedff",
                        "secondary-container": "#6cf8bb",
                        "secondary": "#006c49",
                        "tertiary": "#95002b",
                        "tertiary-fixed": "#ffdadb",
                        "primary": "#00a5c0",
                        "on-primary-container": "#dad7ff",
                        "surface-dim": "#d2d9f4",
                        "tertiary-container": "#bf0f3c",
                        "on-tertiary-fixed-variant": "#92002a",
                        "error-container": "#ffdad6",
                        "inverse-on-surface": "#eef0ff",
                        "on-secondary-fixed-variant": "#005236",
                        "surface-bright": "#faf8ff",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#131b2e",
                        "surface-tint": "#00a5c0",
                        "on-primary-fixed-variant": "#007b91",
                        "inverse-surface": "#283044",
                        "surface-container-low": "#f2f3ff",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#464555",
                        "primary-fixed": "#e2dfff",
                        "on-secondary-container": "#00714d",
                        "primary-container": "#00a5c0",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-primary-fixed": "#0f0069",
                        "on-tertiary-container": "#ffd0d2",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#c3c0ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline-md": ["Outfit"],
                        "label-md": ["Inter"],
                        "display-lg": ["Outfit"],
                        "caption": ["Inter"],
                        "headline-lg": ["Outfit"],
                        "headline-lg-mobile": ["Outfit"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f8faff;
            color: #131b2e;
        }
        .sidebar-active {
            background-color: #00a5c0;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2);
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen flex">
    @include('petugas.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Verifikasi Anggota Baru',
            'subtitle' => 'Tinjau identitas Kartu Tanda Mahasiswa (KTM) dan setujui atau tolak pendaftaran mandiri.'
        ])

        <!-- Alert Notifications -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-3xl flex items-center gap-3 shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-3xl flex items-center gap-3 shadow-sm">
                <span class="material-symbols-outlined text-amber-600">warning</span>
                <span class="text-sm font-semibold">{{ session('warning') }}</span>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-3xl p-6 border border-outline-variant/20 shadow-sm mb-8">
            <form action="{{ route('petugas.verifikasi.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="relative flex-1 w-full">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari berdasarkan nama, email, NIM, NIP, atau no HP..." 
                           class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary">
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <button type="submit" class="px-6 py-3 bg-primary text-white font-bold text-sm rounded-2xl shadow-md hover:bg-primary/90 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('petugas.verifikasi.index') }}" class="px-4 py-3 bg-slate-100 text-slate-600 font-semibold text-sm rounded-2xl hover:bg-slate-200 transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="mb-4 p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-amber-600 text-2xl">how_to_reg</span>
                <div>
                    <h2 class="font-bold text-sm text-slate-800">Antrian Pendaftaran Pending</h2>
                    <p class="text-xs text-slate-600">Periksa Kartu Tanda Mahasiswa (KTM) dan setujui/tolak pendaftaran.</p>
                </div>
            </div>
            <span class="px-3 py-1 bg-amber-100 text-amber-900 border border-amber-300 text-xs font-extrabold rounded-full whitespace-nowrap">
                {{ $pendingMembers->total() }} Pendaftaran Menunggu
            </span>
        </div>

        <x-table :pagination="$pendingMembers->hasPages() ? $pendingMembers->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Calon Anggota</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Peran & Prodi</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Identitas (NIM/NIP)</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Bukti Identitas</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap w-48">Aksi Verifikasi</th>
            </x-slot>

            @forelse($pendingMembers as $user)
                <tr class="even:bg-slate-50/40 hover:bg-amber-50/30 transition-colors duration-150 group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-800 font-bold flex items-center justify-center text-xs uppercase border border-sky-200 shadow-xs">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 text-sm group-hover:text-sky-800 transition-colors">{{ $user->name }}</span>
                                <span class="text-xs text-slate-500 font-medium">{{ $user->email }} • {{ $user->no_hp }}</span>
                            </div>
                        </div>
                    </td>

                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="space-y-1">
                            <span class="inline-block px-3 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $user->isMahasiswa() ? 'bg-sky-100 text-sky-800 border border-sky-200' : 'bg-purple-100 text-purple-800 border border-purple-200' }}">
                                {{ $user->role->role_name ?? '-' }}
                            </span>
                            <p class="text-xs text-slate-600 font-semibold">
                                @if($user->isMahasiswa())
                                    {{ $user->mahasiswa->prodi->nama_prodi ?? '-' }} (Sem {{ $user->mahasiswa->semester ?? '-' }})
                                @elseif($user->isDosen())
                                    {{ $user->dosen->prodi->nama_prodi ?? '-' }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </td>

                    <td class="px-8 py-5 font-mono text-xs font-bold text-slate-800 whitespace-nowrap">
                        @if($user->isMahasiswa())
                            NIM: {{ $user->mahasiswa->nim ?? '-' }}
                        @elseif($user->isDosen())
                            NIP: {{ $user->dosen->nip ?? '-' }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="px-8 py-5 whitespace-nowrap">
                        @if(!empty($user->foto_ktm))
                            <button type="button" 
                                    onclick="previewKtm('{{ route('petugas.verifikasi.ktm', $user->user_id) }}', '{{ e($user->name) }}')"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all border border-slate-200">
                                <span class="material-symbols-outlined text-[16px]">badge</span>
                                Lihat KTM
                            </button>
                        @else
                            <span class="text-xs text-slate-400 italic">Tanpa Berkas</span>
                        @endif
                    </td>

                    <td class="px-8 py-5 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <form action="{{ route('petugas.verifikasi.approve', $user->user_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui akun {{ e($user->name) }}?')">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1 active:scale-95">
                                    <span class="material-symbols-outlined text-[16px]">check</span>
                                    Setujui
                                </button>
                            </form>

                            <button type="button" 
                                    onclick="openRejectModal('{{ $user->user_id }}', '{{ e($user->name) }}')"
                                    class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold rounded-xl transition-all flex items-center gap-1 active:scale-95">
                                <span class="material-symbols-outlined text-[16px]">close</span>
                                Tolak
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-14 text-center">
                        <span class="material-symbols-outlined text-slate-300 text-6xl mb-2">verified</span>
                        <p class="font-bold text-slate-700 text-sm">Tidak Ada Antrian Verifikasi</p>
                        <p class="text-xs text-slate-400">Seluruh pendaftaran anggota baru telah terverifikasi atau tidak ada data yang cocok dengan pencarian Anda.</p>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </main>

    <!-- MODAL PREVIEW KTM -->
    <div id="modal-ktm" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl space-y-4 my-auto relative">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-2xl">badge</span>
                    <h3 class="font-bold text-base text-slate-800" id="ktm-modal-title">Pratinjau Foto KTM</h3>
                </div>
                <button type="button" onclick="closeKtmModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1 transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="bg-slate-100 rounded-2xl overflow-hidden min-h-[250px] flex items-center justify-center border border-slate-200">
                <img id="ktm-img" src="" alt="Foto KTM" class="max-h-[70vh] w-auto object-contain rounded-xl shadow-sm" />
            </div>
            <div class="flex justify-end pt-2">
                <button type="button" onclick="closeKtmModal()" class="px-5 py-2.5 bg-slate-800 text-white font-bold text-xs rounded-xl hover:bg-slate-900 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL ALASAN PENOLAKAN -->
    <div id="modal-reject" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 my-auto relative">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2 text-rose-600">
                    <span class="material-symbols-outlined text-2xl">cancel</span>
                    <h3 class="font-bold text-base text-slate-800">Tolak Pendaftaran</h3>
                </div>
                <button type="button" onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1 transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <form id="reject-form" method="POST" action="" class="space-y-4">
                @csrf
                <p class="text-xs text-slate-600 leading-relaxed">
                    Menolak pendaftaran calon anggota <strong id="reject-user-name" class="text-slate-800"></strong>. 
                    Pesan alasan penolakan ini akan dikirimkan ke email pendaftar, dan data pendaftaran akan dibersihkan agar calon anggota dapat mendaftar ulang.
                </p>

                <div class="space-y-1.5">
                    <label for="reject-reason" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Alasan Penolakan <span class="text-rose-500">*</span></label>
                    <textarea id="reject-reason" 
                              name="reason" 
                              rows="3" 
                              required 
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500 resize-none" 
                              placeholder="Misal: Foto KTM yang diunggah kurang jelas/buram. Silakan daftar kembali dengan foto KTM yang valid."></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                        Tolak & Kirim Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewKtm(url, name) {
            document.getElementById('ktm-modal-title').textContent = 'Foto KTM: ' + name;
            document.getElementById('ktm-img').src = url;
            document.getElementById('modal-ktm').classList.remove('hidden');
        }

        function closeKtmModal() {
            document.getElementById('modal-ktm').classList.add('hidden');
            document.getElementById('ktm-img').src = '';
        }

        function openRejectModal(userId, name) {
            const form = document.getElementById('reject-form');
            form.action = "{{ url('petugas/verifikasi') }}/" + userId + "/reject";
            document.getElementById('reject-user-name').textContent = name;
            document.getElementById('reject-reason').value = '';
            document.getElementById('modal-reject').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('modal-reject').classList.add('hidden');
        }
    </script>
</body>
</html>
