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
use App\Http\Middleware\AuthCheck;

Route::prefix('/api')->middleware([AuthCheck::class])->group(function () {
    Route::get('/get_profile_info/{id}', [HomeController::class, 'getProfileInfo']);
    Route::post('/delete_image', [HomeController::class, 'deleteImage']);
    Route::post('/upload', [HomeController::class, 'upload']);
    Route::post('/edit_profile/{id}', [HomeController::class, 'editProfile']);
    Route::post('/save_about/{id}', [HomeController::class, 'about']);
    Route::post('/save_skills/{id}', [HomeController::class, 'skills']);

});

Route::get('/logout', [HomeController::class, 'logout']);
Route::post('register_t', [HomeController::class, 'register_t']);
Route::post('register_s', [HomeController::class, 'register_s']);
Route::post('login', [HomeController::class, 'login']);

Route::get('/',  [HomeController::class, 'index']);

Route::any('{slug}', [HomeController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)');
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

// Route::post('/home/upload/images',  [HomeController::class, 'uploadImages']);

// Route::get('/product/{slug}',  [ProductController::class, 'index']);
// Route::get('/a007',  [HomeController::class, 'admin']);
