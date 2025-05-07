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
        $sinVarinate = Category::create(['name' => 'sinVarinate']);
        $conMasDeUnaVariante = Category::create(['name' => 'conVariante']);
        $conUnaVariante = Category::create(['name' => 'conUnaVariante']);

        $color = Attribute::where('name', 'color')->first();
        $size = Attribute::where('name', 'talla')->first();

        $conMasDeUnaVariante->attributes()->attach([
            $color->id => ['id' => Str::ulid(), 'required' => true],
            $size->id => ['id' => Str::ulid(), 'required' => true],
        ]);
        $conUnaVariante->attributes()->attach([
            $color->id => ['id' => Str::ulid(), 'required' => true],
            //$size->id => ['id' => Str::ulid(), 'required' => true],
        ]);

    }
}
