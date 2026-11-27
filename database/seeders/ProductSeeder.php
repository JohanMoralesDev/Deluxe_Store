<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Datos de la colección histórica del catálogo. Se asignan a las
        // categorías vigentes por público, sin crear ni cambiar categorías.
        $categoryByAudience = [
            'caballero' => Category::query()->where('nombre', 'Relojes de Hombre')->where('esta_activa', true)->value('id_categoria'),
            'dama' => Category::query()->where('nombre', 'Relojes de Mujer')->where('esta_activa', true)->value('id_categoria'),
        ];

        $watches = [
            ['CUR-H-001', 'Reloj marca Curren para caballero', 'Curren-Hombre.jpeg', 'caballero', 175000, 160000, '2025-11-06'],
            ['CUR-D-001', 'Reloj marca Curren para mujer', 'Curren-Dama.jpeg', 'dama', 136000, 130000, '2025-08-29'],
            ['QQ-001', 'Reloj marca Q&Q', 'Q&Q.jpeg', 'caballero', 90000, 86000, '2026-03-01'],
            ['ROL-001', 'Reloj marca Rolex para caballero', 'Rolex.jpeg', 'caballero', 135000, 120000, '2026-06-15'],
            ['CK-001', 'Reloj marca Calvin Klein para caballero', 'Calvin-Klein.jpeg', 'caballero', 25000, 20000, '2025-06-06'],
            ['PAN-001', 'Reloj marca Pandora para dama', 'Pandora.jpeg', 'dama', 38000, 35000, '2025-12-09'],
            ['NAV-001', 'Reloj Naviforce para caballero', 'Naviforce.jpeg', 'caballero', 136000, 115000, '2026-09-14'],
            ['QUB-001', 'Reloj Cubano para caballero', 'Qubano.jpeg', 'caballero', 90000, 86000, '2026-02-16'],
            ['FW-001', 'Reloj FairWhale para caballero', 'FairWhale.jpeg', 'caballero', 175000, 160000, '2025-05-08'],
            ['GFX-001', 'Reloj G-Fox Automático para caballero', 'G-Fox-Automatico.jpeg', 'caballero', 145000, 140000, '2025-09-18'],
            ['FBX-001', 'Reloj FoxBox para caballero', 'FoxBox.jpeg', 'caballero', 150000, 145000, '2025-03-26'],
        ];

        foreach ($watches as [$sku, , , $audience]) {
            if (! isset($categoryByAudience[$audience])) {
                throw new RuntimeException('No existe una categoría activa vigente para el público '.$audience.'.');
            }
        }

        DB::transaction(function () use ($watches, $categoryByAudience): void {
            foreach ($watches as [$sku, $name, $image, $audience, $price, $offer, $createdAt]) {
                // Si el SKU ya está en la base, conservar todos sus datos actuales.
                if (Product::query()->where('codigo_sku', $sku)->exists()) {
                    continue;
                }

                Product::create([
                    'id_categoria' => $categoryByAudience[$audience],
                    'codigo_sku' => $sku,
                    'nombre' => $name,
                    'descripcion' => null,
                    'precio' => $price,
                    'precio_oferta' => $offer,
                    'url_imagen' => 'assets/images/store/'.$image,
                    'publico' => $audience,
                    'tamano_esfera' => null,
                    'esta_activo' => true,
                    'creado_en' => $createdAt,
                ]);
            }
        });
    }
}
