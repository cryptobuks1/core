<?php

namespace App\Exceptions;

use Exception;
//use Whoops\Run as Whoops;
//use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use DB;

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
     * Report or log an exception.
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

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return redirect()->route('home');
        }

        /// Chỉ áp dụng khi debug = false
        if(env('APP_DEBUG') == false) {

            $theme = (env('THEME'))? env('THEME') : 'default';
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
                return response()->view('frontend.' . $theme. '.errors.404', [], 404);
            }
        }


//        if ($this->isHttpException($exception))
//        {
//            return $this->renderHttpException($exception);
//        }
//
//        if (env('APP_DEBUG'))
//        {
//            return $this->whoops($exception);
//        }

        return parent::render($request, $exception);

    }


//    protected function whoops(Exception $e)
//    {
//        $handled = with(new Whoops)
//            ->pushHandler(new \Whoops\Handler\PrettyPageHandler())
//            ->handleException($e);
//
//        return new Response(
//            $handled,
//            $e->getStatusCode(),
//            $e->getHeaders()
//        );
//    }

}
