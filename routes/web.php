<?php

// Admin
use App\Http\Controllers\Admin\BanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use Illuminate\Support\Facades\Route;

// Front (Landing)
use App\Http\Controllers\Landing\LandingController;

// Member
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\RequestController;
use App\Http\Controllers\Dashboard\MyOrderController;
use App\Http\Controllers\Dashboard\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/', LandingController::class);
Route::get('explore', [LandingController::class, 'explore'])->name('explore.landing');
Route::get('detail/{id}', [LandingController::class, 'detail'])->name('detail.landing');
Route::get('booking/{id}', [LandingController::class, 'booking'])->name('booking.landing');
Route::get('detail_booking/{id}', [LandingController::class, 'detail_booking'])->name('detail.booking.landing');

Route::group(['prefix' => 'member', 'as' => 'member.', 'middleware' => ['auth:sanctum', 'verified', 'role:user']], function () {
    // Dashboard
    Route::resource('dashboard', MemberController::class);

    // Service
    Route::resource('service', ServiceController::class);

    // Request
    Route::resource('request', RequestController::class);
    Route::post('approve_request/{id}', [RequestController::class, 'approve'])->name('approve.request');
    Route::get('request/{id}/rating', [RequestController::class, 'rating'])->name('request.rating');
    Route::post('request/{id}/rating/submit', [RequestController::class, 'rating_submit'])->name('request.rating.submit');

    // Order
    Route::resource('order', MyOrderController::class);
    Route::get('accept/order/{id}', [MyOrderController::class, 'accepted'])->name('accept.order');
    Route::get('reject/order/{id}', [MyOrderController::class, 'rejected'])->name('reject.order');

    // Profile
    Route::resource('profile', ProfileController::class);
    Route::get('delete_photo', [ProfileController::class, 'delete'])->name('delete.photo.profile');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:sanctum', 'verified', 'role:admin']], function () {
    // Dashboard
    Route::resource('dashboard', DashboardController::class);
    Route::resource('user', BanController::class);

    // Report
    Route::resource('report', ReportController::class);
    Route::get('downloadReport', [ReportController::class, 'downloadReport'])->name('downloadReport');

    // Service
    Route::resource('service', AdminServiceController::class);
    Route::get('accept/service/{id}', [AdminServiceController::class, 'approve'])->name('approve.service');
    Route::get('reject/service/{id}', [AdminServiceController::class, 'reject'])->name('reject.service');

    // Profile
    Route::resource('profile', ProfileAdminController::class);
    Route::get('delete_photo', [ProfileAdminController::class, 'delete'])->name('delete.photo.profile');
});

Route::get('/email/verify', function () {
    if (auth()->user()->email_verified_at != null) {
        return redirect()->route('member.dashboard.index');
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
