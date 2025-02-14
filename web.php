<?php
// Public routes
\Illuminate\Support\Facades\Route::middleware([])->group(function () {
    $userAppApiPrefix =  'user';
    
    // Verify email address via email link
    \Illuminate\Support\Facades\Route::get("{$userAppApiPrefix}/verify-email/{hash}", [App\plugins\Api\Controllers\AuthApiController::class, 'verifyEmailViaLink'])->name('api.user.verifyEmailViaLink');
});
// End Public routes

// show private files
\Illuminate\Support\Facades\Route::any('media/files/{path}', [\App\plugins\Api\Controllers\MediaApiController::class, 'tc_display_private_files'])->name('api.media.displayPrivateMedia')
    ->where('path', '.*');
