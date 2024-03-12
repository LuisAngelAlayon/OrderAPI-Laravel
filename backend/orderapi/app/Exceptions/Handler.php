<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    private $url = ['causal', 'observation', 'technician', 'type_activity', 'activity', 'order', 'user'];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {

            //añade el prefijo api/ a la lista de urls
            $urlFinal = preg_filter('/^/', 'api/', $this->url);
            //Añade eñ sufijo a la lista de urls
            $urlFinal = preg_filter('/$/', '/*', $this->url);

            if ($request->is($urlFinal)) {
                return response()->json([
                    'message' => 'No encontrada'
                ], Response::HTTP_NOT_FOUND);
            }

        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'message' => 'URL no encontrada o no soportada'
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        });

    }

    public function render($request, Throwable $exception)
    {

        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => 'No autorizado'
            ], Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Debe iniciar sesion '
            ], Response::HTTP_UNAUTHORIZED);
        }



        return parent::render($request, $exception);
    }
}
