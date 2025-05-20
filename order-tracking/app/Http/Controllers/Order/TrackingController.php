<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Tracking\RegisterRequest;
use App\Services\OrderService;
use App\Services\OrderTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TrackingController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private OrderTrackingService $orderTrackingService
    )
    {}

    public function show(Request $request) {
        $hashData = $request->get('hash_data');

        $orderId = $hashData['order_id'];
        $channel = $hashData['channel'];

        $order = $this->orderService->get($orderId);

        if (!$order) {
            return view('order.tracking.not-found');
        }

        return view('order.tracking.show', compact('order'));
    }

    /**
     * Registro de rastreamento de pedido
     *
     * @authenticated
     * @param RegisterRequest $request
     * @return void
     */
    public function store(RegisterRequest $request) {
        $orderId = $request->input('order_id');
        if ($this->orderTrackingService->update($orderId, $request->all())) {
            return response()->json(['message' => 'Tracking updated']);
        }

        return response()->json(['message' => 'Error on update tracking'], 500);
    }

    public function generateHash($orderId, $channel)
    {
        // Obtenha a chave do ambiente
        $token = env('ECOMMERCE_KEY');
    
        // Crie um array com os parâmetros
        $params = [
            'id' => $orderId,
            'ch' => $channel,
            'token' => $token,
        ];
    
        // Crie a string da consulta
        $queryString = http_build_query($params);
    
        // Gere o hash MD5
        $hashToCompare = md5($queryString);
    
        // Codifique os parâmetros e o hash em base64
        $encodedParams = base64_encode(http_build_query(array_merge(Arr::except($params,"token"), ['hash' => $hashToCompare])));
    
        return $encodedParams;
    }
    
}
