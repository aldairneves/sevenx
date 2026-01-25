<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->redirectGuestsTo(fn() => response()->json([
            'status' => 'error',
            'message' => 'Unauthenticated.',
            'error' => 'Acesso restrito a usuários autenticados.'
        ], 401));
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->shouldRenderJsonWhen(function (Request $request, $e) {
            return true;
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {

            // Verifica se o erro foi de um ID não encontrado no Banco de Dados
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                $modelClass = $e->getPrevious()->getModel();

                // Se o método existir no Model, usa a mensagem dele
                if (method_exists($modelClass, 'getNotFoundMessage')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $modelClass::getNotFoundMessage(),
                    ], 404);
                }
            }

            // Retorno padrão para rotas inexistentes
            return response()->json([
                'status' => 'error',
                'message' => 'Endpoint não encontrado.',
                'detail' => 'A rota solicitada não existe ou foi movida.'
            ], 404);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {

            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.',
                'detail' => 'Token ausente, expirado ou inválido.'
            ], 401);
        });
    })->create();
