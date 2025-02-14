<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


$api_prefix = \App\Http\Controllers\Bz::getApiVer();


// Public routes 
\Illuminate\Support\Facades\Route::middleware([])->prefix($api_prefix)->group(function () {
    Route::post('login', [App\plugins\Api\Controllers\AuthApiController::class, 'login'])->name('api.login');
    Route::get('login', [App\plugins\Api\Controllers\AuthApiController::class, 'login_view'])->name('login');
    Route::any('logout', [App\plugins\Api\Controllers\AuthApiController::class, 'logoutAndDeleteToken'])->name('api.logout');

    // App user routes 
    $userAppApiPrefix = \App\Http\Controllers\Bz::getUserApiPrefix();
    Route::post("{$userAppApiPrefix}/email-signup", [App\plugins\Api\Controllers\AuthApiController::class, 'signupByEmail'])->name('api.user.signupByEmail');
    // End user routes 

    // reset password
    //Step-1 Send reset password code to user     
    Route::post('send-reset-password-code/{via}', [App\plugins\Api\Controllers\ResetPasswordApiController::class, 'send_reset_password_code'])->name('api.sendResetPasswordCode');
    // Step 2 Reset password via code
    Route::post('reset-password-via-code', [App\plugins\Api\Controllers\ResetPasswordApiController::class, 'reset_password_via_code'])->name('api.resetPasswordViaCode'); 
    
});
// End Public routes 



// After login routes for token based apis
\Illuminate\Support\Facades\Route::middleware(['auth:api'])->prefix($api_prefix)->group(function () {
    // My Account Details for user 
    $userAppApiPrefix = \App\Http\Controllers\Bz::getUserApiPrefix();

    // get profile \details 
    Route::post("{$userAppApiPrefix}/profile-details", [App\plugins\Api\Controllers\AuthApiController::class, 'getUserDetails'])->name('api.user.getUserDetails');

    // Update user pofile, updateSelfProfile: this is used in admin side also
    Route::post("{$userAppApiPrefix}/profile-update", [\App\Http\Controllers\Admin\Auth\Auth::class, 'updateSelfProfile'])->name('api.user.updateUserProfile');

    // updateProfileImage
    Route::post("{$userAppApiPrefix}/profile-image-update", [\App\Http\Controllers\Admin\Auth\Auth::class, 'updateProfileImage'])->name('api.user.updateProfileImage');
    
    // Update password in user profile
    // update_password_req: This function is used in admin side also if need to made few changes based on user profile make a copy if that
    Route::post("{$userAppApiPrefix}/update-password", [\App\Http\Controllers\Admin\Auth\Auth::class, 'update_password_req'])->name('api.user.updatePassReq');


    // Delete user profile from system 
    Route::post("{$userAppApiPrefix}/profile-delete", [\App\plugins\Api\Controllers\AuthApiController::class, 'selfProfileDelete'])->name('api.user.deleteProfile');
    
    // End My Account Details for user 

});


// Api for admin use 
\Illuminate\Support\Facades\Route::middleware(['isLogin', 'checkRole'])->prefix("admin")->group(function () {

    // for user search select 2
    Route::post('users/search', [\App\plugins\Api\Controllers\UserApiController::class, 'searchUsersForDropdown'])->name('api.user.select.search');

    // Manage media ajax 
    Route::post('media/upload', [\App\plugins\Api\Controllers\MediaApiController::class, 'uploadMediaFiles'])->name('admin.media.uploadMediaFiles');
    Route::post('media/delete', [\App\plugins\Api\Controllers\MediaApiController::class, 'tc_delete_media_items_callback'])->name('admin.media.delete.item');
    Route::post('media/list', [\App\plugins\Api\Controllers\MediaApiController::class, 'tc_get_media_for_admin_callback'])->name('admin.media.getList');
    Route::post('media/update-item', [\App\plugins\Api\Controllers\MediaApiController::class, 'tc_rename_media_item_callback'])->name('admin.media.update.item');
    Route::post('media/update-item', [\App\plugins\Api\Controllers\MediaApiController::class, 'tc_update_media_item_status_callback'])->name('admin.media.updateStatus.item');
    // Directory Manage
    Route::post('media/create-directory', [\App\plugins\Api\Controllers\MediaApiController::class, 'tc_create_update_directory_callback'])->name('api.media.dir.create');
});
