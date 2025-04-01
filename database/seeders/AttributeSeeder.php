<?php

namespace Database\Seeders;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $color = Attribute::create(['name' => 'Color']);
        $size = Attribute::create(['name' => 'Talla']);

        // Valores de Color
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Rojo']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Azul']);
        AttributeValue::create(['attribute_id' => $color->id, 'value' => 'Negro']);

        // Valores de Talla
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'S']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'M']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'L']);
        AttributeValue::create(['attribute_id' => $size->id, 'value' => 'XL']);
    }
}