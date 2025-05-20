<?php

namespace Tests\Unit\Services;

use App\Models\Order;
use App\Models\Tracking;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    public function testGetOrder()
    {
        // Cria uma ordem e trackings associados
        $order = Order::factory()->create(['order_id' => '012345']);
        $tracking1 = Tracking::factory()->create(['order_id' => $order->order_id]);
        $tracking2 = Tracking::factory()->create(['order_id' => $order->order_id]);

        // Instancia o serviço
        $orderService = new OrderService();

        // Chama o método get
        $result = $orderService->get('012345');

        // Verifica se a ordem foi retornada corretamente
        $this->assertInstanceOf(Order::class, $result);
        $this->assertEquals('012345', $result->order_id);

        // Verifica se os trackings foram carregados corretamente
        $this->assertCount(2, $result->tracking);
    }

    public function testUpdateOrder()
    {
        // Cria uma ordem para atualizar
        $order = Order::factory()->create(['order_id' => '012345']);

        $data = [
            'channel' => 'online',
            'origin' => [
                'zipcode' => '12345-678',
                'title' => 'Warehouse A',
            ],
            'destination' => [
                'zipcode' => '87654-321',
                'city' => 'City X',
                'state' => 'State Y',
            ],
            'estimated_delivery' => '2024-09-30',
        ];

        // Instancia o serviço
        $orderService = new OrderService();

        // Chama o método update
        $result = $orderService->update('012345', $data);

        // Verifica se o método retornou true
        $this->assertTrue($result);

        // Verifica se a ordem foi atualizada no banco de dados
        $updatedOrder = Order::where('order_id', '012345')->first();
        $this->assertEquals('online', $updatedOrder->channel);
        $this->assertEquals('12345-678', $updatedOrder->origin_zipcode);
        $this->assertEquals('City X', $updatedOrder->destination_city);
        $this->assertEquals(new Carbon('2024-09-30'), $updatedOrder->estimated_delivery);
    }
}
