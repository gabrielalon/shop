<?php

use App\UI\Web\Index;
use App\UI\Web\WelcomeHandler;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/'.locale()->current(), 301);
Route::redirect('/admin', '/admin/login', 301);

Route::prefix('{locale}')->group(function () {
    Route::get('/', WelcomeHandler::class)->name('welcome');
    Route::get('/home', Index\IndexHandler::class)->name('home');
});
