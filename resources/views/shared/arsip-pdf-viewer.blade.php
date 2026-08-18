<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $archiveTitle }} - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Inter:wght@400;500;650&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>
    <style>
        body {
            background-color: #525659;
            color: #f8fafc;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        .header-font {
            font-family: 'Outfit', sans-serif;
        }
        /* Custom Scrollbar matching classic PDF Viewer */
        #pdf-viewport::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        #pdf-viewport::-webkit-scrollbar-track {
            background: #525659;
        }
        #pdf-viewport::-webkit-scrollbar-thumb {
            background: #323639;
            border-radius: 5px;
            border: 2px solid #525659;
        }
        #pdf-viewport::-webkit-scrollbar-thumb:hover {
            background: #202124;
        }
        /* Hide number spinner */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class="h-screen w-screen overflow-hidden bg-[#525659] flex flex-col select-none">

    <!-- Top Navigation Toolbar (Classic PDF Viewer Style #323639) -->
    <header class="h-14 bg-[#323639] border-b border-[#202124] flex items-center justify-between px-4 z-40 shrink-0 shadow-md">
        <!-- Left: Back & Title -->
        <div class="flex items-center gap-3 min-w-0">
            <button onclick="handleClose()" title="Kembali / Tutup" class="flex items-center justify-center w-9 h-9 rounded-xl bg-[#202124] hover:bg-[#484c50] text-slate-200 hover:text-white transition-all border border-[#484c50]/50">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </button>
            <div class="min-w-0">
                <h1 class="text-sm font-bold text-slate-100 truncate header-font max-w-md md:max-w-lg" title="{{ $archiveTitle }}">
                    {{ $archiveTitle }}
                </h1>
                <p class="text-[11px] text-slate-400 font-medium flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Dokumen Terproteksi
                </p>
            </div>
        </div>

        <!-- Center: Pagination Controls -->
        <div class="flex items-center gap-1.5 bg-[#202124] p-1 rounded-xl border border-[#484c50]/50">
            <button id="prev-page" title="Halaman Sebelumnya" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-[#484c50] text-slate-300 hover:text-white disabled:opacity-30 disabled:hover:bg-transparent transition-all">
                <span class="material-symbols-outlined text-[20px]">navigate_before</span>
            </button>
            <div class="flex items-center gap-1 px-2 text-xs font-semibold text-slate-300">
                <input id="page-num" type="number" min="1" value="1" class="w-10 text-center bg-[#323639] border border-[#484c50] rounded-md py-0.5 text-xs text-white focus:outline-none focus:border-[#00a5c0] font-bold">
                <span class="text-slate-400">/</span>
                <span id="page-count" class="text-slate-300">--</span>
            </div>
            <button id="next-page" title="Halaman Selanjutnya" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-[#484c50] text-slate-300 hover:text-white disabled:opacity-30 disabled:hover:bg-transparent transition-all">
                <span class="material-symbols-outlined text-[20px]">navigate_next</span>
            </button>
        </div>

        <!-- Right: Zoom Controls -->
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-1 bg-[#202124] p-1 rounded-xl border border-[#484c50]/50">
                <button id="zoom-out" title="Perkecil" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-[#484c50] text-slate-300 hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[18px]">remove</span>
                </button>
                <span id="zoom-val" class="text-xs font-bold text-slate-200 px-2 min-w-[48px] text-center">100%</span>
                <button id="zoom-in" title="Perbesar" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-[#484c50] text-slate-300 hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                </button>
                <div class="h-4 w-px bg-[#484c50] mx-1"></div>
                <button id="zoom-fit" title="Sesuaikan Lebar" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-[#484c50] text-slate-300 hover:text-white transition-all">
                    <span class="material-symbols-outlined text-[18px]">fit_screen</span>
                </button>
            </div>
        </div>
    </header>

    <!-- PDF Main Viewport Container (Classic PDF Viewer Background #525659) -->
    <main id="pdf-viewport" class="flex-1 overflow-auto bg-[#525659] flex flex-col items-center py-8 px-4 gap-6 relative">
        <!-- Loading State Indicator -->
        <div id="loading-spinner" class="flex flex-col items-center justify-center my-auto py-20">
            <div class="w-12 h-12 border-4 border-cyan-400/30 border-t-cyan-400 rounded-full animate-spin mb-4"></div>
            <p class="text-slate-200 font-semibold text-sm">Memuat Dokumen Terproteksi...</p>
            <p class="text-slate-400 text-xs mt-1">Menyiapkan halaman naskah karya ilmiah</p>
        </div>

        <!-- Rendered Pages Container -->
        <div id="pages-container" class="flex flex-col items-center gap-6 w-full max-w-5xl"></div>
    </main>

    <!-- Security Blur Overlay (Blur on Focus Loss) -->
    <div id="security-blur-overlay" class="fixed inset-0 bg-[#202124]/90 backdrop-blur-2xl z-50 hidden flex-col items-center justify-center text-center p-6 transition-all duration-300">
        <div class="bg-[#323639] border border-[#484c50]/70 rounded-3xl p-8 max-w-md w-full shadow-2xl flex flex-col items-center">
            <div class="w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 flex items-center justify-center mb-4 shadow-lg shadow-cyan-500/10">
                <span class="material-symbols-outlined text-3xl">visibility_off</span>
            </div>
            <h2 class="text-xl font-bold text-slate-100 header-font mb-2">Naskah Disembunyikan</h2>
            <p class="text-slate-300 text-xs leading-relaxed max-w-xs mb-6">
                Dokumen disembunyikan secara otomatis karena jendela browser tidak aktif demi menjaga keamanan dan kerahasiaan arsip digital.
            </p>
            <div class="inline-flex items-center gap-2 rounded-2xl bg-[#202124] border border-[#484c50]/60 px-4 py-2.5 text-xs text-cyan-400 font-bold shadow-inner">
                <span class="material-symbols-outlined text-[18px]">touch_app</span>
                Klik di mana saja untuk melanjutkan membaca
            </div>
        </div>
    </div>

    <!-- Toast Warning for Protection Violations -->
    <div id="protection-toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-[#323639] border border-cyan-500/30 text-slate-100 px-5 py-3 rounded-2xl shadow-2xl z-50 hidden items-center gap-3 transition-all duration-300 text-xs font-semibold">
        <span class="material-symbols-outlined text-cyan-400 text-[20px]">lock</span>
        <span id="toast-message">Aksi ini tidak diizinkan demi keamanan dokumen.</span>
    </div>

    <!-- JavaScript Core Engine & Security Handlers -->
    <script>
        // PDF.js Document Engine State
        const streamUrl = '{{ $streamUrl }}';
        const logId = {{ $logId }};
        const closeUrl = '{{ route("katalog-arsip.read-log.close", ["id" => $logId]) }}';

        let pdfDoc = null;
        let scale = 1.25;
        let isRendering = false;
        let pageRenderingQueue = [];
        let totalPages = 0;
        let currentPageNum = 1;
        let renderedPages = new Set();
        let closed = false;

        const pagesContainer = document.getElementById('pages-container');
        const loadingSpinner = document.getElementById('loading-spinner');
        const pageNumInput = document.getElementById('page-num');
        const pageCountSpan = document.getElementById('page-count');
        const zoomValSpan = document.getElementById('zoom-val');
        const prevBtn = document.getElementById('prev-page');
        const nextBtn = document.getElementById('next-page');
        const pdfViewport = document.getElementById('pdf-viewport');

        // Close Read Log Beacon
        function sendCloseBeacon() {
            if (closed) return;
            closed = true;
            navigator.sendBeacon(closeUrl);
        }
        window.addEventListener('beforeunload', sendCloseBeacon);
        window.addEventListener('unload', sendCloseBeacon);

        function handleClose() {
            sendCloseBeacon();
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.close();
            }
        }

        // Initialize PDF Loading
        async function initPdfViewer() {
            try {
                const loadingTask = pdfjsLib.getDocument({
                    url: streamUrl,
                    cMapUrl: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/cmaps/',
                    cMapPacked: true,
                });

                pdfDoc = await loadingTask.promise;
                totalPages = pdfDoc.numPages;
                pageCountSpan.textContent = totalPages;
                pageNumInput.max = totalPages;

                loadingSpinner.style.display = 'none';

                renderAllPages();
            } catch (error) {
                console.error('Error loading PDF:', error);
                loadingSpinner.innerHTML = `
                    <div class="w-12 h-12 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-2xl">error</span>
                    </div>
                    <p class="text-rose-400 font-bold text-sm">Gagal Memuat Berkas PDF</p>
                    <p class="text-slate-500 text-xs mt-1">Terjadi kesalahan saat mengunduh aliran naskah.</p>
                `;
            }
        }

        // Render All Pages in Vertical Flow
        async function renderAllPages() {
            pagesContainer.innerHTML = '';
            renderedPages.clear();

            for (let num = 1; num <= totalPages; num++) {
                const pageWrapper = document.createElement('div');
                pageWrapper.id = `page-wrapper-${num}`;
                pageWrapper.className = 'relative shadow-2xl rounded-sm overflow-hidden bg-white border border-slate-800 transition-all';
                pageWrapper.dataset.pageNum = num;

                const canvas = document.createElement('canvas');
                canvas.id = `page-canvas-${num}`;
                canvas.className = 'block max-w-full h-auto select-none pointer-events-none';

                pageWrapper.appendChild(canvas);
                pagesContainer.appendChild(pageWrapper);

                await renderSinglePage(num, canvas);
            }

            updateNavigationButtons();
        }

        // Render Single Page onto Canvas with High-DPI Crisp Text Support
        async function renderSinglePage(pageNum, canvas) {
            try {
                const page = await pdfDoc.getPage(pageNum);
                const outputScale = window.devicePixelRatio || 1;
                const viewport = page.getViewport({ scale: scale });
                const ctx = canvas.getContext('2d');

                // Set physical canvas dimensions according to Device Pixel Ratio for razor-sharp rendering
                canvas.width = Math.floor(viewport.width * outputScale);
                canvas.height = Math.floor(viewport.height * outputScale);

                // Set CSS display dimensions
                canvas.style.width = `${Math.floor(viewport.width)}px`;
                canvas.style.height = `${Math.floor(viewport.height)}px`;

                const transform = outputScale !== 1
                    ? [outputScale, 0, 0, outputScale, 0, 0]
                    : null;

                const renderContext = {
                    canvasContext: ctx,
                    transform: transform,
                    viewport: viewport
                };

                await page.render(renderContext).promise;
                renderedPages.add(pageNum);
            } catch (err) {
                console.error(`Error rendering page ${pageNum}:`, err);
            }
        }

        // Zoom Controls
        function setZoom(newScale) {
            if (newScale < 0.5 || newScale > 3.0) return;
            scale = Math.round(newScale * 100) / 100;
            zoomValSpan.textContent = `${Math.round(scale * 100)}%`;
            renderAllPages();
        }

        document.getElementById('zoom-in').addEventListener('click', () => setZoom(scale + 0.25));
        document.getElementById('zoom-out').addEventListener('click', () => setZoom(scale - 0.25));
        document.getElementById('zoom-fit').addEventListener('click', () => {
            const containerWidth = pdfViewport.clientWidth - 48; // padding offset
            if (pdfDoc && containerWidth > 0) {
                pdfDoc.getPage(1).then(page => {
                    const unscaledViewport = page.getViewport({ scale: 1.0 });
                    const fitScale = containerWidth / unscaledViewport.width;
                    setZoom(fitScale);
                });
            }
        });

        // Navigation Handlers
        function scrollToPage(pageNum) {
            if (pageNum < 1 || pageNum > totalPages) return;
            const targetWrapper = document.getElementById(`page-wrapper-${pageNum}`);
            if (targetWrapper) {
                targetWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
                currentPageNum = pageNum;
                pageNumInput.value = currentPageNum;
                updateNavigationButtons();
            }
        }

        prevBtn.addEventListener('click', () => scrollToPage(currentPageNum - 1));
        nextBtn.addEventListener('click', () => scrollToPage(currentPageNum + 1));

        pageNumInput.addEventListener('change', (e) => {
            let val = parseInt(e.target.value);
            if (isNaN(val) || val < 1) val = 1;
            if (val > totalPages) val = totalPages;
            scrollToPage(val);
        });

        function updateNavigationButtons() {
            prevBtn.disabled = currentPageNum <= 1;
            nextBtn.disabled = currentPageNum >= totalPages;
        }

        // Scroll Position Tracker to Update Current Page Number
        let scrollTimeout;
        pdfViewport.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                const wrappers = pagesContainer.querySelectorAll('[id^="page-wrapper-"]');
                const viewportTop = pdfViewport.scrollTop;

                for (let wrapper of wrappers) {
                    const top = wrapper.offsetTop - pdfViewport.offsetTop;
                    const height = wrapper.offsetHeight;
                    if (viewportTop >= top - height / 3 && viewportTop < top + height - height / 3) {
                        const pageNum = parseInt(wrapper.dataset.pageNum);
                        if (currentPageNum !== pageNum) {
                            currentPageNum = pageNum;
                            pageNumInput.value = currentPageNum;
                            updateNavigationButtons();
                        }
                        break;
                    }
                }
            }, 100);
        });

        // Initialize PDF
        document.addEventListener('DOMContentLoaded', initPdfViewer);

        // ==========================================
        // SECURITY & PROTECTION MECHANISMS
        // ==========================================

        const securityOverlay = document.getElementById('security-blur-overlay');
        const protectionToast = document.getElementById('protection-toast');
        const toastMessage = document.getElementById('toast-message');

        function showToast(msg) {
            toastMessage.textContent = msg;
            protectionToast.classList.remove('hidden');
            protectionToast.classList.add('flex');
            setTimeout(() => {
                protectionToast.classList.add('hidden');
                protectionToast.classList.remove('flex');
            }, 3000);
        }

        // Hide / Reveal Document Layer
        function hideDocument() {
            securityOverlay.classList.remove('hidden');
            securityOverlay.classList.add('flex');
            pagesContainer.style.opacity = '0';
            pagesContainer.style.pointerEvents = 'none';
        }

        function showDocument() {
            securityOverlay.classList.add('hidden');
            securityOverlay.classList.remove('flex');
            pagesContainer.style.opacity = '1';
            pagesContainer.style.pointerEvents = 'auto';
        }

        // 1. Disable Right Click Context Menu
        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            showToast('Klik kanan dinonaktifkan demi keamanan dokumen.');
            return false;
        });

        // 2. Disable Dragging
        document.addEventListener('dragstart', (e) => {
            e.preventDefault();
            return false;
        });

        // 3. Block Keyboard Shortcuts & Instant Screen Capture (Win+Shift+S, PrtScn, Meta key)
        document.addEventListener('keydown', (e) => {
            const key = e.key.toLowerCase();
            const isCtrlOrCmd = e.ctrlKey || e.metaKey;

            // Instant hide on Meta / Windows Key (Prevents Snipping Tool Win+Shift+S before capture)
            if (e.key === 'Meta' || e.key === 'OS' || e.code === 'MetaLeft' || e.code === 'MetaRight') {
                hideDocument();
                showToast('Tombol Sistem OS terdeteksi. Naskah disembunyikan.');
                return;
            }

            // Snipping Tool Shortcut (Win+Shift+S / Ctrl+Shift+S)
            if ((e.metaKey || e.ctrlKey) && e.shiftKey && (key === 's' || e.code === 'KeyS')) {
                e.preventDefault();
                hideDocument();
                showToast('Pintasan Snipping Tool (Win+Shift+S) dinonaktifkan.');
                return false;
            }

            // Ctrl+S (Save), Ctrl+P (Print), Ctrl+C (Copy), Ctrl+A (Select All), Ctrl+U (View Source)
            if (isCtrlOrCmd && ['s', 'p', 'c', 'a', 'u'].includes(key)) {
                e.preventDefault();
                showToast(`Pintasan Ctrl+${key.toUpperCase()} dinonaktifkan.`);
                return false;
            }

            // F12 or DevTools shortcuts (Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C)
            if (e.key === 'F12' || (isCtrlOrCmd && e.shiftKey && ['i', 'j', 'c'].includes(key))) {
                e.preventDefault();
                showToast('Developer Tools dinonaktifkan pada mode pembaca.');
                return false;
            }

            // PrintScreen Key
            if (e.key === 'PrintScreen' || e.code === 'PrintScreen') {
                hideDocument();
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText('');
                }
                showToast('Tangkapan layar (PrintScreen) dinonaktifkan.');
            }
        });

        document.addEventListener('keyup', (e) => {
            if (e.key === 'PrintScreen' || e.code === 'PrintScreen') {
                hideDocument();
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText('');
                }
            }
        });

        // 4. Blur & Hide on Focus Loss / Visibility Change
        window.addEventListener('blur', hideDocument);
        window.addEventListener('focus', showDocument);
        securityOverlay.addEventListener('click', showDocument);

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                hideDocument();
            } else {
                showDocument();
            }
        });
    </script>
</body>
</html>

