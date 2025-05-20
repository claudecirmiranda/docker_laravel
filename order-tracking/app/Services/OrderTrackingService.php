<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Tracking;

class OrderTrackingService
{
    public function update(string $orderId, array $data): bool
    {
        throw_if(!Order::where('order_id', $orderId)->exists(), new \Exception('Order not found'));

        $trackings = [];

        foreach ($data['tracking'] as $tracking) {
            $trackings[] = [
                'order_id' => $orderId,
                'step' => $tracking['step'],
                'status' => $tracking['status'],
                'message' => $tracking['message'],
                'observation' => $tracking['observation'] ?? null,
                'created_at' => $tracking['created_at'],
                'raw' => json_encode($tracking),
            ];
        }

        return Tracking::insert($trackings);
    }
}
