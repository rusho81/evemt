<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Middleware\TokenVarificationMiddleware;

//Frontend

Route::get('/',[FrontController::class, 'FrontPage']);
Route::get('/list-event',[FrontController::class, 'ListPost']);

//API Route
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
Route::post('/reset-password', [UserController::class, 'ResetPassword'])
->middleware([TokenVarificationMiddleware::class]);

Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware([TokenVarificationMiddleware::class]);
Route::post('/user-update', [UserController::class, 'UpdateProfile'])->middleware([TokenVarificationMiddleware::class]);

//logout
Route::get('/logout',[UserController::class, 'UserLogout']);


//Page Route
Route::get('/userLogin',[UserController::class, 'LoginPage']);
Route::get('/userRegistration',[UserController::class, 'RegistrationPage']);
Route::get('/sendOtp',[UserController::class, 'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class, 'VerifyOtpPage']);
Route::get('/resetPassword',[UserController::class, 'ResetPasswordPage'])->middleware([TokenVarificationMiddleware::class]);
Route::get('/dashboard',[DashboardController::class, 'DashboardPage'])->middleware([TokenVarificationMiddleware::class]);
Route::get('/userProfile',[UserController::class, 'ProfilePage'])->middleware([TokenVarificationMiddleware::class]);

 Route::get('/eventPage',[EventController::class, 'EventPage'])->middleware([TokenVarificationMiddleware::class]);

//Event API Route
Route::post('/create-event',[EventController::class, 'EventCreate'])->middleware([TokenVarificationMiddleware::class]);
Route::post('/delete-event',[EventController::class, 'EventDelete'])->middleware([TokenVarificationMiddleware::class]);
Route::get('/list-event',[EventController::class, 'EventList'])->middleware([TokenVarificationMiddleware::class]);
Route::post('/update-event',[EventController::class, 'EventUpdate'])->middleware([TokenVarificationMiddleware::class]);
Route::post('/event-by-id',[EventController::class, 'EventById'])->middleware([TokenVarificationMiddleware::class]);