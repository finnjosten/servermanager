<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/api/get-cookie/{cookie_name}',         [ApiController::class, "getCookie"]);
Route::get('/api/set-cookie/{cookie_name}/{data}',  [ApiController::class, "setCookie"]);

Route::get('/api/nodes/status/{url}',       [ApiController::class, "checkNodeStatus"]   );
Route::get('/api/nodes/usage/{node:id}',    [ApiController::class, "nodeUsage"]         )->name('api.node.usage');

Route::get('/api/nodes/{node:id}/network/{port}/delete',    [ApiController::class, "deleteNodePort"]    )->name('api.node.port.remove');
Route::get('/api/nodes/{node:id}/network/{port}/add',       [ApiController::class, "addNodePort"]       )->name('api.node.port.add');

Route::get('/api/nodes/{node:id}/webserver/{id}',           [ApiController::class, "getWebserver"]    )->name('api.node.webserver.details');
Route::post('/api/nodes/{node:id}/webserver/{id}/save',     [ApiController::class, "saveWebserver"]   )->name('api.node.webserver.save');
Route::post('/api/nodes/{node:id}/webserver/{id}/remove',   [ApiController::class, "removeWebserver"] )->name('api.node.webserver.remove');
Route::post('/api/nodes/{node:id}/webserver/{id}/certbot',  [ApiController::class, "certbotWebserver"])->name('api.node.webserver.certbot');
Route::post('/api/nodes/{node:id}/webserver/{id}/enable',   [ApiController::class, "enableWebserver"] )->name('api.node.webserver.enable');
Route::post('/api/nodes/{node:id}/webserver/{id}/disable',  [ApiController::class, "disableWebserver"])->name('api.node.webserver.disable');
Route::post('/api/nodes/{node:id}/webserver/create',        [ApiController::class, "addWebserver"]    )->name('api.node.webserver.add');

Route::get( '/api/nodes/{node:id}/webapps/{id}',            [ApiController::class, "getWebapp"]     )->name('api.node.webapp.details');
Route::post('/api/nodes/{node:id}/webapps/{id}/save',       [ApiController::class, "saveWebapp"]    )->name('api.node.webapp.save');
Route::post('/api/nodes/{node:id}/webapp/create',           [ApiController::class, "addWebapp"]     )->name('api.node.webapp.add');
