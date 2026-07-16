<?php

use App\Http\Controllers\{
    AuthController,
    Auth\EmailVerificationPromptController,
    Auth\ResendVerificationEmailController,
    Auth\VerifyEmailController,
    BookController,
    BookReturnController,
    BorrowingController,
    CatalogController,
    DashboardController,
    MemberController,
    MemberPortalController,
    RegisterController,
    ReservationController
};
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\EnsureMemberIsApproved;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('catalog.index'));

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{book}', [CatalogController::class, 'show'])->name('catalog.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout untuk semua pengguna yang sudah login (admin & anggota).
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [ResendVerificationEmailController::class, '__invoke'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// Reservasi buku oleh anggota (dari katalog).
Route::post('/catalog/{book}/reserve', [ReservationController::class, 'store'])
    ->middleware(['auth', 'member', EnsureEmailIsVerified::class, EnsureMemberIsApproved::class])->name('catalog.reserve');

// Area Anggota (Member Portal) — email verified + admin approved.
Route::middleware(['auth', 'member', EnsureEmailIsVerified::class, EnsureMemberIsApproved::class])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/borrowings', [MemberPortalController::class, 'borrowings'])->name('borrowings');
    Route::get('/profile', [MemberPortalController::class, 'profile'])->name('profile');
    Route::put('/profile', [MemberPortalController::class, 'updateProfile'])->name('profile.update');
    Route::post('/borrowings/{borrowing}/cancel', [ReservationController::class, 'cancel'])->name('borrowings.cancel');
});

// Area Admin.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);
    Route::post('members/{member}/approve', [MemberController::class, 'approve'])->name('members.approve');
    Route::post('members/{member}/reject', [MemberController::class, 'reject'])->name('members.reject');
    Route::resource('borrowings', BorrowingController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::post('borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::get('borrowings/{borrowing}/print', [BorrowingController::class, 'printReceipt'])->name('borrowings.print');
    Route::get('borrowings/{borrowing}/return', [BookReturnController::class, 'create'])->name('returns.create');
    Route::post('borrowings/{borrowing}/return', [BookReturnController::class, 'store'])->name('returns.store');
});
