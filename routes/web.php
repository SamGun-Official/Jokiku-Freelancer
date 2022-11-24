<?php

use App\Http\Controllers\Admin\BanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use Illuminate\Support\Facades\Route;

// front ( landing)
use App\Http\Controllers\Landing\LandingController;

// member ( dashboard )
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

Route::get('detail_booking/{id}', [LandingController::class, 'detail_booking'])->name('detail.booking.landing');
Route::get('booking/{id}', [LandingController::class, 'booking'])->name('booking.landing');
Route::get('detail/{id}', [LandingController::class, 'detail'])->name('detail.landing');
Route::get('explore', [LandingController::class, 'explore'])->name('explore.landing');
Route::resource('/', LandingController::class);


Route::group(['prefix' => 'member', 'as' => 'member.', 'middleware' => ['auth:sanctum', 'verified', 'role:user']], function () {
    // dashboard
    Route::resource('dashboard', MemberController::class);

    // service
    Route::resource('service', ServiceController::class);

    // request
    Route::get('approve_request/{id}', [RequestController::class, 'approve'])->name('approve.request');
    Route::resource('request', RequestController::class);
    Route::get('request/{id}/rating',[RequestController::class,'rating'])->name('request.rating');
    Route::post('request/{id}/rating/submit',[RequestController::class,'rating_submit'])->name('request.rating.submit');

    // my order
    Route::get('accept/order/{id}', [MyOrderController::class, 'accepted'])->name('accept.order');
    Route::get('reject/order/{id}', [MyOrderController::class, 'rejected'])->name('reject.order');
    Route::resource('order', MyOrderController::class);

    // profile
    Route::get('delete_photo', [ProfileController::class, 'delete'])->name('delete.photo.profile');
    Route::resource('profile', ProfileController::class);
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:sanctum', 'verified', 'role:admin']], function () {
    // dashboard
    Route::resource('dashboard', DashboardController::class);
    Route::resource('user', BanController::class);
    Route::resource('report', ReportController::class);
    Route::resource('service', AdminServiceController::class);

    Route::get('accept/service/{id}', [AdminServiceController::class, 'approve'])->name('approve.service');
    Route::get('reject/service/{id}', [AdminServiceController::class, 'reject'])->name('reject.service');

    Route::get('downloadReport', [ReportController::class, 'downloadReport'])->name('downloadReport');

});


Route::get('/email/verify', function () {
    if (auth()->user()->email_verified_at != null){
        return redirect()->route('member.dashboard.index');
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });
