<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tests;
use App\Http\Controllers\Auth\Sessions;
use App\Http\Controllers\Auth\Registers;
use App\Http\Controllers\Conversations;
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

Route::resource('test', Tests::class);

Route::get('/', function () {
    return redirect()->route('auth.sessions.create'); // Замените '/new-page' на путь, на который вы хотите перенаправить
});

Route::prefix('/auth')->middleware('guest')->group(function(){
    Route::controller(Sessions::class)->group(function(){
        Route::get('/login', 'create')->name('auth.sessions.create');
        Route::post('/login', 'store')->name('auth.sessions.store');
    });
    Route::controller(Registers::class)->group(function(){
        Route::get('/register', 'create')->name('auth.registers.create');
        Route::post('/register', 'store')->name('auth.registers.store');
    });
});

//Route::middleware('auth', 'verified')->prefix('/admin')->group(function(){
//
//        Route::resource('cars', Cars::class);
//    Route::delete('/logout', [Sessions::class, 'destroy'])->name('auth.sessions.destroy');
//});

Route::middleware('auth')->group(function () {
    Route::controller(Conversations::class)->group(function(){
        Route::get('/conversations', 'index')->name('conversations.index');
        Route::get('/conversations/{conversation}', 'show')->name('conversations.show');
        Route::post('/conversations/{conversation}', 'store')->name('conversations.store');
        Route::post('/conversations/search', 'search')->name('conversations.search');
        Route::get('/search/users', 'search')->name('search.users');
        Route::get('conversations/show-or-create/{userId}', 'showOrCreate')->name('conversations.showOrCreate');

    });
});
