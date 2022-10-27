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
use App\Http\Controllers\TeacherController;

use App\Http\Middleware\AuthCheck;

// Auth::routes();

Route::prefix('/api')->group(function () {
    Route::middleware(['auth:web','PreventBackHistory'])->group(function() {
        //get user info
        Route::get('/get_profile_info/{id}', [ProfileController::class, 'getProfileInfo']);
        Route::get('/get_education/{id}', [ProfileController::class, 'getEducation']);

        //profile image
        Route::post('/delete_image', [ProfileController::class, 'deleteImage']);
        Route::post('/upload', [ProfileController::class, 'upload']);

        //edit profile info
        Route::post('/edit_profile/{id}', [ProfileController::class, 'editProfile']);

        //create update profile info
        Route::post('/save_about/{id}', [ProfileController::class, 'about']);
        Route::post('/delete_about/{id}', [ProfileController::class, 'deleteAbout']);

        Route::post('/save_education/{id}', [ProfileController::class, 'education']);
        Route::post('/save_skills/{id}', [ProfileController::class, 'skills']);
        Route::post('/save_interests/{id}', [ProfileController::class, 'interests']);

        //search
        Route::get('/search', [HomeController::class, 'search']);

        //get people you may know
        Route::get('/get_all_user', [HomeController::class, 'getUserInfo']);
        
        //admin
        //add teacher
        // Route::post('/add_teacher', [ProfileController::class, 'addTeacher']);
        // Route::get('/get_teacher_info', [ProfileController::class, 'getTeacherInfo']);
        // Route::post('/edit_Teacher', [ProfileController::class, 'editTeacher']);
        // Route::post('/delete_Teacher', [ProfileController::class, 'deleteTeacher']);
        Route::resource('/teachers',  TeacherController::class);

        //for logout
        Route::get('/logout', [AuthController::class, 'logout']);

    });
    
});

Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
    //for register
    Route::post('/register_t', [AuthController::class, 'register_t']);
    Route::post('/register_s', [AuthController::class, 'register_s']);
    Route::post('/verify_email', [AuthController::class, 'verifyEmail']);

    //for login
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/submit_twoFactor_otp', [AuthController::class, 'submitTwoFactorCode']);

    //For Reset password
    Route::post('/send_reset_password_otp', [AuthController::class, 'sendResetPassOtp']);
    Route::post('/submit_reset_password_otp', [AuthController::class, 'submitResetPassOtp']);
    Route::post('/reset_password', [AuthController::class, 'resetPassword']);

});
Route::get('/',  [AuthController::class, 'index']);
Route::any('{slug}', [AuthController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)');
