<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_page_returns_successful_response(): void
    {
        $this->withoutVite();

        $this->get('/catalogo')->assertOk();
    }
}