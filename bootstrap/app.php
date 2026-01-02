<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

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
        $exceptions->render(function (Throwable $e, Request $request) {
            // Optional: Log it
            report($e);
    
            // 🔹 1. Check if session or token expired
            if (
                $e instanceof \Illuminate\Session\TokenMismatchException ||   // CSRF token expired
                $e instanceof \Illuminate\Auth\AuthenticationException ||     // not logged in
                str_contains($e->getMessage(), 'expired')                     // custom message
            ) {
                // Destroy session if needed
                session()->flush();
    
                // Redirect to login form
                return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
            }
    
            // 🔹 2. For other exceptions → show your custom error page
            if (view()->exists('error.404')) {
                return response()->view('error.404', ['exception' => $e], 500);
            }
    
            // 🔹 3. Fallback
            return response('Something went wrong', 500);
        });
    })
    ->create();
    


    $app->singleton(
        Illuminate\Contracts\Http\Kernel::class,
        App\Http\Kernel::class
    );
    
    $app->singleton(
        Illuminate\Contracts\Console\Kernel::class,
        App\Console\Kernel::class
    );
    
    $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        App\Exceptions\Handler::class
    );