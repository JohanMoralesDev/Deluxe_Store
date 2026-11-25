<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->id('id_usuario');
                $table->string('nombre', 150);
                $table->string('correo', 150)->unique();
                $table->string('contrasena', 255);
                $table->string('telefono', 25)->nullable();
                $table->string('direccion', 255)->nullable();
                $table->string('ciudad', 100)->nullable();
                $table->string('departamento', 100)->nullable();
                $table->boolean('esta_activo')->default(true);
                $table->timestamp('correo_verificado_en')->nullable();
                $table->string('token_recordatorio', 100)->nullable();
                $table->timestamp('creado_en')->nullable();
                $table->timestamp('actualizado_en')->nullable();
            });
        }

        if (! Schema::hasTable('categorias')) {
            Schema::create('categorias', function (Blueprint $table) {
                $table->id('id_categoria');
                $table->string('nombre', 100)->unique();
                $table->text('descripcion')->nullable();
                $table->boolean('esta_activa')->default(true);
                $table->timestamp('creado_en')->nullable();
                $table->timestamp('actualizado_en')->nullable();
            });
        }

        if (! Schema::hasTable('productos')) {
            Schema::create('productos', function (Blueprint $table) {
                $table->id('id_producto');
                $table->unsignedBigInteger('id_categoria');
                $table->string('nombre', 150);
                $table->string('codigo_sku', 80)->unique();
                $table->text('descripcion')->nullable();
                $table->decimal('precio', 12, 2);
                $table->decimal('precio_oferta', 12, 2)->nullable();
                $table->string('color', 50)->nullable();
                $table->string('url_imagen', 500)->nullable();
                $table->boolean('esta_activo')->default(true);
                $table->timestamp('creado_en')->nullable();
                $table->timestamp('actualizado_en')->nullable();
                $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->restrictOnDelete();
            });
        }

        if (! Schema::hasTable('inventarios')) {
            Schema::create('inventarios', function (Blueprint $table) {
                $table->id('id_inventario');
                $table->unsignedBigInteger('id_producto')->unique();
                $table->unsignedInteger('cantidad')->default(0);
                $table->unsignedInteger('stock_minimo')->default(5);
                $table->timestamp('actualizado_en')->nullable();
                $table->foreign('id_producto')->references('id_producto')->on('productos')->restrictOnDelete();
            });
        }

        if (! Schema::hasTable('pedidos')) {
            Schema::create('pedidos', function (Blueprint $table) {
                $table->id('id_pedido');
                $table->unsignedBigInteger('id_usuario');
                $table->string('numero_pedido', 50)->unique();
                $table->string('estado', 30)->default('PENDIENTE');
                $table->string('estado_pago', 30)->default('PENDIENTE');
                $table->string('metodo_pago', 50)->nullable();
                $table->decimal('subtotal', 14, 2)->default(0);
                $table->decimal('costo_envio', 12, 2)->default(0);
                $table->decimal('descuento', 12, 2)->default(0);
                $table->decimal('total', 14, 2)->default(0);
                $table->string('nombre_destinatario', 150);
                $table->string('telefono_destinatario', 25);
                $table->string('direccion_envio', 255);
                $table->string('ciudad_envio', 100);
                $table->string('departamento_envio', 100);
                $table->text('observaciones')->nullable();
                $table->dateTime('fecha_pedido');
                $table->timestamp('creado_en')->nullable();
                $table->timestamp('actualizado_en')->nullable();
                $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->restrictOnDelete();
                $table->index(['id_usuario', 'fecha_pedido']);
            });
        }

        if (! Schema::hasTable('detalle_pedido')) {
            Schema::create('detalle_pedido', function (Blueprint $table) {
                $table->id('id_detalle');
                $table->unsignedBigInteger('id_pedido');
                $table->unsignedBigInteger('id_producto');
                $table->string('nombre_producto', 150);
                $table->string('codigo_sku', 80);
                $table->unsignedInteger('cantidad');
                $table->decimal('precio_unitario', 12, 2);
                $table->decimal('subtotal', 14, 2);
                $table->timestamp('creado_en')->nullable();
                $table->timestamp('actualizado_en')->nullable();
                $table->foreign('id_pedido')->references('id_pedido')->on('pedidos')->restrictOnDelete();
                $table->foreign('id_producto')->references('id_producto')->on('productos')->restrictOnDelete();
                $table->unique(['id_pedido', 'id_producto']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('inventarios');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('usuarios');
    }
};
