<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; 

class TrackingValidateHash
{
    public function handle($request, Closure $next)
    {
        $hash = $request->route('hash');

        if (!$hash) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        try {
            $data = base64_decode($hash);
            $params = [];
            parse_str($data, $params);
            $hash = $params['hash'] ?? null;
            throw_if(empty($hash));
            $paramsToHash = [
                ...Arr::except($params, ['hash']),
                'token' => env('ECOMMERCE_KEY')
            ];
            $hashToCompare = md5(http_build_query($paramsToHash));

            //Log::info($hash);
            //Log::info($paramsToHash);
            //Log::info($hashToCompare);

            throw_if($hash != $hashToCompare);
            $request->merge(['hash_data' => [
                'order_id' => $params['id'],
                'channel' => $params['ch'],
            ]]);
        } catch (\Exception $e) {
            return abort(Response::HTTP_FORBIDDEN, 'A URL que você utilizou é inválida. Por favor, tente novamente.');
            return response()->json(['error' => 'Hash Invalido'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
