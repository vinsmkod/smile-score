<?php

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
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 419) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.',
                    ], 419);
                }

                return redirect()
                    ->back(fallback: route('admin.login'))
                    ->withInput($request->except('password', 'password_confirmation', '_token'))
                    ->with('info', 'Sesi Anda telah kedaluwarsa karena tidak ada aktivitas. Halaman telah diperbarui dengan sesi baru, silakan coba lagi.');
            }
        });
    })->create();
