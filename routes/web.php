<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/', function () {
    // return view('welcome');
   return redirect()->route('filament.admin.auth.login');
   
});

Route::get('clear-cache',function(){
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:clear');
    $run = Artisan::call('config:cache');

    return redirect()->route('filament.admin.pages.dashboard');
})->name('filament.clear.cache');