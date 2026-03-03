<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendance;
use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Admin\SalaryController as AdminSalaryController;

use App\Http\Controllers\Staff\DashboardController;
use App\Http\Controllers\Staff\OrdersController;
use App\Http\Controllers\Staff\ReservationsController;
use App\Http\Controllers\Staff\ProfileController;
use App\Http\Controllers\Staff\AttendanceController as StaffAttendance;
use App\Http\Controllers\Staff\LeaveController as StaffLeaveController;
use App\Http\Controllers\Staff\SalaryController as StaffSalaryController;

use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\ReservetableController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:customer'])->group(function () {

    Route::get('/my-payments', [CheckoutController::class, 'myPayments'])->name('my.payments');

    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order');
    Route::get('/order-track/{id}', [CheckoutController::class, 'track'])->name('order.track');
    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('my.orders');
    Route::post('/cancel-order/{id}', [CheckoutController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/payment-success/{id}', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');

    Route::get('/reservations', [ReservetableController::class, 'index'])->name('reservation');
    Route::post('/reservations/store', [ReservetableController::class, 'store'])->name('reservation.store');
    Route::get('/reservation-success', [ReservetableController::class, 'success'])->name('reservation.success');
});

/*
|--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
*/


Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/profile', function() {
            return view('admin.profile');
        })->name('profile');

            // Payments page
            Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments');

        Route::resource('staff', StaffController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('tables', TableController::class);
        Route::post('tables/bulk-action', [TableController::class, 'bulkAction'])->name('tables.bulkAction');
        Route::get('tables/export/{type}', [TableController::class, 'export'])->name('tables.export');
        Route::resource('categories', CategoryController::class);
        Route::post('categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('categories.bulkAction');
        Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
        Route::resource('menu-items', MenuItemController::class);
        Route::post('menu-items/bulk-action', [MenuItemController::class, 'bulkAction'])->name('menu-items.bulkAction');
        Route::post('menu-items/toggle-availability/{id}', [MenuItemController::class, 'toggleAvailability'])->name('menu-items.toggle-availability');
        Route::resource('reservations', AdminReservationController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('inventory', InventoryController::class);
        Route::resource('deliveries', DeliveryController::class);

        /*
        |--------------------------------------------------------------------------
        | ✅ ADMIN RESERVATION STATUS ROUTES (IMPORTANT FIX)
        |--------------------------------------------------------------------------
        */

        Route::post('reservations/{id}/update-status',
            [AdminReservationController::class, 'updateStatus']
        )->name('reservations.updateStatus');

        Route::post('reservations/{id}/cancel',
            [AdminReservationController::class, 'cancel']
        )->name('reservations.cancel');

        /*
        |--------------------------------------------------------------------------
        | Other Admin Routes
        |--------------------------------------------------------------------------
        */

        Route::post('deliveries/{delivery}/update-location',
            [DeliveryController::class, 'updateLocation']
        )->name('deliveries.updateLocation');

        Route::get('/attendance', [AdminAttendance::class, 'index'])
            ->name('attendance.index');

        Route::get('/leaves', [AdminLeaveController::class,'index'])
            ->name('leaves.index');

        Route::get('/leaves/approve/{id}', [AdminLeaveController::class,'approve'])
            ->name('leaves.approve');

        Route::get('/leaves/reject/{id}', [AdminLeaveController::class,'reject'])
            ->name('leaves.reject');

        Route::get('/salaries', [AdminSalaryController::class,'index'])
            ->name('salaries.index');

        Route::post('/salaries/store', [AdminSalaryController::class,'store'])
            ->name('salaries.store');

        Route::get('/salaries/paid/{id}', [AdminSalaryController::class,'markPaid'])
            ->name('salaries.paid');

        // Add missing salary edit, update, and destroy routes
        Route::get('/salaries/edit/{id}', [AdminSalaryController::class, 'edit'])
            ->name('salaries.edit');
        Route::post('/salaries/update/{id}', [AdminSalaryController::class, 'update'])
            ->name('salaries.update');
        Route::delete('/salaries/destroy/{id}', [AdminSalaryController::class, 'destroy'])
            ->name('salaries.destroy');
});

/*
|--------------------------------------------------------------------------
| STAFF ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/orders', [OrdersController::class, 'index'])
            ->name('orders');

        Route::get('/orders/active', [OrdersController::class, 'active'])
            ->name('orders.active');

        Route::post('/orders/update-status/{id}', [OrdersController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        Route::get('/reservations', [ReservationsController::class, 'index'])
            ->name('reservations');

        Route::post('/reservations/update/{id}', [ReservationsController::class, 'updateStatus'])
            ->name('reservations.update');

        Route::post('/reservations/cancel/{id}', [ReservationsController::class, 'cancel'])
            ->name('reservations.cancel');

        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile');

        Route::get('/profile/edit', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::post('/profile/update', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/attendance', [StaffAttendance::class, 'index'])
            ->name('attendance');

        Route::post('/attendance/mark', [StaffAttendance::class, 'mark'])
            ->name('attendance.mark');
        Route::post('/attendance/logout', [StaffAttendance::class, 'logoutAttendance'])
            ->name('attendance.logout');

        Route::get('/leaves', [StaffLeaveController::class,'index'])
            ->name('leaves');

        Route::post('/leaves/apply', [StaffLeaveController::class,'store'])
            ->name('leaves.apply');

        Route::get('/salaries', [StaffSalaryController::class,'index'])
            ->name('salaries.index');
});