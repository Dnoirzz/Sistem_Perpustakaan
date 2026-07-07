<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Petugas\LoanController as PetugasLoanController;
use App\Http\Controllers\Petugas\ReturnController as PetugasReturnController;
use App\Http\Controllers\Petugas\BookingController as PetugasBookingController;
use App\Http\Controllers\Petugas\AntrianController as PetugasAntrianController;
use App\Http\Controllers\Petugas\PenaltyController as PetugasPenaltyController;
use App\Http\Controllers\Petugas\ReturnSettingController as PetugasReturnSettingController;
use App\Http\Controllers\Petugas\ArsipController as PetugasArsipController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboard;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\ArsipKatalogController;
use App\Http\Controllers\Mahasiswa\ArsipController as MahasiswaArsipController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard router based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isPetugas()) {
        return redirect()->route('petugas.dashboard');
    } elseif ($user->isDosen()) {
        return redirect()->route('dosen.dashboard');
    } elseif ($user->isMahasiswa()) {
        return redirect()->route('mahasiswa.dashboard');
    }
    abort(403, 'Role tidak dikenali.');
})->middleware(['auth'])->name('dashboard');

// Auth routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Phase 2: User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Phase 6: Notification Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/wa', [\App\Http\Controllers\Admin\SettingController::class, 'waIndex'])->name('wa');
        Route::post('/wa', [\App\Http\Controllers\Admin\SettingController::class, 'waUpdate'])->name('wa.update');
        Route::post('/wa/test', [\App\Http\Controllers\Admin\SettingController::class, 'testWa'])->name('wa.test');

        Route::get('/email', [\App\Http\Controllers\Admin\SettingController::class, 'emailIndex'])->name('email');
        Route::post('/email', [\App\Http\Controllers\Admin\SettingController::class, 'emailUpdate'])->name('email.update');
        Route::post('/email/test', [\App\Http\Controllers\Admin\SettingController::class, 'testEmail'])->name('email.test');
        
        // Fallback redirect
        Route::get('/', function() {
            return redirect()->route('admin.settings.wa');
        })->name('index');
    });

    // Activity Logs (Fase 6)
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
});

// Petugas routes
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboard::class, 'index'])->name('dashboard');
    
    // CRUD Buku & Kategori (Fase 3)
    Route::resource('books', \App\Http\Controllers\Petugas\BookController::class);
    Route::resource('categories', \App\Http\Controllers\Petugas\CategoryController::class);
    
    Route::resource('members', \App\Http\Controllers\Petugas\MemberController::class);

    // Fase 5: Arsip Digital
    Route::get('/arsip', [PetugasArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/{type}/{id}', [PetugasArsipController::class, 'show'])->name('arsip.show');
    Route::get('/arsip/{type}/{id}/edit', [PetugasArsipController::class, 'edit'])->name('arsip.edit');
    Route::put('/arsip/{type}/{id}', [PetugasArsipController::class, 'update'])->name('arsip.update');
    Route::delete('/arsip/{type}/{id}', [PetugasArsipController::class, 'destroy'])->name('arsip.destroy');
    Route::post('/arsip/{type}/{id}/verify', [PetugasArsipController::class, 'verify'])->name('arsip.verify');
    Route::post('/arsip/{type}/{id}/reject', [PetugasArsipController::class, 'reject'])->name('arsip.reject');
    Route::post('/arsip/{type}/{id}/confirm', [PetugasArsipController::class, 'confirmReceipt'])->name('arsip.confirm');
    Route::get('/arsip/{type}/{id}/download', [PetugasArsipController::class, 'download'])->name('arsip.download');
    Route::get('/arsip/{type}/{id}/surat', [PetugasArsipController::class, 'downloadSurat'])->name('arsip.surat');
    
    Route::get('/loans', [PetugasLoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/search-members', [PetugasLoanController::class, 'searchMembers'])->name('loans.search-members');
    Route::get('/loans/search-books', [PetugasLoanController::class, 'searchBooks'])->name('loans.search-books');
    Route::get('/loans/create', [PetugasLoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [PetugasLoanController::class, 'store'])->name('loans.store');
    
    // Pengembalian Buku (Fase 4)
    Route::get('/returns', [PetugasReturnController::class, 'index'])->name('returns.index');
    Route::post('/returns/{loan}/process', [PetugasReturnController::class, 'process'])->name('returns.process');

    // Kelola Booking (Fase 4)
    Route::get('/bookings', [PetugasBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [PetugasBookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [PetugasBookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{booking}/realize', [PetugasBookingController::class, 'realize'])->name('bookings.realize');

    // Antrian (Fase 4)
    Route::get('/antrian', [PetugasAntrianController::class, 'index'])->name('antrian.index');
    Route::post('/antrian/{antrian}/mark-available', [PetugasAntrianController::class, 'markAvailable'])->name('antrian.mark-available');
    Route::post('/antrian/{antrian}/mark-done', [PetugasAntrianController::class, 'markDone'])->name('antrian.mark-done');

    // Denda & Sanksi (Fase 4)
    Route::get('/penalties', [PetugasPenaltyController::class, 'index'])->name('penalties.index');
    Route::get('/penalties/create', [PetugasPenaltyController::class, 'create'])->name('penalties.create');
    Route::post('/penalties', [PetugasPenaltyController::class, 'store'])->name('penalties.store');
    Route::post('/penalties/{penalty}/mark-paid', [PetugasPenaltyController::class, 'markPaid'])->name('penalties.mark-paid');

    // Pengaturan Checklist & Denda Pengembalian
    Route::get('/return-settings', [PetugasReturnSettingController::class, 'index'])->name('return-settings.index');
    Route::post('/return-settings/checklists', [PetugasReturnSettingController::class, 'storeChecklist'])->name('return-settings.checklists.store');
    Route::get('/return-settings/checklists/{checklist}/edit', [PetugasReturnSettingController::class, 'editChecklist'])->name('return-settings.checklists.edit');
    Route::put('/return-settings/checklists/{checklist}', [PetugasReturnSettingController::class, 'updateChecklist'])->name('return-settings.checklists.update');
    Route::delete('/return-settings/checklists/{checklist}', [PetugasReturnSettingController::class, 'destroyChecklist'])->name('return-settings.checklists.destroy');
    Route::get('/return-settings/penalty-rules/{penaltyRule}/edit', [PetugasReturnSettingController::class, 'editPenaltyRule'])->name('return-settings.penalty-rules.edit');
    Route::put('/return-settings/penalty-rules/{penaltyRule}', [PetugasReturnSettingController::class, 'updatePenaltyRule'])->name('return-settings.penalty-rules.update');

    // Usulan Buku Baru (Fase 6)
    Route::get('/recommendations', [\App\Http\Controllers\Petugas\RecommendationController::class, 'index'])->name('recommendations.index');
    Route::post('/recommendations/{id}/verify', [\App\Http\Controllers\Petugas\RecommendationController::class, 'verify'])->name('recommendations.verify');
    Route::delete('/recommendations/{id}', [\App\Http\Controllers\Petugas\RecommendationController::class, 'destroy'])->name('recommendations.destroy');

    // Laporan & Ekspor Data (Fase 6)
    Route::get('/reports', [\App\Http\Controllers\Petugas\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print-sirkulasi', [\App\Http\Controllers\Petugas\ReportController::class, 'printSirkulasi'])->name('reports.print-sirkulasi');
    Route::get('/reports/export-sirkulasi', [\App\Http\Controllers\Petugas\ReportController::class, 'exportSirkulasiExcel'])->name('reports.export-sirkulasi');
    Route::get('/reports/print-koleksi', [\App\Http\Controllers\Petugas\ReportController::class, 'printKoleksi'])->name('reports.print-koleksi');
    Route::get('/reports/export-koleksi', [\App\Http\Controllers\Petugas\ReportController::class, 'exportKoleksiExcel'])->name('reports.export-koleksi');

    // Kelola Voting Buku (Petugas View)
    Route::resource('voting', \App\Http\Controllers\Petugas\VotingController::class);
});

// Dosen routes
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenDashboard::class, 'index'])->name('dashboard');
    
    Route::get('/books', [\App\Http\Controllers\BookSearchController::class, 'index'])->name('books.index');
    
    Route::get('/recommendations', [\App\Http\Controllers\RecommendationController::class, 'index'])->name('recommendations.index');
    Route::get('/recommendations/create', [\App\Http\Controllers\RecommendationController::class, 'create'])->name('recommendations.create');
    Route::post('/recommendations', [\App\Http\Controllers\RecommendationController::class, 'store'])->name('recommendations.store');

    // Voting routes
    Route::get('/voting', [\App\Http\Controllers\VotingController::class, 'index'])->name('voting.index');
    Route::post('/voting/{voting_item_id}/vote', [\App\Http\Controllers\VotingController::class, 'vote'])->name('voting.vote');

    // Booking & Antrian (Fase 4)
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
    Route::post('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/antrian', [\App\Http\Controllers\AntrianController::class, 'store'])->name('antrian.store');
    Route::get('/antrian', [\App\Http\Controllers\AntrianController::class, 'myAntrian'])->name('antrian.my');

    // Member Loans & History (Rak Pinjam)
    Route::get('/loans', [\App\Http\Controllers\MemberLoanController::class, 'activeLoans'])->name('loans.active');
    Route::get('/loans/history', [\App\Http\Controllers\MemberLoanController::class, 'loanHistory'])->name('loans.history');

    // Fase 5: Katalog Arsip
    Route::get('/katalog-arsip', [ArsipKatalogController::class, 'index'])->name('katalog-arsip.index');
    Route::get('/katalog-arsip/{type}/{id}', [ArsipKatalogController::class, 'show'])->name('katalog-arsip.show');
    Route::get('/katalog-arsip/{type}/{id}/preview', [ArsipKatalogController::class, 'preview'])->name('katalog-arsip.preview');
    Route::get('/katalog-arsip/{type}/{id}/{slug}.pdf', [ArsipKatalogController::class, 'full'])->name('katalog-arsip.full');
});

// Mahasiswa routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');
    
    Route::get('/books', [\App\Http\Controllers\BookSearchController::class, 'index'])->name('books.index');
    
    Route::get('/recommendations', [\App\Http\Controllers\RecommendationController::class, 'index'])->name('recommendations.index');
    Route::get('/recommendations/create', [\App\Http\Controllers\RecommendationController::class, 'create'])->name('recommendations.create');
    Route::post('/recommendations', [\App\Http\Controllers\RecommendationController::class, 'store'])->name('recommendations.store');

    // Fase 5: Upload Repository & Katalog Arsip
    Route::get('/arsip', [MahasiswaArsipController::class, 'index'])->name('arsip.index');
    Route::post('/arsip', [MahasiswaArsipController::class, 'store'])->name('arsip.store');
    Route::get('/arsip/{type}/{id}/edit', [MahasiswaArsipController::class, 'edit'])->name('arsip.edit');
    Route::put('/arsip/{type}/{id}', [MahasiswaArsipController::class, 'update'])->name('arsip.update');
    Route::delete('/arsip/{type}/{id}', [MahasiswaArsipController::class, 'destroy'])->name('arsip.destroy');
    Route::get('/katalog-arsip', [ArsipKatalogController::class, 'index'])->name('katalog-arsip.index');
    Route::get('/katalog-arsip/{type}/{id}', [ArsipKatalogController::class, 'show'])->name('katalog-arsip.show');
    Route::get('/katalog-arsip/{type}/{id}/preview', [ArsipKatalogController::class, 'preview'])->name('katalog-arsip.preview');
    Route::get('/katalog-arsip/{type}/{id}/{slug}.pdf', [ArsipKatalogController::class, 'full'])->name('katalog-arsip.full');

    // Voting routes
    Route::get('/voting', [\App\Http\Controllers\VotingController::class, 'index'])->name('voting.index');
    Route::post('/voting/{voting_item_id}/vote', [\App\Http\Controllers\VotingController::class, 'vote'])->name('voting.vote');

    // Booking & Antrian (Fase 4)
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
    Route::post('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/antrian', [\App\Http\Controllers\AntrianController::class, 'store'])->name('antrian.store');
    Route::get('/antrian', [\App\Http\Controllers\AntrianController::class, 'myAntrian'])->name('antrian.my');

    // Member Loans & History (Rak Pinjam)
    Route::get('/loans', [\App\Http\Controllers\MemberLoanController::class, 'activeLoans'])->name('loans.active');
    Route::get('/loans/history', [\App\Http\Controllers\MemberLoanController::class, 'loanHistory'])->name('loans.history');
});

require __DIR__.'/auth.php';
