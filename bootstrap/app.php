<?php

use App\Console\Commands\CloneDb;
use App\Http\Middleware\Maintenance;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\CorsHeader;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(Maintenance::class);
        $middleware->append(CorsHeader::class);

        $middleware->appendToGroup('auth-admin', [
            AuthAdmin::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/api/nodes/start-monitoring',
            '/api/nodes/status-updates',
            '/api/nodes/stop-monitoring',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
