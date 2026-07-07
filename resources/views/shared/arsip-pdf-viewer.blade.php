<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $archiveTitle }} - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;650&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }
        .header-font {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="h-screen flex flex-col overflow-hidden">
    <!-- Top Sleek Bar -->
    <header class="h-16 bg-slate-900 border-b border-slate-800 flex items-center justify-between px-6 z-10 shadow-lg">
        <div class="flex items-center gap-3 overflow-hidden mr-4">
            <span class="material-symbols-outlined text-primary text-[28px] text-sky-400 flex-shrink-0">menu_book</span>
            <div class="overflow-hidden">
                <h1 class="header-font font-bold text-sm text-slate-100 truncate tracking-wide leading-tight">{{ $archiveTitle }}</h1>
                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-400 uppercase tracking-widest mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Membaca Digital
                </span>
            </div>
        </div>
        <button onclick="window.close()" class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-300 hover:text-white bg-slate-800 hover:bg-rose-600/90 rounded-xl transition duration-200 border border-slate-700/50 hover:border-transparent shadow-sm flex-shrink-0">
            <span class="material-symbols-outlined text-[16px]">close</span>
            Tutup Tab
        </button>
    </header>

    <!-- PDF Viewer Frame -->
    <main class="flex-1 bg-slate-950 relative">
        <iframe src="{{ $streamUrl }}" class="absolute inset-0 w-full h-full border-none shadow-inner" allow="fullscreen"></iframe>
    </main>

    <!-- Close Log Beacon Tracker -->
    <script>
        const logId = {{ $logId }};
        const closeUrl = '{{ route("katalog-arsip.read-log.close", ["id" => $logId]) }}';

        let closed = false;

        function sendCloseBeacon() {
            if (closed) return;
            closed = true;

            // navigator.sendBeacon is highly reliable on beforeunload/unload events
            navigator.sendBeacon(closeUrl);
        }

        // Handle page close & hide events on mobile/desktop
        window.addEventListener('beforeunload', sendCloseBeacon);
        window.addEventListener('unload', sendCloseBeacon);
        window.addEventListener('pagehide', sendCloseBeacon);

        // Detect tab switching or locking screen on mobile
        window.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                sendCloseBeacon();
            }
        });
    </script>
</body>
</html>
