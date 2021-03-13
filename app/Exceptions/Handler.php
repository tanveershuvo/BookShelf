<?php

namespace App\Exceptions;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
        //
    }


    /**
     * @param Throwable $exception
     * @throws Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Application|ResponseFactory|JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof TokenBlacklistedException){
            return response(['message'=>'CODE ['.Response::HTTP_BAD_REQUEST.'] - token is blacklisted, request new token.']);
        }elseif($exception instanceof TokenInvalidException){
            return response(['message'=>'[CODE - 400] token is invalid.']);
        }elseif($exception instanceof TokenExpiredException){
            return response(['message'=>'[CODE - 400] token is expired, request a new one.']);
        }elseif($exception instanceof JWTException){
            return response(['msg'=>'Unexpected[CODE - 400] token is not provided.','type'=>'red']);
        }elseif ($exception instanceof MethodNotAllowedHttpException) {
            return response(['msg'=>'[CODE - 405]  The specified method for the request is invalid','type'=>'red'],405);
        }elseif ($exception instanceof NotFoundHttpException) {
            return response(['msg'=>'[CODE - 404]   The specified URL cannot be found','type'=>'red']);
        }elseif ($exception instanceof HttpException) {
            return response(['msg'=>'[CODE - '.$exception->getStatusCode().']'.$exception->getMessage(),'type'=>'red']);
        }elseif ($exception instanceof ValidationException) {
            return response(['msg'=>$exception->errors(),'type'=>'red'],422);
        }elseif (config('app.debug')) {
            return parent::render($request, $exception);
        }
    }
}
