<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DokumenController;


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


Route::group(['middleware' => 'guest'], function() {
    Route::get('/', [AuthController::class, 'login']);
    Route::post('/', [AuthController::class, 'dologin']);

});


Route::group(['middleware' => ['auth', 'checkrole:1,2']], function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/redirect', [RedirectController::class, 'cek']);
});



Route::group(['middleware' => ['auth', 'checkrole:1']], function() {
    Route::get('/superadmin', [SuperadminController::class, 'index']);
    Route::get('/account', [AccountController::class, 'index']);
    Route::controller(DokumenController::class)->group(function(){
        Route::get('dokumen', 'index');
        Route::get('dokumen-export', 'export')->name('dokumen.export');
    });
    Route::resource('/dokumen-ajax-crud',DokumenController::class);
    Route::resource('/account-ajax-crud',AccountController::class);
});


Route::group(['middleware' => ['auth', 'checkrole:2']], function() {
    Route::get('/pegawai', [PegawaiController::class, 'index']);
    Route::controller(DokumenController::class)->group(function(){
        Route::get('document', 'index');
        Route::get('document-export', 'export')->name('document.export');
    });
    Route::resource('/document-ajax-crud',DokumenController::class);

});

Route::get('/register',[RegisterController::class, 'register']);

Route::post('/doregister', [RegisterController::class, 'doregister']);



