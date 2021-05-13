<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(
    [
        'middleware' => 'auth',
//        'prefix' => 'admin' //Добавляет префик к каждому маршруту в данном случае
        //  Route::resource('page', 'Admin\PageController'); равняется  Route::resource('admin/page', 'Admin\PageController');
    ]
    , function () {


    Route::resource('bike', \App\Http\Controllers\BikeController::class);
    Route::resource('online-appointment', \App\Http\Controllers\OnlineAppointmentController::class);

});


