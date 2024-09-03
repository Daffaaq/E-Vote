<?php

namespace App\Exceptions;

use App\Http\Controllers\ErrorController;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();

            if ($statusCode == 404) {
                return redirect()->route('error.404');
            }
            if ($statusCode == 500) {
                return redirect()->route('error.500');
            }
            if ($statusCode == 403) {
                return redirect()->route('error.403');
            }
        }

        return parent::render($request, $exception);
    }
}
