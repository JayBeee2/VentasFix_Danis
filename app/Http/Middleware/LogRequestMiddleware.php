<?php

namespace App\Http\Middleware;

use App\Helpers\LogHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Registrar la solicitud entrante
        $requestData = [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ];
        
        // No registrar contraseñas
        $inputData = $request->except(['password', 'password_confirmation']);
        if (!empty($inputData)) {
            $requestData['input'] = $inputData;
        }
        
        LogHelper::info('Solicitud HTTP recibida', $requestData);
        
        // Procesar la solicitud
        $response = $next($request);
        
        // Registrar información básica de la respuesta
        LogHelper::info('Respuesta HTTP enviada', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'status' => $response->getStatusCode(),
        ]);
        
        return $response;
    }
}
