<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_store_pages_return_successful_responses(): void
    {
        $this->withoutVite();

        foreach (['/nuevo', '/catalogo', '/carrito'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }
}
