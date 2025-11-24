<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;

// ========================================
// PUBLIC ROUTES (Guest & User)
// ========================================

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Event Catalog & Detail
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');

// ========================================
// ADMIN ROUTES
// ========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    
    // Organizer Approval
    Route::get('/organizers/approval', [App\Http\Controllers\Admin\OrganizerApprovalController::class, 'index'])->name('organizers.approval');
    Route::post('/organizers/{user}/approve', [App\Http\Controllers\Admin\OrganizerApprovalController::class, 'approve'])->name('organizers.approve');
    Route::post('/organizers/{user}/reject', [App\Http\Controllers\Admin\OrganizerApprovalController::class, 'reject'])->name('organizers.reject');
    
    // ✅ TAMBAH: Category Management
    Route::resource('/categories', App\Http\Controllers\Admin\CategoryController::class);
    
    // Event Management (Admin bisa manage SEMUA event)
    Route::resource('/events', App\Http\Controllers\Admin\EventController::class);
    
    // Ticket Management
    Route::get('/events/{event}/tickets/create', [App\Http\Controllers\Admin\TicketController::class, 'create'])->name('events.tickets.create');
    Route::post('/events/{event}/tickets', [App\Http\Controllers\Admin\TicketController::class, 'store'])->name('events.tickets.store');
    Route::get('/tickets/{ticket}/edit', [App\Http\Controllers\Admin\TicketController::class, 'edit'])->name('tickets.edit');
    Route::patch('/tickets/{ticket}', [App\Http\Controllers\Admin\TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [App\Http\Controllers\Admin\TicketController::class, 'destroy'])->name('tickets.destroy');
    
    // Booking Management
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/approve', [App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [App\Http\Controllers\Admin\BookingController::class, 'reject'])->name('bookings.reject');
    
    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    
    // Analytics (OPTIONAL dari soal)
    Route::get('/analytics', [App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
});

// ========================================
// ORGANIZER ROUTES (Approved Only)
// ========================================
Route::middleware(['auth', 'organizer.approved'])->prefix('organizer')->name('organizer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Organizer\DashboardController::class, 'index'])->name('dashboard');
    
    // Event Management (Organizer hanya manage event sendiri)
    Route::resource('/events', App\Http\Controllers\Organizer\EventController::class);
    
    // Ticket Management
    Route::get('/events/{event}/tickets/create', [App\Http\Controllers\Organizer\TicketController::class, 'create'])->name('events.tickets.create');
    Route::post('/events/{event}/tickets', [App\Http\Controllers\Organizer\TicketController::class, 'store'])->name('events.tickets.store');
    Route::get('/tickets/{ticket}/edit', [App\Http\Controllers\Organizer\TicketController::class, 'edit'])->name('tickets.edit');
    Route::patch('/tickets/{ticket}', [App\Http\Controllers\Organizer\TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [App\Http\Controllers\Organizer\TicketController::class, 'destroy'])->name('tickets.destroy');
    
    // Booking Management (Hanya untuk event sendiri)
    Route::get('/bookings', [App\Http\Controllers\Organizer\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [App\Http\Controllers\Organizer\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/approve', [App\Http\Controllers\Organizer\BookingController::class, 'approve'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [App\Http\Controllers\Organizer\BookingController::class, 'reject'])->name('bookings.reject');
    
    // Analytics (OPTIONAL dari soal)
    Route::get('/analytics', [App\Http\Controllers\Organizer\AnalyticsController::class, 'index'])->name('analytics.index');
});

// ========================================
// ORGANIZER PENDING PAGE
// ========================================
Route::middleware(['auth', 'organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    // Pending Page
    Route::get('/pending', function () {
        $user = auth()->user();
        
        // Kalau sudah approved, redirect ke dashboard
        if ($user->organizer_status === 'approved') {
            return redirect()->route('organizer.dashboard');
        }
        
        // Kalau pending atau rejected, tampilkan pending page
        return view('auth.pending');
    })->name('pending');
    
    // Delete Account (kalau rejected)
    Route::delete('/account', function () {
        $user = auth()->user();
        
        // Hanya bisa delete kalau rejected
        if ($user->organizer_status === 'rejected') {
            auth()->logout();
            $user->delete();
            return redirect()->route('home')->with('success', 'Account deleted successfully.');
        }
        
        return back()->with('error', 'Cannot delete account.');
    })->name('account.destroy');
});

// ========================================
// USER ROUTES
// ========================================
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');
    
    // Booking
    Route::get('/bookings', [App\Http\Controllers\User\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [App\Http\Controllers\User\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\User\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [App\Http\Controllers\User\BookingController::class, 'show'])->name('bookings.show');
    Route::delete('/bookings/{booking}', [App\Http\Controllers\User\BookingController::class, 'destroy'])->name('bookings.destroy');
    
    // Favorites
    Route::get('/favorites', [App\Http\Controllers\User\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{event}', [App\Http\Controllers\User\FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{event}', [App\Http\Controllers\User\FavoriteController::class, 'destroy'])->name('favorites.destroy');
    
    // Reviews (OPTIONAL dari soal)
    Route::post('/events/{event}/reviews', [App\Http\Controllers\User\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [App\Http\Controllers\User\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::patch('/reviews/{review}', [App\Http\Controllers\User\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [App\Http\Controllers\User\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// ========================================
// PROFILE ROUTES (Semua role bisa akses)
// ========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// REDIRECT AFTER LOGIN (Berdasarkan Role)
// ========================================
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'organizer') {
        if ($user->organizer_status === 'approved') {
            return redirect()->route('organizer.dashboard');
        } else {
            return redirect()->route('organizer.pending');
        }
    } else {
        return redirect()->route('user.dashboard');
    }
})->name('dashboard');

// Auth routes (dari Breeze)
require __DIR__.'/auth.php';