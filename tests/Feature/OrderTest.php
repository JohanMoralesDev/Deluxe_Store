<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_root_is_available(): void
    {
        $this->withoutVite();

        $this->get('/')->assertOk();
    }

    public function test_checkout_creates_order_and_decreases_inventory(): void
    {
        $this->withoutVite();

        $user = User::create([
            'nombre' => 'Cliente Uno',
            'correo' => 'uno@example.com',
            'contrasena' => 'password',
            'esta_activo' => true,
        ]);

        $category = Category::create([
            'nombre' => 'Relojes',
            'esta_activa' => true,
        ]);
        $product = Product::create([
            'id_categoria' => $category->getKey(),
            'nombre' => 'Reloj pedido',
            'codigo_sku' => 'SKU-ORDER-1',
            'precio' => 85000,
            'esta_activo' => true,
        ]);
        Inventory::create([
            'id_producto' => $product->getKey(),
            'cantidad' => 3,
            'stock_minimo' => 1,
        ]);

        $this->actingAs($user);
        $this->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect();

        $response = $this->post(route('checkout.store'), [
            'nombre_destinatario' => 'Cliente Uno',
            'telefono_destinatario' => '3001234567',
            'direccion_envio' => 'Calle 1',
            'ciudad_envio' => 'Bogotá',
            'departamento_envio' => 'Cundinamarca',
            'metodo_pago' => 'CONTRAENTREGA',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pedidos', [
            'id_usuario' => $user->getKey(),
            'total' => 170000,
        ]);
        $this->assertDatabaseHas('detalle_pedido', [
            'id_producto' => $product->getKey(),
            'cantidad' => 2,
        ]);
        $this->assertDatabaseHas('inventarios', [
            'id_producto' => $product->getKey(),
            'cantidad' => 1,
        ]);
    }

    public function test_customer_cannot_view_another_customers_order(): void
    {
        $this->withoutVite();

        $owner = User::create([
            'nombre' => 'Propietario',
            'correo' => 'owner@example.com',
            'contrasena' => 'password',
            'esta_activo' => true,
        ]);
        $other = User::create([
            'nombre' => 'Otro',
            'correo' => 'other@example.com',
            'contrasena' => 'password',
            'esta_activo' => true,
        ]);

        $order = \App\Models\Order::create([
            'id_usuario' => $owner->getKey(),
            'numero_pedido' => 'PED-TEST-1',
            'estado' => 'PENDIENTE',
            'estado_pago' => 'PENDIENTE',
            'metodo_pago' => 'CONTRAENTREGA',
            'subtotal' => 100,
            'costo_envio' => 0,
            'descuento' => 0,
            'total' => 100,
            'nombre_destinatario' => 'Propietario',
            'telefono_destinatario' => '3000000000',
            'direccion_envio' => 'Calle 1',
            'ciudad_envio' => 'Bogotá',
            'departamento_envio' => 'Cundinamarca',
            'fecha_pedido' => now(),
        ]);

        $this->actingAs($other)
            ->get(route('orders.show', $order))
            ->assertForbidden();
    }

    public function test_checkout_requires_authentication(): void
    {
        $this->withoutVite();

        $this->get(route('checkout'))
            ->assertRedirect(route('login'));

        $this->post(route('checkout.store'), [])
            ->assertRedirect(route('login'));
    }

    public function test_checkout_revalidates_current_price(): void
    {
        $this->withoutVite();

        $user = User::create([
            'nombre' => 'Cliente Precio',
            'correo' => 'precio@example.com',
            'contrasena' => 'password',
            'esta_activo' => true,
        ]);
        $category = Category::create(['nombre' => 'Precios', 'esta_activa' => true]);
        $product = Product::create([
            'id_categoria' => $category->getKey(),
            'nombre' => 'Reloj precio',
            'codigo_sku' => 'SKU-PRICE-1',
            'precio' => 100000,
            'esta_activo' => true,
        ]);
        Inventory::create([
            'id_producto' => $product->getKey(),
            'cantidad' => 5,
            'stock_minimo' => 1,
        ]);

        $this->actingAs($user);
        $this->post(route('cart.add', $product), ['quantity' => 2])->assertRedirect();

        $product->update(['precio' => 125000]);

        $this->post(route('checkout.store'), [
            'nombre_destinatario' => 'Cliente Precio',
            'telefono_destinatario' => '3001112233',
            'direccion_envio' => 'Calle 2',
            'ciudad_envio' => 'Medellín',
            'departamento_envio' => 'Antioquia',
            'metodo_pago' => 'TRANSFERENCIA',
        ])->assertRedirect();

        $this->assertDatabaseHas('pedidos', [
            'id_usuario' => $user->getKey(),
            'subtotal' => 250000,
            'total' => 250000,
        ]);
    }

    public function test_checkout_rejects_invalid_shipping_data(): void
    {
        $this->withoutVite();

        $user = User::create([
            'nombre' => 'Cliente Validación',
            'correo' => 'validacion@example.com',
            'contrasena' => 'password',
            'esta_activo' => true,
        ]);

        $this->actingAs($user)
            ->withSession(['cart' => [1 => ['quantity' => 1]]])
            ->post(route('checkout.store'), [
                'nombre_destinatario' => '',
                'telefono_destinatario' => '',
                'direccion_envio' => '',
                'ciudad_envio' => '',
                'departamento_envio' => '',
                'metodo_pago' => '',
            ])
            ->assertSessionHasErrors([
                'nombre_destinatario',
                'telefono_destinatario',
                'direccion_envio',
                'ciudad_envio',
                'departamento_envio',
                'metodo_pago',
            ]);
    }

    public function test_empty_cart_checkout_is_rejected(): void
    {
        $this->withoutVite();

        $user = User::create([
            'nombre' => 'Cliente Vacío',
            'correo' => 'vacio@example.com',
            'contrasena' => 'password',
            'esta_activo' => true,
        ]);

        $this->actingAs($user)
            ->get(route('checkout'))
            ->assertRedirect(route('store.carrito'))
            ->assertSessionHas('error');
    }

    public function test_customer_can_list_only_owned_orders(): void
    {
        $this->withoutVite();

        $owner = User::create([
            'nombre' => 'Propietario',
            'correo' => 'history-owner@example.com',
            'contrasena' => 'password',
            'esta_activo' => true,
        ]);
        $other = User::create([
            'nombre' => 'Otro',
            'correo' => 'history-other@example.com',
            'contrasena' => 'password',
            'esta_activo' => true,
        ]);

        foreach ([[$owner, 'PED-OWNER'], [$other, 'PED-OTHER']] as [$user, $number]) {
            \App\Models\Order::create([
                'id_usuario' => $user->getKey(),
                'numero_pedido' => $number,
                'estado' => 'PENDIENTE',
                'estado_pago' => 'PENDIENTE',
                'metodo_pago' => 'CONTRAENTREGA',
                'subtotal' => 100,
                'costo_envio' => 0,
                'descuento' => 0,
                'total' => 100,
                'nombre_destinatario' => $user->nombre,
                'telefono_destinatario' => '3000000000',
                'direccion_envio' => 'Calle 1',
                'ciudad_envio' => 'Bogotá',
                'departamento_envio' => 'Cundinamarca',
                'fecha_pedido' => now(),
            ]);
        }

        $this->actingAs($owner)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('PED-OWNER')
            ->assertDontSee('PED-OTHER');
    }
}