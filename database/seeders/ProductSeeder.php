<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = Category::pluck('id_categoria', 'nombre');

        // sku, nombre, imagen, público, colección, precio normal, precio oferta, fecha
        $relojes = [
            ['CUR-H-001', 'Reloj marca Curren para caballero', 'Curren-Hombre.jpeg', 'caballero', 'Clásica',   175000, 160000, '2025-11-06'],
            ['CUR-D-001', 'Reloj marca Curren para mujer',     'Curren-Dama.jpeg',   'dama',      'Elegante',  136000, 130000, '2025-08-29'],
            ['QQ-001',    'Reloj marca Q&Q',                   'Q&Q.jpeg',           'caballero', 'Clásica',    90000,  86000, '2026-03-01'],
            ['ROL-001',   'Reloj marca Rolex para caballero',  'Rolex.jpeg',         'caballero', 'Elegante',  135000, 120000, '2026-06-15'],
            ['CK-001',    'Reloj marca Calvin Klein para caballero', 'Calvin-Klein.jpeg', 'caballero', 'Elegante', 25000, 20000, '2025-06-06'],
            ['PAN-001',   'Reloj marca Pandora para dama',     'Pandora.jpeg',       'dama',      'Elegante',   38000,  35000, '2025-12-09'],
            ['NAV-001',   'Reloj Naviforce para caballero',    'Naviforce.jpeg',     'caballero', 'Deportiva', 136000, 115000, '2026-09-14'],
            ['QUB-001',   'Reloj Cubano para caballero',       'Qubano.jpeg',        'caballero', 'Clásica',    90000,  86000, '2026-02-16'],
            ['FW-001',    'Reloj FairWhale para caballero',    'FairWhale.jpeg',     'caballero', 'Clásica',   175000, 160000, '2025-05-08'],
            ['GFX-001',   'Reloj G-Fox Automático para caballero', 'G-Fox-Automatico.jpeg', 'caballero', 'Elegante', 145000, 140000, '2025-09-18'],
            ['FBX-001',   'Reloj FoxBox para caballero',       'FoxBox.jpeg',        'caballero', 'Deportiva', 150000, 145000, '2025-03-26'],
        ];

        foreach ($relojes as [$sku, $nombre, $img, $publico, $coleccion, $precio, $oferta, $fecha]) {
            $p = Product::firstOrNew(['codigo_sku' => $sku]);
            $p->fill([
                'id_categoria'  => $categorias[$coleccion],
                'nombre'        => $nombre,
                'descripcion'   => "{$nombre}. Descripción pendiente.",
                'precio'        => $precio,
                'precio_oferta' => $oferta,
                'url_imagen'    => 'assets/images/store/'.$img,
                'publico'       => $publico,
                'tamano_esfera' => 'mediano',
                'esta_activo'   => true,
            ]);

            if (! $p->exists) {
                $p->creado_en = $fecha;
            }

            $p->save();
        }
    }
}
