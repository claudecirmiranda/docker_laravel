<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\RegisterRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {}

    /**
     * Registro de pedido
     *
     * @authenticated
     * @param RegisterRequest $request
     * @return void
     */
    public function store(RegisterRequest $request) {
        $orderId = $request->input('order_id');
        $order = $this->orderService->update($orderId, $request->all());

        return response()->json($order ? ['success' => true] : ['success' => false], $order ? 200 : 400);
    }
}
