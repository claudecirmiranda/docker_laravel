<?php

namespace Tests\Feature\Http\Controllers\Order;

use App\Http\Middleware\NagemAuthenticated;
use App\Http\Middleware\NagAuth;
use App\Services\OrderService;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    public function testStoreCreatesOrder()
    {
        // Mock do OrderService
        $orderServiceMock = $this->createMock(OrderService::class);
        $this->app->instance(OrderService::class, $orderServiceMock);

        // Defina o comportamento esperado do mock
        $orderData = [
            'order_id' => '0123456',
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


        $orderServiceMock->expects($this->once())
            ->method('update')
            ->with($orderData['order_id'], $orderData)
            ->willReturn(true);

        //$response = $this->withoutMiddleware(NagemAuthenticated::class)->json('POST', '/api/order', $orderData);
        $response = $this->withoutMiddleware(NagAuth::class)->json('POST', '/api/order', $orderData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success']);
    }
}
