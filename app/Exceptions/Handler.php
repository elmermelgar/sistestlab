<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Lang;
use PDOException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {

        /* if ($exception instanceof ForeignKeyConstraintViolationException) {
            return redirect()->back()
                ->withErrors(['LlaveForanea' => Lang::get('exceptions.ErrorLlave')]);
        }

        if ($exception instanceof UniqueConstraintViolationException) {
            return redirect()->back()
                ->withErrors(['LlavePrimaria' => Lang::get('exceptions.ErrorLlavePrimaria')]);
        }*/

        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()
                ->withErrors(['tokenmiss' => Lang::get('exceptions.tokenmiss')]);
        }

        if ($exception instanceof PDOException) {
            if($exception->getCode()==7){
                return redirect()->back()
                    ->withErrors(['couldntdb' => Lang::get('exceptions.couldntdb')]);
            };
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
