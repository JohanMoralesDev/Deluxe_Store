<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id('id_movimiento_inventario');

            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('id_pedido')->nullable();
            $table->unsignedBigInteger('id_recepcion_proveedor')->nullable();

            $table->string('tipo_movimiento', 30);
            $table->unsignedInteger('cantidad');

            $table->unsignedInteger('stock_anterior');
            $table->unsignedInteger('stock_nuevo');

            $table->text('descripcion')->nullable();

            $table->dateTime('fecha_movimiento');

            $table->foreign('id_producto')
                ->references('id_producto')
                ->on('productos')
                ->restrictOnDelete();

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('usuarios')
                ->nullOnDelete();

            $table->foreign('id_pedido')
                ->references('id_pedido')
                ->on('pedidos')
                ->nullOnDelete();

            $table->index(['id_producto', 'fecha_movimiento']);
            $table->index('tipo_movimiento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
