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
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConnectionController;

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MessageController;

use App\Http\Middleware\AuthCheck;

// Auth::routes();

Route::prefix('/api')->group(function () {
    Route::middleware(['authCheck','PreventBackHistory'])->group(function() {
        //get user info
        Route::get('/get_profile_header_info/{slug}', [ProfileController::class, 'getProfileHeaderInfo']);
        Route::get('/get_profile_info/{slug}', [ProfileController::class, 'getProfileInfo']);
        Route::get('/get_user', [ProfileController::class, 'getUser']);

        //profile image
        Route::post('/delete_profile_image', [ProfileController::class, 'deleteImage']);
        Route::post('/upload_profile_image', [ProfileController::class, 'upload']);

        //edit profile info
        Route::post('/edit_profile', [ProfileController::class, 'updateProfile']);

        //create update profile info
        Route::post('/update_about', [ProfileController::class, 'updateAbout']);
        Route::post('/delete_about', [ProfileController::class, 'deleteAbout']);

        //Education
        Route::post('/save_education', [ProfileController::class, 'saveEducation']);
        Route::post('/update_education', [ProfileController::class, 'updateEducation']);
        Route::post('/delete_education',[ProfileController::class,'deleteEducation']);

        // skills
        Route::get('/search_skills', [ProfileController::class, 'searchSkills']);
        Route::get('/get_skills', [ProfileController::class, 'getSkills']);
        Route::post('/save_skills', [ProfileController::class, 'saveSkills']);
        Route::post('/update_skills', [ProfileController::class, 'updateSkills']);

        Route::post('/get_auth_user_info', [ProfileController::class, 'getAuthUserInfo']);
        Route::post('/save_interests/{id}', [ProfileController::class, 'interests']);
        Route::get('/get_user_research', [ProfileController::class, 'getUserResearch']);
        Route::get('/get_user_project/{slug}', [ProfileController::class, 'getUserProject']);
        Route::get('/get_user_post/{slug}', [ProfileController::class, 'getUserPost']);
        
        //Attachment
        Route::post('/upload_attachment', [PostController::class, 'uploadAttachment']);
        Route::post('/delete_attachment', [PostController::class, 'deleteAttachment']);
        //image
        Route::post('/delete_image', [PostController::class, 'deleteImage']);
        Route::post('/upload', [PostController::class, 'upload']);
        //save post
        Route::post('/save_post', [PostController::class, 'savePost']);
        // Route::get('/view_attachment/{id}', [PostController::class, 'viewAttachment']);
        Route::post('/update_post', [PostController::class, 'updatePost']);
        Route::post('/delete_post', [PostController::class, 'deletePost']);
        Route::post('/up_vote', [PostController::class, 'upVote']);
        Route::post('/down_vote', [PostController::class, 'downVote']);
        Route::post('/read/{id}', [PostController::class, 'read']);
        Route::post('/like', [PostController::class, 'like']);
        //get post
        Route::get('/get_all_post', [PostController::class, 'getAllPost']);
        Route::get('/post_details/{slug}', [PostController::class, 'postDetails']);
        Route::get('/post_abstract/{slug}', [PostController::class, 'postAbstract']);
        Route::get('/get_liked_user', [PostController::class, 'getLikedUser']);
        Route::get('/download_attachment/{url}', [PostController::class, 'downloadAttachment']);
        Route::get('/get_related_research', [ResearchController::class, 'getRelatedResearch']);

        //research
        Route::get('/get_all_research', [ResearchController::class, 'getAllResearch']);

        //Comments
        Route::get('/get_comments/{slug}', [CommentController::class, 'getComments']);
        Route::post('/add_comment', [CommentController::class, 'addComment']);
        Route::post('/comment_like', [CommentController::class, 'commentLike']);
        Route::get('/get_comment_liked_user', [CommentController::class, 'getCommentLikedUser']);

        Route::post('/add_comment_reply', [CommentController::class, 'addCommentReply']);
        Route::get('/get_comment_replies', [CommentController::class, 'getCommentReplies']);
        Route::post('/comment_reply_like', [CommentController::class, 'commentReplyLike']);
        Route::get('/get_comment_reply_liked_user', [CommentController::class, 'getCommentReplyLikedUser']);

        //Notification
        Route::get('/get_notification', [NotificationController::class, 'getNotification']);
        Route::get('/get_notification_count', [NotificationController::class, 'getNotificationCount']);
        Route::get('/mark_as_read/{id}', [NotificationController::class, 'markAsRead']);
        Route::post('/mark_as_seen', [NotificationController::class, 'markAsSeen']);
        Route::get('/get_read_notification', [NotificationController::class, 'getReadNotification']);
        Route::get('/get_unread_notification', [NotificationController::class, 'getUnreadNotification']);
        Route::get('/get_request_notification', [NotificationController::class, 'getRequestNotification']);
        
        //Connection
        Route::post('/add_connection', [ConnectionController::class, 'addConnection']);
        Route::post('/get_connection', [ConnectionController::class, 'getConnection']);
        Route::get('/connection_status', [ConnectionController::class, 'connectionStatus']);
        Route::post('/accept_connection', [ConnectionController::class, 'acceptConnection']);
        Route::post('/ignore_connection', [ConnectionController::class, 'ignoreConnection']);
        Route::get('/get_user_connection', [ConnectionController::class, 'getUserConnection']);
        Route::get('/get_auth_user_connection', [ConnectionController::class, 'getAuthUserConnection']);
        Route::get('/get_connection_request', [ConnectionController::class, 'getConnectionRequest']);

        //search
        Route::get('/search', [HomeController::class, 'search']);

        //get people you may know
        Route::get('/get_people_you_may_know', [HomeController::class, 'getPeopleYouMayKnow']);
        
        //Message
        Route::get('/get_conversation', [MessageController::class, 'getConversation']);
        Route::post('/add_conversation', [MessageController::class, 'addConversation']);
        Route::get('/get_chat', [MessageController::class, 'getSelectedUserChat']);
        Route::post('/add_chat', [MessageController::class, 'addSelectedUserChat']);

        //admin
        //add teacher
        Route::get('/get_teachers',[TeacherController::class, 'GetTeachers']);
        Route::post('/add_teacher',[TeacherController::class,'AddTeacher']);
        Route::post('/teachers_update',[TeacherController::class,'TeacherUpdate']);
        Route::post('/teachers_del',[TeacherController::class,'TeacherDel']);

        //get departments
        Route::get('/get_departments', [HomeController::class, 'getDepartments']);

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
    
        //For Reset password
        Route::post('/send_reset_password_otp', [AuthController::class, 'sendResetPassOtp']);
        Route::post('/submit_reset_password_otp', [AuthController::class, 'submitResetPassOtp']);
        Route::post('/reset_password', [AuthController::class, 'resetPassword']);
        
        Route::get('/get_all_research', [ResearchController::class, 'getAllResearch']);
        Route::get('/get_departments', [HomeController::class, 'getDepartments']);
        Route::get('/post_details/{slug}', [PostController::class, 'postDetails']);
    
    });
});

Route::get('/',  [AuthController::class, 'index']);
Route::any('{slug}', [AuthController::class, 'index'])->where('slug', '([A-z\d\-\/_.]+)');
