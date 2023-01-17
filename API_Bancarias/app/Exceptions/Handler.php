<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        $this->reportable(function (Throwable $e, $request) {

        });
    }


    /**
     * Render custom exception.
     *
     * @return void
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException && $request->wantsJson()) {

            return response()->json([
                'errorCode' => '400',
				'errorDescription' => 'La petición no es valida.',
				'errors' => $exception->validator->getMessageBag()], 400);

        }

        return parent::render($request, $exception);
    }


}
