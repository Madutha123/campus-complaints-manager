<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Staff\ComplaintController as StaffComplaintController;
use App\Http\Controllers\Student\ComplaintController as StudentComplaintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! auth()->check()) {
        return redirect('/login');
    }

    return match (auth()->user()->role) {
        'student' => redirect('/student/dashboard'),
        'staff' => redirect('/staff/dashboard'),
        'admin' => redirect('/admin/dashboard'),
        default => abort(403),
    };
})->name('home');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function (): void {
        Route::get('/dashboard', [StudentComplaintController::class, 'dashboard'])->name('dashboard');
        Route::get('/complaints', [StudentComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/create', [StudentComplaintController::class, 'create'])->name('complaints.create');
        Route::post('/complaints', [StudentComplaintController::class, 'store'])->name('complaints.store');
        Route::get('/complaints/{complaint}', [StudentComplaintController::class, 'show'])->name('complaints.show');
    });

Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function (): void {
        Route::get('/dashboard', [StaffComplaintController::class, 'dashboard'])->name('dashboard');
        Route::get('/complaints', [StaffComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/{complaint}', [StaffComplaintController::class, 'show'])->name('complaints.show');
        Route::patch('/complaints/{complaint}/status', [StaffComplaintController::class, 'updateStatus'])->name('complaints.update-status');
    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/dashboard', [AdminComplaintController::class, 'dashboard'])->name('dashboard');
        Route::patch('/complaints/{complaint}/assign', [AdminComplaintController::class, 'assign'])->name('complaints.assign');
        Route::patch('/complaints/{complaint}/status', [AdminComplaintController::class, 'updateStatus'])->name('complaints.update-status');
        Route::resource('/complaints', AdminComplaintController::class);
        Route::get('/departments', [AdminDepartmentController::class, 'index'])->name('departments.index');
        Route::post('/departments', [AdminDepartmentController::class, 'store'])->name('departments.store');
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::resource('/users', AdminUserController::class);
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    });

require __DIR__.'/settings.php';
