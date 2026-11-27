<?php

use App\Http\Middleware\Checkrole;
use App\Http\Middleware\DecodeVirtualSlugParameters;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(prepend: [
            DecodeVirtualSlugParameters::class,
        ]);
        $middleware->alias([
            'checkrole' => Checkrole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            return back()->withInput()->with('error', 'Ukuran data atau file yang dikirim terlalu besar melebihi batas server. Silakan naikkan limit post_max_size di cPanel atau kurangi ukuran file/gambar.');
        });
    })->create();
