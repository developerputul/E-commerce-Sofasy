<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard',[UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store',[UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout',[UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password',[UserController::class, 'UserUpdatePassword'])->name('user.update.password');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//Admin Dashboard All Route
Route::middleware(['auth','role:admin'])->group(function(){

    Route::get('/admin/dashboard',[AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout',[AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile',[AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store',[AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password',[AdminController::class, 'AdminChangepassword'])->name('admin.change.password');
    Route::post('/admin/update/password',[AdminController::class, 'AdminUpdatepassword'])->name('update.password');

}); //End Admin All Group Route

//Vendor Dashboard All Route
Route::middleware(['auth','role:vendor'])->group(function(){

    Route::get('/vendor/dashboard',[VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile',[VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile/store',[VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('/vendor/change/password',[VendorController::class, 'VendorChangepassword'])->name('vendor.change.password');
    Route::post('/vendor/update/password',[VendorController::class, 'VendorUpdatepassword'])->name('vendor.update.password');

});  //End Vendor All Group Route

Route::get('/admin/login',[AdminController::class, 'AdminLogin']);
Route::get('/vendor/login', [VendorController::class, 'VendorLogin']);