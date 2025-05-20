<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NagAuth {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->header('Authorization');
            throw_if(empty($token), new \Exception('Token não fornecido'));
    
            // Realizando a chamada
            $response = Http::withHeaders([
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api2.nagem.com.br/api/sga/getaccess', []);
    
            // Log da resposta
            Log::info('Status da API: ' . $response->status());
            Log::info('Resposta da API: ' . $response->body());
    
            if ($response->failed()) {
                throw new \Exception('Erro ao chamar a API');
            }
    
            $data = $response->json()['data'] ?? [];
            foreach ($data as $modulo) {
                if (str_contains($modulo, 'OTINT001')) {
                    return $next($request);
                }
            }
        } catch (Exception $e) {
            Log::error('Erro no middleware: ' . $e->getMessage());
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}