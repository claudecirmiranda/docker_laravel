<?php

namespace Tests\Unit\Services;

use App\Models\Order;
use App\Models\Tracking;
use App\Services\OrderTrackingService;
use Carbon\Carbon;
use Tests\TestCase;

class OrderTrackingServiceTest extends TestCase
{
    public function testUpdateTracking()
    {
        $order = Order::factory()->create(['order_id' => '012345']);
        $tracking = Tracking::factory()->create(['order_id' => $order->order_id]);

        $data = [
            'order_id' => $tracking->order_id,
            'tracking' => [$tracking]
        ];

        // Instancia o serviço
        $orderTrackingService = new OrderTrackingService();

        // Chama o método update
        $result = $orderTrackingService->update('012345', $data);

        // Verifica se o método retornou true
        $this->assertTrue($result);

        // Verifica se a ordem foi atualizada no banco de dados
        $updatedTrackingOrder = Tracking::where('order_id', '012345')->first();

        // Verifica se o tracking foi atualizado corretamente no banco de dados
        $this->assertEquals($tracking->status, $updatedTrackingOrder->status);
        $this->assertEquals($tracking->message, $updatedTrackingOrder->message);
        $this->assertEquals($tracking->observation, $updatedTrackingOrder->observation);
        $this->assertEquals($tracking->created_at, $updatedTrackingOrder->created_at);
    }
}
