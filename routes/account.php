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
    Route::group(['prefix' => vlx_get_account_url()], function() {

        // Dashboard
        Route::group(['namespace' => 'auth_navbar'],function() {
            Route::view('/', 'pages.account.dashboard')->name('dashboard.main');
        });

        // Logout
        // Get disabled due to safety
        //Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');
        // Post only due to safety
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


        // Nodes
        Route::view('/nodes', 'pages.account.node')->name('dashboard.node');

        // Nodes form endpoints
        Route::get( '/nodes/add/',          [NodeController::class, 'create']   )->name('dashboard.node.create');   //FE
        Route::post('/nodes/add/',          [NodeController::class, 'store']    )->name('dashboard.node.store');    //BE

        Route::get( '/nodes/update/{node}', [NodeController::class, 'edit']     )->name('dashboard.node.edit');     //FE
        Route::post('/nodes/update/{node}', [NodeController::class, 'update']   )->name('dashboard.node.update');   //BE

        Route::get( '/nodes/delete/{node}', [NodeController::class, 'trash']    )->name('dashboard.node.trash');    //FE
        Route::post('/nodes/delete/{node}', [NodeController::class, 'delete']   )->name('dashboard.node.delete');   //BE

    });
});
