<!-- Custom Confirmation & Alert Modal Container -->
<div id="sipus-custom-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">
    <!-- Backdrop with glassmorphism blur -->
    <div id="sipus-modal-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-[4px] transition-opacity duration-300 opacity-0 cursor-pointer"></div>
    
    <!-- Modal Card with slide-up & scale transition -->
    <div id="sipus-modal-card" class="bg-white rounded-3xl border border-outline-variant/15 shadow-2xl max-w-sm w-full p-6 relative z-10 transform scale-95 opacity-0 transition-all duration-300 flex flex-col items-center text-center gap-5">
        <!-- Icon Wrapper -->
        <div id="sipus-modal-icon-container" class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-sm transition-all duration-300">
            <span id="sipus-modal-icon" class="material-symbols-outlined text-[32px]">warning</span>
        </div>
        
        <!-- Text Message -->
        <div class="space-y-1.5 w-full">
            <h3 id="sipus-modal-title" class="font-headline-md text-slate-800 text-lg font-bold">Konfirmasi</h3>
            <p id="sipus-modal-message" class="text-xs text-slate-500 font-semibold leading-relaxed px-1"></p>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center gap-3 w-full mt-1">
            <button id="sipus-modal-btn-cancel" class="flex-1 py-3 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-xs transition duration-200 focus:outline-none">
                Batal
            </button>
            <button id="sipus-modal-btn-confirm" class="flex-1 py-3 px-5 text-white font-bold rounded-2xl text-xs transition duration-200 shadow-md focus:outline-none">
                Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
    window.SIPUSModal = {
        _resolve: null,
        
        show: function(title, message, options = {}) {
            const type = options.type || 'warning'; // 'warning', 'danger', 'success', 'info'
            const isConfirm = options.isConfirm !== false;
            
            const modal = document.getElementById('sipus-custom-modal');
            const backdrop = document.getElementById('sipus-modal-backdrop');
            const card = document.getElementById('sipus-modal-card');
            
            const titleEl = document.getElementById('sipus-modal-title');
            const msgEl = document.getElementById('sipus-modal-message');
            const iconEl = document.getElementById('sipus-modal-icon');
            const iconContainer = document.getElementById('sipus-modal-icon-container');
            
            const btnCancel = document.getElementById('sipus-modal-btn-cancel');
            const btnConfirm = document.getElementById('sipus-modal-btn-confirm');
            
            // Set text content
            titleEl.textContent = title;
            msgEl.textContent = message;
            
            // Reset style classes
            iconContainer.className = 'w-14 h-14 rounded-2xl flex items-center justify-center shadow-sm';
            btnConfirm.className = 'flex-1 py-3 px-5 text-white font-bold rounded-2xl text-xs transition duration-200 shadow-md';
            
            // Configure colors and icons dynamically
            if (type === 'danger') {
                iconEl.textContent = 'delete_forever';
                iconContainer.classList.add('bg-rose-50', 'text-rose-600', 'border', 'border-rose-100');
                btnConfirm.classList.add('bg-rose-600', 'hover:bg-rose-700', 'shadow-rose-600/15');
                btnConfirm.textContent = options.confirmText || 'Ya, Hapus';
            } else if (type === 'success') {
                iconEl.textContent = 'check_circle';
                iconContainer.classList.add('bg-emerald-50', 'text-emerald-600', 'border', 'border-emerald-100');
                btnConfirm.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'shadow-emerald-600/15');
                btnConfirm.textContent = options.confirmText || 'Selesai';
            } else if (type === 'info') {
                iconEl.textContent = 'info';
                iconContainer.classList.add('bg-blue-50', 'text-blue-600', 'border', 'border-blue-100');
                btnConfirm.classList.add('bg-primary', 'hover:bg-primary/95', 'shadow-primary/20');
                btnConfirm.textContent = options.confirmText || 'Mengerti';
            } else { // warning
                iconEl.textContent = 'warning';
                iconContainer.classList.add('bg-amber-50', 'text-amber-500', 'border', 'border-amber-100');
                btnConfirm.classList.add('bg-amber-500', 'hover:bg-amber-600', 'shadow-amber-500/15');
                btnConfirm.textContent = options.confirmText || 'Ya, Lanjutkan';
            }
            
            // Show/hide cancel button based on mode
            if (isConfirm) {
                btnCancel.classList.remove('hidden');
                btnCancel.textContent = options.cancelText || 'Batal';
            } else {
                btnCancel.classList.add('hidden');
            }
            
            // Open animation
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Force browser reflow to enable transition
            modal.offsetHeight;
            
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
            
            return new Promise((resolve) => {
                this._resolve = resolve;
            });
        },
        
        close: function(result) {
            const modal = document.getElementById('sipus-custom-modal');
            const backdrop = document.getElementById('sipus-modal-backdrop');
            const card = document.getElementById('sipus-modal-card');
            
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                if (this._resolve) {
                    this._resolve(result);
                    this._resolve = null;
                }
            }, 250);
        },
        
        confirm: function(title, message, type = 'warning', options = {}) {
            return this.show(title, message, { ...options, type: type, isConfirm: true });
        },
        
        alert: function(title, message, type = 'info', options = {}) {
            return this.show(title, message, { ...options, type: type, isConfirm: false });
        }
    };

    // Helper functions for form intercepting
    function interceptForm(form) {
        const onsubmitAttr = form.getAttribute('onsubmit');
        if (onsubmitAttr && onsubmitAttr.includes('confirm(')) {
            // Extract message inside single or double quotes of confirm(...)
            const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
            if (match) {
                const message = match[1];
                // Remove inline handler to prevent native browser pop-up
                form.removeAttribute('onsubmit');
                form.dataset.confirmMessage = message;
                
                form.addEventListener('submit', function(e) {
                    if (form.dataset.sipusConfirmed === 'true') {
                        return;
                    }
                    e.preventDefault();
                    
                    let type = 'warning';
                    if (message.toLowerCase().includes('hapus') || message.toLowerCase().includes('delete') || message.toLowerCase().includes('permanen')) {
                        type = 'danger';
                    }
                    
                    window.SIPUSModal.confirm('Konfirmasi Tindakan', message, type).then(confirmed => {
                        if (confirmed) {
                            form.dataset.sipusConfirmed = 'true';
                            form.submit();
                        }
                    });
                });
            }
        }
    }

    // Bind UI actions and intercept forms
    document.addEventListener('DOMContentLoaded', function() {
        const btnCancel = document.getElementById('sipus-modal-btn-cancel');
        const btnConfirm = document.getElementById('sipus-modal-btn-confirm');
        const backdrop = document.getElementById('sipus-modal-backdrop');
        
        btnCancel.addEventListener('click', () => window.SIPUSModal.close(false));
        btnConfirm.addEventListener('click', () => window.SIPUSModal.close(true));
        backdrop.addEventListener('click', () => window.SIPUSModal.close(false));
        
        // Scan and intercept forms already on the page
        document.querySelectorAll('form').forEach(interceptForm);
        
        // Watch for dynamically added forms in SPA/livewire context
        const observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        if (node.tagName === 'FORM') {
                            interceptForm(node);
                        }
                        node.querySelectorAll('form').forEach(interceptForm);
                    }
                });
            });
        });
        observer.observe(document.body, { childList: true, subtree: true });
    });
</script>
