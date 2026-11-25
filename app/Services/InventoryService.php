<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class InventoryService
{
    /**
     * Consultar las existencias de un producto.
     */
    public function getStock(int $productId): int
    {
        $inventory = Inventory::where('id_producto', $productId)
            ->first();

        if (!$inventory) {
            throw new RuntimeException(
                'No existe inventario para este producto.'
            );
        }

        return (int) $inventory->cantidad;
    }

    /**
     * Verificar si existe disponibilidad suficiente.
     */
    public function hasStock(int $productId, int $quantity): bool
    {
        if ($quantity < 1) {
            return false;
        }

        return $this->getStock($productId) >= $quantity;
    }

    /**
     * Registrar una entrada de inventario.
     */
    public function registerEntry(
        int $productId,
        int $quantity,
        ?int $userId = null,
        ?string $description = null
    ): InventoryMovement {

        if ($quantity < 1) {
            throw new RuntimeException(
                'La cantidad debe ser mayor a cero.'
            );
        }

        return DB::transaction(function () use (
            $productId,
            $quantity,
            $userId,
            $description
        ) {
            $inventory = $this->lockInventory($productId);

            $previousStock = (int) $inventory->cantidad;
            $newStock = $previousStock + $quantity;

            $inventory->update([
                'cantidad' => $newStock,
            ]);

            return $this->createMovement(
                $productId,
                'ENTRADA',
                $quantity,
                $previousStock,
                $newStock,
                $userId,
                $description
            );
        });
    }

    /**
     * Registrar una salida de inventario.
     */
    public function registerExit(
        int $productId,
        int $quantity,
        ?int $userId = null,
        ?string $description = null,
        ?int $orderId = null
    ): InventoryMovement {

        if ($quantity < 1) {
            throw new RuntimeException(
                'La cantidad debe ser mayor a cero.'
            );
        }

        return DB::transaction(function () use (
            $productId,
            $quantity,
            $userId,
            $description,
            $orderId
        ) {
            $inventory = $this->lockInventory($productId);

            $previousStock = (int) $inventory->cantidad;

            if ($previousStock < $quantity) {
                throw new RuntimeException(
                    'Existencias insuficientes para realizar la salida.'
                );
            }

            $newStock = $previousStock - $quantity;

            $inventory->update([
                'cantidad' => $newStock,
            ]);

            return $this->createMovement(
                $productId,
                'SALIDA',
                $quantity,
                $previousStock,
                $newStock,
                $userId,
                $description,
                $orderId
            );
        });
    }

    /**
     * Ajustar las existencias a una cantidad determinada.
     */
    public function adjustStock(
        int $productId,
        int $newStock,
        ?int $userId = null,
        ?string $description = null
    ): InventoryMovement {

        if ($newStock < 0) {
            throw new RuntimeException(
                'Las existencias no pueden ser negativas.'
            );
        }

        return DB::transaction(function () use (
            $productId,
            $newStock,
            $userId,
            $description
        ) {
            $inventory = $this->lockInventory($productId);

            $previousStock = (int) $inventory->cantidad;

            $difference = abs($newStock - $previousStock);

            if ($difference === 0) {
                throw new RuntimeException(
                    'No hay cambios para registrar.'
                );
            }

            $inventory->update([
                'cantidad' => $newStock,
            ]);

            return $this->createMovement(
                $productId,
                'AJUSTE',
                $difference,
                $previousStock,
                $newStock,
                $userId,
                $description
            );
        });
    }

    /**
     * Obtener inventario bloqueando el registro
     * durante la transacción.
     */
    private function lockInventory(int $productId): Inventory
    {
        $inventory = Inventory::where('id_producto', $productId)
            ->lockForUpdate()
            ->first();

        if (!$inventory) {
            throw new RuntimeException(
                'No existe inventario para este producto.'
            );
        }

        return $inventory;
    }

    /**
     * Crear el registro histórico del movimiento.
     */
    private function createMovement(
        int $productId,
        string $type,
        int $quantity,
        int $previousStock,
        int $newStock,
        ?int $userId = null,
        ?string $description = null,
        ?int $orderId = null
    ): InventoryMovement {

        return InventoryMovement::create([
            'id_producto' => $productId,
            'id_usuario' => $userId,
            'id_pedido' => $orderId,
            'tipo_movimiento' => $type,
            'cantidad' => $quantity,
            'stock_anterior' => $previousStock,
            'stock_nuevo' => $newStock,
            'descripcion' => $description,
            'fecha_movimiento' => now(),
        ]);
    }
}
