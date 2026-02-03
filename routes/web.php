<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\InventoryReportController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (ALL ROLES)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard (view differs by role inside controller/view)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Bookings (all users can view & create)
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    // Items (view only)
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
});

/*
|--------------------------------------------------------------------------
| Staff & Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:staff,admin'])->group(function () {

    // Item management
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    // Master data
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('suppliers', SupplierController::class)->except(['show']);
    Route::resource('departments', DepartmentController::class)->except(['show']);

    // Booking approvals
    Route::post('/bookings/{booking}/approve', [BookingController::class, 'approve'])
        ->name('bookings.approve');

    Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])
        ->name('bookings.reject');

        // Inventory Reports
    Route::get('/reports/inventory', [InventoryReportController::class, 'index'])
        ->name('admin.reports.inventory');

    Route::get('/reports/inventory/pdf', [InventoryReportController::class, 'pdf'])
        ->name('admin.reports.inventory.pdf');
});

/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // User approval
    Route::post('users/{id}/approve',
            [UserController::class, 'approve']
        )->name('users.approve');
    
    // User management
    Route::resource('users', UserController::class);

});
