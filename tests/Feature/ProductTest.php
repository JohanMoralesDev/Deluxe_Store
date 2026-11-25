<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_catalog_page_returns_successful_response(): void
    {
        $this->withoutVite();

        $this->get('/catalogo')->assertOk();
    }
}