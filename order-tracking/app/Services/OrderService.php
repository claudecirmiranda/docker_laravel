<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function get(string $orderId): ?Order
    {
        return Order::where('order_id', $orderId)->with('tracking')->first();
    }

    public function update(string $orderId, array $data): bool
    {
        $order['order_id'] = $orderId;
        $order['raw'] = json_encode($data);
        $order['channel'] = $data['channel'];
        $order['origin_zipcode'] = $data['origin']['zipcode'];
        $order['origin_title'] = $data['origin']['title'];
        $order['destination_zipcode'] = $data['destination']['zipcode'];
        $order['destination_city'] = $data['destination']['city'];
        $order['destination_state'] = $data['destination']['state'];

        if (isset($data['estimated_delivery'])) {
            $order['estimated_delivery'] = $data['estimated_delivery'];
        }

        return Order::upsert([$order], ['order_id']);
    }
}
