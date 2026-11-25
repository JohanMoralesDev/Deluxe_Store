<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_page_returns_successful_response(): void
    {
        $this->withoutVite();

        $this->get('/carrito')
            ->assertOk()
            ->assertSee(asset('assets/css/Carrito.css'))
            ->assertSee(asset('assets/js/carrito.js'));
    }

    public function test_product_can_be_added_to_cart_and_total_is_calculated(): void
    {
        $this->withoutVite();

        $category = Category::create([
            'nombre' => 'Relojes',
            'descripcion' => 'Colección',
            'esta_activa' => true,
        ]);

        $product = Product::create([
            'id_categoria' => $category->getKey(),
            'nombre' => 'Reloj prueba',
            'codigo_sku' => 'SKU-TEST-1',
            'descripcion' => 'Descripción',
            'precio' => 100000,
            'esta_activo' => true,
        ]);
        Inventory::create([
            'id_producto' => $product->getKey(),
            'cantidad' => 5,
            'stock_minimo' => 1,
        ]);

        $this->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect();

        $this->get('/carrito')
            ->assertOk()
            ->assertSee('Reloj prueba')
            ->assertSee('200.000');
    }

    public function test_quantity_is_capped_by_available_stock(): void
    {
        $this->withoutVite();

        $category = Category::create(['nombre' => 'Stock', 'esta_activa' => true]);
        $product = Product::create([
            'id_categoria' => $category->getKey(),
            'nombre' => 'Reloj limitado',
            'codigo_sku' => 'SKU-STOCK-1',
            'precio' => 50000,
            'esta_activo' => true,
        ]);
        Inventory::create([
            'id_producto' => $product->getKey(),
            'cantidad' => 2,
            'stock_minimo' => 1,
        ]);

        $this->postJson(route('cart.add', $product), ['quantity' => 10])
            ->assertOk()
            ->assertJson(['count' => 2, 'total' => 100000]);

        $this->assertSame(2, session('cart.' . $product->getKey() . '.quantity'));
    }

    public function test_quantity_can_be_updated_and_product_removed(): void
    {
        $this->withoutVite();

        $category = Category::create(['nombre' => 'Acciones', 'esta_activa' => true]);
        $product = Product::create([
            'id_categoria' => $category->getKey(),
            'nombre' => 'Reloj acciones',
            'codigo_sku' => 'SKU-ACTIONS-1',
            'precio' => 30000,
            'esta_activo' => true,
        ]);
        Inventory::create([
            'id_producto' => $product->getKey(),
            'cantidad' => 4,
            'stock_minimo' => 1,
        ]);

        $this->post(route('cart.add', $product), ['quantity' => 1])->assertRedirect();
        $this->patch(route('cart.update', $product), ['quantity' => 3])->assertRedirect();
        $this->assertSame(3, session('cart.' . $product->getKey() . '.quantity'));

        $this->delete(route('cart.remove', $product))->assertRedirect();
        $this->assertFalse(session()->has('cart.' . $product->getKey()));
    }

    public function test_cart_can_be_cleared(): void
    {
        $this->withSession([
            'cart' => [
                101 => ['quantity' => 2],
            ],
        ]);

        $this->delete(route('cart.clear'))
            ->assertRedirect();

        $this->assertFalse(session()->has('cart'));
    }

    public function test_inactive_product_cannot_be_added(): void
    {
        $this->withoutVite();

        $category = Category::create(['nombre' => 'Inactivos', 'esta_activa' => true]);
        $product = Product::create([
            'id_categoria' => $category->getKey(),
            'nombre' => 'Reloj inactivo',
            'codigo_sku' => 'SKU-INACTIVE-1',
            'precio' => 70000,
            'esta_activo' => false,
        ]);
        Inventory::create([
            'id_producto' => $product->getKey(),
            'cantidad' => 5,
            'stock_minimo' => 1,
        ]);

        $this->postJson(route('cart.add', $product), ['quantity' => 1])
            ->assertStatus(422)
            ->assertJson(['ok' => false]);

        $this->assertFalse(session()->has('cart'));
    }
}