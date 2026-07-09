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
<body class="h-screen w-screen overflow-hidden bg-slate-950">
    <!-- PDF Viewer Frame (Full Screen) -->
    <iframe src="{{ $streamUrl }}" class="w-full h-full border-none" allow="fullscreen"></iframe>

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

        // Handle page close events on mobile/desktop
        window.addEventListener('beforeunload', sendCloseBeacon);
        window.addEventListener('unload', sendCloseBeacon);
    </script>
</body>
</html>
