<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_endpoint_with_provided_token()
    {
        $user = User::factory()->create([
            'email' => 'customer@example.com',
            'name'  => 'John Doe',
        ]);

        $fakeCharge = (object)[
            'id' => 'ch_fake123',
        ];

        // Use Laravel's built-in mock helper to override PaymentService methods.
        $this->mock(PaymentService::class, function ($mock) use ($fakeCharge) {
            $mock->shouldReceive('processPayment')
                ->once()
                ->andReturn($fakeCharge);

            // We expect generateToken not to be called when a token is provided.
            $mock->shouldReceive('generateToken')
                ->never();
        });

        // Prepare the payload with the provided token.
        $payload = [
            "amount"      => 6,
            "currency"    => "usd",
            "stripeToken" => "tok_visa"
        ];

        // Send a POST request to the payment endpoint.
        $response = $this->actingAs($user)
            ->postJson('/api/payment', $payload);

        // Assert the response status and JSON structure.
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'charge'  => [
                    'id' => 'ch_fake123'
                ]
            ]);
    }
}
