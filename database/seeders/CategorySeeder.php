<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $ropa = Category::create(['name' => 'Ropa']);

        $color = Attribute::where('name', 'color')->first();
        $size = Attribute::where('name', 'talla')->first();

        // Asociar atributos a categoría
        $ropa->attributes()->attach([
            $color->id => ['required' => true],
            $size->id => ['required' => true],
        ]);
    }
}
