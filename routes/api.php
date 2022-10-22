<?php

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
/**************************Auth************************************* */

use App\Http\Controllers\API\Auth\AccountRecoveryController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\CheckCodeController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\PropertyRightController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Route;

// define('successes',trans('messages.Operation has been successfully'));
Route::get('/auth', [LoginController::class, 'authLogin'])
                ->name('auth-login');
//process : reg, login
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/check-code-register/{rand}', [RegisterController::class, 'checkCodeRegister']);

Route::post('/resend-code/{rand}', [RegisterController::class, 'resendCode']);

Route::post('/login', [LoginController::class, 'login']);
//opertaion reset pass
Route::post('password/forgot',  ForgotPasswordController::class);//to send  entered into phone_no entered
Route::post('password/code/check/{rand}', CheckCodeController::class);////to check code entered (that sent into email) with the code that it  sent into email
Route::post('password/reset/{rand}', ResetPasswordController::class);// to make reset pass this user through password entered now



Route::get('get-user', [LoginController::class,'getUserToken']);
//logout
Route::middleware(['auth:api'])->group(function(){
    Route::get('/logout', [LoginController::class, 'destroy'])
                    ->name('api-llogout');
});



//Lang

Route::get('lang/{lang}', ['as' => 'lang.switch.api', 'uses' => 'App\Http\Controllers\API\LanguageController@switchLang']);
Route::get('get-all-langs', ['as' => 'lang.langs.api', 'uses' => 'App\Http\Controllers\API\LanguageController@getAllLangs']);
Route::get('default-lang', ['as' => 'lang.default-lang.api', 'uses' => 'App\Http\Controllers\API\LanguageController@defaultLang']);
