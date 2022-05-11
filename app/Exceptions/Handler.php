<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|\Illuminate\Http\Response|Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            return $this->handleApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    protected function handleApiException(Request $request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof JsonResponse) {
            return $exception;
        }

        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = [
            'message' => $exception->getMessage(),
            'path' => $request->path(),
            'request' => $request->all(),
        ];

        $isShowTrace = config('app.debug');

        if ($exception instanceof AuthenticationException || $exception instanceof UnauthorizedHttpException) {
            $response['message'] = 'Вы не авторизованы';
            $statusCode = Response::HTTP_UNAUTHORIZED;
            $isShowTrace = false;
        }

        if ($exception instanceof AccessDeniedHttpException) {
            $response['message'] = 'Недостаточно прав';
            $isShowTrace = false;
        }

        if ($exception instanceof ValidationException) {
            $response['message'] = 'Указанные данные не прошли проверку';
            $response['errors'] = $exception->errors();
            $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $isShowTrace = false;
        }

        if ($exception instanceof ModelNotFoundException || $exception->getPrevious() instanceof ModelNotFoundException) {
            $response['message'] = 'Данные не найдены.';
            $statusCode = Response::HTTP_NOT_FOUND;
            $isShowTrace = false;
        }

        if ($isShowTrace) {
            $response['trace'] = $exception->getTrace();
            $response['code'] = $exception->getCode();
        }

        return response()->json($response, $statusCode);
    }
}
