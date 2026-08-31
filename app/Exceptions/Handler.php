<?php

namespace App\Exceptions;

use App\Support\RedirectResolver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Before rendering a 404 for a GET request, check whether the dead URL has a
     * row in the `redirects` table and 301 to it if so.
     */
    public function render($request, Throwable $e)
    {
        if (in_array($request->method(), ['GET', 'HEAD'], true)
            && ! $request->expectsJson()
            && $this->isNotFound($e)) {
            $redirect = app(RedirectResolver::class)->resolve($request);

            if ($redirect !== null) {
                return $redirect;
            }
        }

        return parent::render($request, $e);
    }

    protected function isNotFound(Throwable $e): bool
    {
        return $e instanceof NotFoundHttpException
            || $e instanceof ModelNotFoundException;
    }
}
