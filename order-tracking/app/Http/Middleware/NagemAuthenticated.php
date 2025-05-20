<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class NagemAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->bearerToken();

            if (empty($token)) {
                throw new Exception('Token não fornecido');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->acceptJson()->post('https://api2.nagem.com.br/api/sga/getaccess', ['pagina' => 0]);

            if ($response->status() !== 200) {
                throw new Exception('Resposta inválida da API');
            }

            $data = $response->json()['data'] ?? [];

            $authorized_prefix = 'OTINT001';
            $is_authorized = false;

            foreach ($data as $item) {
                if (strpos($item, $authorized_prefix) === 0) {
                    $is_authorized = true;
                    break;
                }
            }

            if (!$is_authorized) {
                throw new Exception('Acesso não autorizado');
            }

            return $next($request);

        } catch (Exception $e) {
            return response()->json(['error' => 'Não autorizado: ' . $e->getMessage()], 401);
        }
    }
}
