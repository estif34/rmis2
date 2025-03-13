<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\RiskCategoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

require __DIR__.'/auth.php';

Route::get('/', function () {
    if (Auth::check()) {
        if (!Auth::user()->is_approved) {
            return redirect()->route('approval.pending');
        }
        return redirect()->route('dashboard');
    }
    
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/approval-pending', [App\Http\Controllers\ApprovalController::class, 'pending'])->name('approval.pending');
    Route::post('/approval-logout', [App\Http\Controllers\ApprovalController::class, 'logout'])->name('approval.logout');
});
Route::middleware(['approved'])->group(function(){
        Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'userManagement'])->name('admin.users');
        Route::patch('/users/{user}/approve', [App\Http\Controllers\AdminController::class, 'approveUser'])->name('admin.users.approve');
        Route::patch('/users/{user}/role', [App\Http\Controllers\AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
    });

    // Risk routes
    Route::resource('risks', App\Http\Controllers\RiskController::class);
    Route::get('risks/{risk}/collaborators', [App\Http\Controllers\RiskController::class, 'manageCollaborators'])->name('risks.collaborators');
    Route::post('risks/{risk}/collaborators', [App\Http\Controllers\RiskController::class, 'updateCollaborators'])->name('risks.collaborators.update');

    // Risk category routes
    Route::resource('categories', App\Http\Controllers\RiskCategoryController::class);
    
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard filter routes
Route::middleware(['approved'])->prefix('dashboard')->group(function () {
    Route::get('/risks/level/{level}', [App\Http\Controllers\DashboardController::class, 'filterByLevel'])->name('dashboard.filter.level');
    Route::get('/risks/status/{status}', [App\Http\Controllers\DashboardController::class, 'filterByStatus'])->name('dashboard.filter.status');
    Route::get('/risks/user', [App\Http\Controllers\DashboardController::class, 'filterUserRisks'])->name('dashboard.filter.user');
    Route::get('/risks/all', [App\Http\Controllers\DashboardController::class, 'filterAllRisks'])->name('dashboard.filter.all');
});
// Risk comment routes
Route::post('risks/{risk}/comments', [App\Http\Controllers\RiskCommentController::class, 'store'])->name('risks.comments.store');
Route::delete('risks/{risk}/comments/{comment}', [App\Http\Controllers\RiskCommentController::class, 'destroy'])->name('risks.comments.destroy');
    


