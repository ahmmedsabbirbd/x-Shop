<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmailCampaignController;
use App\Http\Middleware\TokenVerificationMiddleware;
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

// Page Routes
Route::get('/userLogin',[UserController::class,'LoginPage'])->name('login');
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/dashboard-image',[UserController::class,'DashBoardImage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/promotionalPage',[EmailCampaignController::class,'PromotionalPage'])->middleware([TokenVerificationMiddleware::class]);

// API Routes

// User Profile
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-send-otp-to-email', [UserController::class, 'UserSendOTPToEmail']);
Route::post('/otp-verify', [UserController::class, 'OTPVerify']);
Route::post('/set-password', [UserController::class, 'SetPassword'])->middleware(TokenVerificationMiddleware::class);
Route::get('/profile-details', [UserController::class, 'profileDetails'])->middleware(TokenVerificationMiddleware::class);
Route::post('/profile-update', [UserController::class, 'profileUpdate'])->middleware(TokenVerificationMiddleware::class);

// Logout
Route::get('/logout',[UserController::class,'userLogout'])->middleware(TokenVerificationMiddleware::class);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware(TokenVerificationMiddleware::class);

// Login With facebook
Route::get( 'auth/facebook', [SocialiteController::class, 'facebookRedirect'] )->name( 'facebook.login' );
Route::get( 'auth/facebook/callback', [SocialiteController::class, 'facebookCallback'] );
// Login With google
Route::get( 'auth/google', [SocialiteController::class, 'googleRedirect'] )->name( 'google.login' );
Route::get( 'auth/google/callback', [SocialiteController::class, 'googleCallback'] );

//Route::get( '/{slug}', [PageController::class, 'show_custom_page'] );


// Customer API
Route::get('/customer-list',[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-create',[CustomerController::class,'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-update',[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-by-id',[CustomerController::class,'CustomerById'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/customer-delete',[CustomerController::class,'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);

// Email Campaign API
Route::post('/email-campaign',[EmailCampaignController::class,'SendEmailCampaign'])->middleware([TokenVerificationMiddleware::class]);
