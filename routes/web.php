<?php

use App\Http\Controllers\{
    AuthController,
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

// Reservasi buku oleh anggota (dari katalog).
Route::post('/catalog/{book}/reserve', [ReservationController::class, 'store'])
    ->middleware(['auth', 'member'])->name('catalog.reserve');

// Area Anggota (Member Portal).
Route::middleware(['auth', 'member'])->prefix('member')->name('member.')->group(function () {
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
    Route::resource('borrowings', BorrowingController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::post('borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::get('borrowings/{borrowing}/print', [BorrowingController::class, 'printReceipt'])->name('borrowings.print');
    Route::get('borrowings/{borrowing}/return', [BookReturnController::class, 'create'])->name('returns.create');
    Route::post('borrowings/{borrowing}/return', [BookReturnController::class, 'store'])->name('returns.store');
});
