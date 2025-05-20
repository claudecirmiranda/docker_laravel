<?php

namespace Tests\Feature\Http\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NagemAuthenticatedTest extends TestCase
{
    protected $orderData = [
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

    public function testMiddlewareAllowsAccessWhenTokenIsValidAndUserHasAccess()
    {
        Http::fake([
            'https://api2.nagem.com.br/api/sga/getaccess' => Http::response([
                'data' => ['OTINT001-0001']
            ], 200),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer valid-token')
            ->post('/api/order', $this->orderData);

        $response->assertStatus(200);
    }

    public function testMiddlewareBlocksAccessWhenTokenIsMissing()
    {
        $response = $this->post('/api/order', $this->orderData);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthorized']);
    }

    public function testMiddlewareBlocksAccessWhenTokenIsInvalid()
    {
        Http::fake([
            'https://api2.nagem.com.br/api/sga/getaccess' => Http::response([], 401),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer invalid-token')
            ->post('/api/order', $this->orderData);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthorized']);
    }

    public function testMiddlewareBlocksAccessWhenUserDoesNotHaveRequiredModule()
    {
        Http::fake([
            'https://api2.nagem.com.br/api/sga/getaccess' => Http::response([
                'data' => ['ANOTHER']
            ], 200),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer valid-token')
            ->post('/api/order', $this->orderData);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthorized']);
    }
}
