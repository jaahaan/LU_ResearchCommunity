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
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\TeacherController;

use App\Http\Middleware\AuthCheck;

// Auth::routes();

Route::prefix('/api')->group(function () {
    Route::middleware(['authCheck','PreventBackHistory'])->group(function() {
        //get user info
        Route::get('/get_profile_info/{id}', [ProfileController::class, 'getProfileInfo']);
        Route::get('/get_education/{id}', [ProfileController::class, 'getEducation']);

        //profile image
        Route::post('/delete_image', [ProfileController::class, 'deleteImage']);
        Route::post('/upload', [ProfileController::class, 'upload']);

        //edit profile info
        Route::post('/edit_profile/{id}', [ProfileController::class, 'updateProfile']);

        //create update profile info
        Route::post('/save_about/{id}', [ProfileController::class, 'about']);
        Route::post('/delete_about/{id}', [ProfileController::class, 'deleteAbout']);
        Route::post('/save_education/{id}', [ProfileController::class, 'education']);
        Route::post('/save_skills/{id}', [ProfileController::class, 'skills']);
        Route::post('/save_interests/{id}', [ProfileController::class, 'interests']);


        //Post
        Route::get('/get_user_post/{id}', [PostController::class, 'getUserPost']);
        Route::get('/get_all_post', [PostController::class, 'getAllPost']);
        Route::post('/save_post/{id}', [PostController::class, 'savePost']);
        Route::post('/upload_attachment', [PostController::class, 'uploadAttachment']);
        Route::post('/delete_attachment', [PostController::class, 'deleteAttachment']);
        // Route::get('/download_attachment/{url}', [PostController::class, 'downloadAttachment']);
        // Route::get('/view_attachment/{id}', [PostController::class, 'viewAttachment']);
        Route::post('/update_post', [PostController::class, 'updatePost']);
        Route::post('/delete_post', [PostController::class, 'deletePost']);
        Route::get('/post_details/{slug}', [PostController::class, 'postDetails']);
        // Route::get('/post_abstract/{slug}', [PostController::class, 'postAbstract']);

        Route::post('/up_vote', [PostController::class, 'upVote']);
        Route::post('/down_vote', [PostController::class, 'downVote']);
        Route::post('/read/{id}', [PostController::class, 'read']);
        Route::post('/like', [PostController::class, 'like']);

        //Comments
        Route::get('/get_comments/{slug}', [CommentController::class, 'getComments']);
        Route::post('/add_comment', [CommentController::class, 'addComment']);
        Route::post('/comment_like', [CommentController::class, 'commentLike']);

        //search
        Route::get('/search', [HomeController::class, 'search']);

        //get departments
        Route::get('/get_departments', [HomeController::class, 'getDepartments']);

        //get people you may know
        Route::get('/get_all_user', [HomeController::class, 'getUserInfo']);
        
        //admin
        //add teacher
        Route::resource('/teachers',TeacherController::class);
        Route::post('/teachers_update',[TeacherController::class,'TeacherUpdate']);
        Route::post('/teachers_del',[TeacherController::class,'TeacherDel']);


        //for logout
        Route::get('/logout', [AuthController::class, 'logout']);


        // //create project
        // Route::get('/get_project/{id}', [ProfileController::class, 'getProject']);
        // Route::post('/save_project/{id}', [ProfileController::class, 'saveProject']);
        // Route::post('/update_project', [ProfileController::class, 'updateProject']);
        // Route::post('/delete_project/{id}', [ProfileController::class, 'deleteProject']);

    });
    
});

Route::middleware(['PreventBackHistory'])->group(function(){
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

Route::prefix('/api')->group(function () {
    Route::middleware(['PreventBackHistory'])->group(function(){
        //for register
        Route::post('/register_t', [AuthController::class, 'register_t']);
        Route::post('/register_s', [AuthController::class, 'register_s']);
        Route::post('/verify_email', [AuthController::class, 'verifyEmail']);
    
        //for login
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/submit_twoFactor_otp', [AuthController::class, 'submitTwoFactorCode']);
    
        Route::post('/api/login', [AuthController::class, 'login']);
        Route::post('/api/submit_twoFactor_otp', [AuthController::class, 'submitTwoFactorCode']);
        //For Reset password
        Route::post('/send_reset_password_otp', [AuthController::class, 'sendResetPassOtp']);
        Route::post('/submit_reset_password_otp', [AuthController::class, 'submitResetPassOtp']);
        Route::post('/reset_password', [AuthController::class, 'resetPassword']);
    
    });
});

Route::get('/',  [AuthController::class, 'index']);
Route::any('{slug}', [AuthController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)');
