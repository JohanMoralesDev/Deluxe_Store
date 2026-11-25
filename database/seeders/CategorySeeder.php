<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Clásica', 'Elegante', 'Deportiva'] as $nombre) {
            Category::firstOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => "Colección {$nombre}", 'esta_activa' => true]
            );
        }
    }
}