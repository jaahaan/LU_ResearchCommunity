<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AuthCheck;

Route::prefix('/api')->middleware([AuthCheck::class])->group(function () {
    Route::get('/get_profile_info/{id}', [ProfileController::class, 'getProfileInfo']);
    Route::get('/get_education/{id}', [ProfileController::class, 'getEducation']);

    Route::post('/delete_image', [ProfileController::class, 'deleteImage']);
    Route::post('/upload', [ProfileController::class, 'upload']);
    Route::post('/edit_profile/{id}', [ProfileController::class, 'editProfile']);
    Route::post('/save_about/{id}', [ProfileController::class, 'about']);
    Route::post('/save_education/{id}', [ProfileController::class, 'education']);
    Route::post('/save_skills/{id}', [ProfileController::class, 'skills']);
    Route::post('/save_interests/{id}', [ProfileController::class, 'interests']);

    Route::get('/search', [HomeController::class, 'search']);

});

Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/register_t', [AuthController::class, 'register_t']);
Route::post('/register_s', [AuthController::class, 'register_s']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/submit_twoFactor_otp', [AuthController::class, 'submitTwoFactorCode']);
Route::post('/verify_email', [AuthController::class, 'verifyEmail']);
Route::get('/get_info/{email}', [ProfileController::class, 'getInfo']);

Route::post('/send_otp', [AuthController::class, 'sendOtp']);
Route::get('/reset_password', [AuthController::class, 'showResetForm']);
Route::post('/submit_otp', [AuthController::class, 'submitOtp']);
Route::post('/reset_password', [AuthController::class, 'resetPassword']);

Route::get('/',  [AuthController::class, 'index']);

Route::any('{slug}', [AuthController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)');
// Route::prefix('api')->group(function () {
// // Route::prefix('api/users')->group(function () {
//
//     Route::get('/categories/getAll',  [CategoryController::class, 'getAll']);
//
//
//     // Auth Routes
//     Route::post('/auth/registration',[UserController::class, 'register']);
//     Route::post('/auth/login',[UserController::class, 'login']);
//     Route::post('/auth/user/edit',[UserController::class, 'updateUser']);
//     Route::post('/auth/activeAccount',[UserController::class, 'activeAccount']);
//     Route::post('/auth/sendActivationCode',[UserController::class, 'sendActivationCode']);
//     Route::get('/auth/getCustomer',[UserController::class, 'getCustomer']);
//
//     // Password Reset
//     Route::post('/auth/sendResetMessage',[UserController::class, 'sendResetMessage']);
//     Route::post('/auth/getResetMessage',[UserController::class, 'getResetMessage']);
//     Route::post('/auth/reset-password',[UserController::class, 'resetPassword']);
//
//
//     // Products
//     Route::get('/product/variations/{id}',[ProductController::class, 'variations']);
//     Route::get('/product/setupData/{id}',[ProductController::class, 'setupData']);
//     Route::get('/product/similar/{id}',[ProductController::class, 'similar']);
//
//     //cart
//     Route::get('/cart/getAll',[CartController::class, 'getAll'])->middleware('auth');
//     Route::post('/cart/add',[CartController::class, 'add'])->middleware('auth');
//     Route::post('/cart/remove',[CartController::class, 'remove'])->middleware('auth');
//     Route::post('/cart/removeAll',[CartController::class, 'removeAll'])->middleware('auth');
//
//     // delivery-option
//     Route::get('/delivery-option/getAll',[CartController::class, 'getDeliveryOptions']);
//
//     //cart
//     Route::get('/addressbook/getAll',[AddressBookController::class, 'getAll'])->middleware('auth');
//     Route::get('/addressbook/get/{id}',[AddressBookController::class, 'index'])->middleware('auth');
//     Route::post('/addressbook/add',[AddressBookController::class, 'add'])->middleware('auth');
//     Route::post('/addressbook/edit',[AddressBookController::class, 'edit'])->middleware('auth');
//     Route::post('/addressbook/editBilling',[AddressBookController::class, 'editBilling'])->middleware('auth');
//     Route::post('/addressbook/remove/{id}',[AddressBookController::class, 'remove'])->middleware('auth');
//     Route::post('/addressbook/removeAll',[AddressBookController::class, 'removeAll'])->middleware('auth');
// });

// Route::post('/home/upload/images',  [AuthController::class, 'uploadImages']);

// Route::get('/product/{slug}',  [ProductController::class, 'index']);
// Route::get('/a007',  [AuthController::class, 'admin']);
