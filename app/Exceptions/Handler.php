<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\EmailNotProvidedException;
use App\Exceptions\UnauthorizedException;

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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        switch($exception){
            case $exception instanceof EmailNotProvidedException :
                if ($request->ajax()) {
                    return response()->json(['error' => 'Email Not Found'], 500);
                }
                return response()->view('errors.email-not-found-exception', compact('exception'), 500);
                break;
            case $exception instanceof NoActiveAccountException:
                if ($request->ajax()) {
                    return response()->json(['error' => 'No Active Account'], 500);
                }
                return response()->view('errors.no-active-account-exception', compact('exception'), 500);
                break;
            case $exception instanceof UnauthorizedException:
                if ($request->ajax()) {
                    return response()->json(['error' => 'Unauthorized'], 500);
                }
                return response()->view('errors.unauthorized-exception', compact('exception'), 500);
                break;
            default:
                return parent::render($request, $exception);
        }
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