<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $ropa = Category::create(['name' => 'Botellas']);

        $color = Attribute::where('name', 'color')->first();
        //$size = Attribute::where('name', 'talla')->first();

        // Asociar atributos a categoría
        $ropa->attributes()->attach([
            $color->id => ['id' => Str::ulid(), 'required' => true],
           // $size->id => ['id' => Str::ulid(), 'required' => true],
        ]);
    }
}
