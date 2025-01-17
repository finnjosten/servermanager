<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\UserController;

// Authenticated stuff (should not be turned off with normal maintenance mode only full lock down)
Route::group(['middleware' => 'auth'], function () {

    Route::get('/dash/', fn() => redirect()->route('dashboard.main') );
    Route::get('/dashboard/', fn() => redirect()->route('dashboard.main') );

    // Add a prefix

    // Dashboard
    Route::view('/', 'pages.account.dashboard')->name('dashboard.main');

    // Logout
    // Get disabled due to safety
    //Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
    // Post only due to safety
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    // Nodes
    Route::get( '/nodes/view/{node:id}',    [NodeController::class, 'index']    )->name('dashboard.node');

    // Nodes form endpoints
    Route::get( '/nodes/add/',              [NodeController::class, 'create']   )->name('dashboard.node.create');   //FE
    Route::post('/nodes/add/',              [NodeController::class, 'store']    )->name('dashboard.node.store');    //BE

    Route::get( '/nodes/update/{node:id}',  [NodeController::class, 'edit']     )->name('dashboard.node.edit');     //FE
    Route::post('/nodes/update/{node:id}',  [NodeController::class, 'update']   )->name('dashboard.node.update');   //BE

    Route::get( '/nodes/delete/{node:id}',  [NodeController::class, 'trash']    )->name('dashboard.node.trash');    //FE
    Route::post('/nodes/delete/{node:id}',  [NodeController::class, 'destroy']  )->name('dashboard.node.delete');   //BE

});
