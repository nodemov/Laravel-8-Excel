<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/imports', [App\Http\Controllers\UsersController::class, 'usersImport'])->name('import'); // working OK
Route::get('/exports', [App\Http\Controllers\UsersController::class, 'export']);

