<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Firebase Authentication routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/firebase', function () {
        return view('auth.firebase-auth');
    })->middleware('guest')->name('firebase');
    Route::post('/firebase/callback', [FirebaseAuthController::class, 'callback'])->name('firebase.callback');
    Route::post('/logout', [FirebaseAuthController::class, 'logout'])->name('logout');
    Route::get('/user', [FirebaseAuthController::class, 'user'])->name('user');
    
    // Check if user exists by email (no auth required)
    Route::post('/check-user', [FirebaseAuthController::class, 'checkUserExists'])->name('check-user');
});

// Admin Authentication routes (public)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Main dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
    });
    
    // Admin routes
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            $user = Auth::user();
            $totalUsers = \App\Models\User::count();
            $totalCustomers = \App\Models\User::where('role', 'customer')->count();
            $totalVendors = \App\Models\User::where('role', 'vendor')->count();
            $recentUsers = \App\Models\User::latest()->take(5)->get();
            return view('dashboard.admin', compact('user', 'totalUsers', 'totalCustomers', 'totalVendors', 'recentUsers'));
        })->name('dashboard');
        
        // User management
        Route::resource('users', UserController::class);
        Route::get('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    });
    
    // Vendor routes
    Route::middleware('role:vendor')->prefix('vendor')->name('vendor.')->group(function () {
        Route::get('/dashboard', function () {
            $user = Auth::user();
            return view('dashboard.vendor', compact('user'));
        })->name('dashboard');
    });
    
    // Customer routes
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', function () {
            $user = Auth::user();
            return view('dashboard.customer', compact('user'));
        })->name('dashboard');
    });
});
