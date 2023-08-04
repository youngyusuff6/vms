<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\General_Notification;
use App\Http\Controllers\Dashboard\Resident\ResidentProfileController;
use App\Http\Controllers\Dashboard\Resident\ResidentVisitorController;
use App\Http\Controllers\Dashboard\Security\SecurityProfileController;
use App\Http\Controllers\Dashboard\Security\SecurityVisitorController;
use App\Http\Controllers\Dashboard\Resident\ResidentDashboardController;
use App\Http\Controllers\Dashboard\Security\SecurityDashboardController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PublicController::class, 'index'])->name('home');
// Authentication Routes
Auth::routes();
Route::get('/security/register', [PublicController::class, 'register'])->name('regsec');

Route::group(['middleware' => 'admin'], function () {
    // Admin routes
});


Route::group(['middleware' => 'security'], function () {
    Route::get('/security/dashboard', [SecurityDashboardController::class, 'index'])->name('security.dashboard');
    // PROFILE ROUTES
    Route::get('/security/profile', [SecurityProfileController::class, 'index'])->name('security.profile');
    Route::get('/security/edit/profile', [SecurityProfileController::class, 'get_update_profile'])->name('security.profile.edit');
    Route::post('/security/profile/update', [SecurityProfileController::class, 'update_profile'])->name('security.profile.update');
    //VISITORS ROUTES
    Route::get('/security/visitor/register', [SecurityVisitorController::class, 'register'])->name('security.visitor.register');
    Route::post('/security/visitor/registeration', [SecurityVisitorController::class, 'registeration'])->name('security.visitor.registeration');
    Route::get('/security/visitor/log', [SecurityVisitorController::class, 'log'])->name('security.visitor.log');
    //VISITORS VALIDATION
    Route::post('/security/visitor/validate', [SecurityVisitorController::class, 'postValidation'])->name('security.visitor.validated');
    Route::get('/security/visitor/validation', [SecurityVisitorController::class, 'getValidation'])->name('security.visitor.validate');
    Route::get('/security/general/notification/viewer/{pg1}',  [General_Notification::class, "Notifications"])->name('general.notification.viewer');
    Route::post('/security/visitor/signout/{id}', [SecurityVisitorController::class, 'signout'])->name('security.visitor.signout');


});


Route::group(['middleware' => 'resident'], function () {
    Route::get('/resident/dashboard', [ResidentDashboardController::class, 'index'])->name('resident.dashboard');
    // PROFILE ROUTES
    Route::get('/resident/profile', [ResidentProfileController::class, 'index'])->name('resident.profile');
    Route::get('/resident/edit/profile', [ResidentProfileController::class, 'get_update_profile'])->name('resident.profile.edit');
    Route::post('/resident/profile/update', [ResidentProfileController::class, 'update_profile'])->name('resident.profile.update');
    Route::post('resident/profile/image/uploader', [ResidentProfileController::class, 'uploadImage'])->name('resident.profile.image.uploader');
    //VISITORS ROUTES
    Route::get('/resident/visitor/register', [ResidentVisitorController::class, 'register'])->name('resident.visitor.register');
    Route::post('/resident/visitor/registeration', [ResidentVisitorController::class, 'registeration'])->name('resident.visitor.registeration');
    Route::get('/resident/visitor/log', [ResidentVisitorController::class, 'log'])->name('resident.visitor.log');
    //VALIDATE VISITORS
    Route::get('/resident/visitor/validation', [ResidentVisitorController::class, 'dispValidation'])->name('resident.visitor.validation');
    Route::get('/resident/visitor/validate/{id}', [ResidentVisitorController::class, 'validate'])->name('resident.visitor.validate');
    Route::post('/resident/visitor/accept/{id}', [ResidentVisitorController::class, 'accept'])->name('resident.visitor.accept');
    Route::post('/resident/visitor/reject/{id}', [ResidentVisitorController::class, 'reject'])->name('resident.visitor.reject');
    //NOTIFICATION
    Route::get('/resident/general/notification/viewer/{pg1}',  [General_Notification::class, "Notifications"])->name('general.notification.viewers');
   
    
    


    
});
Route::group( ['middleware' => ['auth','backHistory' ]], function(){
   // Route::get('/general/profile/unique/viewers/{pg1}', [General_Profile_Viewers::class, "Profile_Viewers"])->name('profile.unique.viewers');
    //Route::get('/general/notification/viewer/{pg1}', [General_Notification::class, "Notifications"])->name('general.notification.viewer');
    //Route::get('/general/notification/{token}/{notification_token}', [General_Notification::class, "delete_notification"])->name('notification.delete');
});