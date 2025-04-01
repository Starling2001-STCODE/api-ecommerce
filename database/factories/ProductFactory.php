<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
           '01JQAHSQ9841MG5J7QHTR2G9T1',
        ];
        $img = [
            'accesorios_04',
            'apple-watch',
            'bolso_10',
            'CAMISETA_01',
            'chaqueta_05',
            'Movil_07',
            'pelota_09',
            'reloj_02',
            'smarphone_03',
            'sombrero_06',
            'lampara_08',
         ];
 

        $brands = ['BodyFitt', 'SunVision', 'SteelWear', 'BlueDenim', 'UrbanStyle', 'FitWear', 'SoundPro', 'TechFit', 'GameTech'];
        $tags = ['nuevo', 'oferta', 'popular', 'eco', 'limitado', 'edición especial'];

        return [
            'id' => Str::ulid(),
            'name' => 'Producto ' . fake()->unique()->words(3, true),
            'description' => $this->faker->sentence(12),
            'cost_price' => $this->faker->randomFloat(2, 3, 30),
            'sale_price' => $this->faker->randomFloat(2, 35, 80),
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'brand' => $this->faker->randomElement($brands),
            'weight' => $this->faker->randomFloat(2, 0.1, 2),
            'dimensions' => $this->faker->numberBetween(10, 50) . 'x' . $this->faker->numberBetween(10, 50) . 'cm',
            'status' => 'active',
            'featured' => $this->faker->boolean(),
            'rating_average' => $this->faker->randomFloat(2, 3.0, 5.0),
            'tags' => json_encode($this->faker->randomElements($tags, 3)),
            'category_id' => $this->faker->randomElement($categories),
            'img' => $this->faker->randomElement($img),
            'size_id' => '01JQAHSQ9N58J331FZ9V5Z004D',
            'user_id' => '01JQAHSQQT8ZKGHWQ4MRD0QP36',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
