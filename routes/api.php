<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/api/get-cookie/{cookie_name}',         [ApiController::class, "getCookie"]);
Route::get('/api/set-cookie/{cookie_name}/{data}',  [ApiController::class, "setCookie"]);

Route::get('/api/nodes/status/{url}',       [ApiController::class, "checkNodeStatus"]);
Route::get('/api/nodes/usage/{node:id}',    [ApiController::class, "nodeUsage"])->name('api.node.usage');

Route::get('/api/nodes/{node:id}/network/{port}/delete',    [ApiController::class, "deleteNodePort"])->name('api.node.port.remove');
Route::get('/api/nodes/{node:id}/network/{port}/add',       [ApiController::class, "addNodePort"])->name('api.node.port.add');

Route::get('/api/nodes/{node:id}/webapps/{id}',         [ApiController::class, "getWebapp"])->name('api.node.webapp.details');
Route::post('/api/nodes/{node:id}/webapps/{id}/save',   [ApiController::class, "saveWebapp"])->name('api.node.webapp.save');
Route::post('/api/nodes/{node:id}/webapps/create',      [ApiController::class, "addWebapp"])->name('api.node.webapp.add');
