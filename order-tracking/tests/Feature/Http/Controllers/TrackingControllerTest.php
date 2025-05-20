<?php

namespace Tests\Feature\Http\Controllers\Order;

use App\Http\Middleware\NagemAuthenticated;
use App\Http\Middleware\NagAuth;
use App\Models\Order;
use App\Models\Tracking;
use App\Services\OrderService;
use App\Services\OrderTrackingService;
use Illuminate\Support\Arr;
use Tests\TestCase;

class TrackingControllerTest extends TestCase
{
    protected $tracking;

    public function setUp(): void
    {
        parent::setUp();

        $this->tracking = Tracking::factory()->make(['order_id' => '12345']);
    }

    public function testShowReturnsOrderTrackingView()
    {
        // Mock do OrderTrackingService
        $orderServiceMock = $this->createMock(OrderService::class);
        $this->app->instance(OrderService::class, $orderServiceMock);

        // Dados para o teste
        $orderData = [
            'id' => '12345',
            'ch' => 'online',
            'token' => env('ECOMMERCE_KEY')
        ];

        $hash = md5(http_build_query($orderData));

        // Definir o comportamento esperado do mock
        $order = Order::factory()->make();
        $orderServiceMock->expects($this->once())
            ->method('get')
            ->with($orderData['id'])
            ->willReturn($order);
        $hashUrl = base64_encode(http_build_query([
            ...Arr::except($orderData, ['token']),
            'hash' => $hash
        ]));
        // Simular a requisição para o método show
        $response = $this->withoutMiddleware(NagemAuthenticated::class)->get("/$hashUrl");
        $response = $this->withoutMiddleware(NagAuth::class)->get("/$hashUrl");

        // Verificar se a view correta foi retornada
        $response->assertStatus(200);
        $response->assertViewIs('order.tracking.show');
        $response->assertViewHas('orders', $order);
    }

    public function testStoreUpdatesTrackingSuccessfully()
    {
        // Mock do OrderTrackingService
        $trackingServiceMock = $this->createMock(OrderTrackingService::class);
        $this->app->instance(OrderTrackingService::class, $trackingServiceMock);

        // Definir o comportamento esperado do mock
        $trackingServiceMock->expects($this->once())
            ->method('update')
            ->with('12345', $this->isType('array'))
            ->willReturn(true);

        // Simular a requisição POST
        $response = $this->withoutMiddleware(NagemAuthenticated::class)->postJson('/api/order/tracking', [
            'order_id' => '12345',
            'channel' => 'online',
            'tracking' => [$this->tracking]
        ]);

        // Verificar a resposta
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Tracking updated']);
    }

    public function testStoreFailsToUpdateTracking()
    {
        // Mock do OrderTrackingService
        $trackingServiceMock = $this->createMock(OrderTrackingService::class);
        $this->app->instance(OrderTrackingService::class, $trackingServiceMock);

        // Definir o comportamento esperado do mock
        $trackingServiceMock->expects($this->once())
            ->method('update')
            ->with('12345', $this->isType('array'))
            ->willReturn(false);

        // Simular a requisição POST
        $response = $this->withoutMiddleware(NagemAuthenticated::class)->postJson('/api/order/tracking', [
            'order_id' => '12345',
            'channel' => 'online',
            'tracking' => [$this->tracking]
        ]);

        // Verificar a resposta em caso de erro
        $response->assertStatus(500);
        $response->assertJson(['message' => 'Error on update tracking']);
    }
}
