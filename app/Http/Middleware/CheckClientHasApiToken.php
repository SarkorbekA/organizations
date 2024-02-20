<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckClientHasApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        env('API_TOKEN');
//        $token = config('api_tokens.external_services');



        $token = config('api_tokens.token');

//        var_dump($token);

        if ($request->header('Api-Token') !== $token){
//            throw new \Exception('Forbidden!');



//            throw new \EnsureTokenException('Forbidden!', 403);

            return \response()->json([
                'message' => 'Forbidden'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}

//\Throwable::class;
//\Exception::class;

// Handler.php Обработать нужно исключения
// Создать свой класс исключения (EnsureTokenException)
//
