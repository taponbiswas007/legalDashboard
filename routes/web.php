<?php

use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Super admin only routes
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin/users/approval', [SuperAdminController::class, 'userApprovalList'])->name('admin.users.approval');
    Route::post('/admin/users/approve/{id}', [SuperAdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('/admin/users/unapprove/{id}', [SuperAdminController::class, 'unapproveUser'])->name('admin.users.unapprove');
    Route::post('/admin/users/block/{id}', [SuperAdminController::class, 'blockUser'])->name('admin.users.block');
    Route::post('/admin/users/unblock/{id}', [SuperAdminController::class, 'unblockUser'])->name('admin.users.unblock');
});

// User only routes
Route::middleware(['auth', 'approved', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
