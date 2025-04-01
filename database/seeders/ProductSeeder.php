<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $total = 100000;
        $batch = 1000;

        for ($i = 0; $i < $total; $i += $batch) {
            Product::factory()->count($batch)->create();
            echo "Insertados " . ($i + $batch) . " productos...\n";
        }

        // $category = Category::where('name', 'ropa')->first();
        // $size = Size::create(['name' => 'pequeño']);
        // $user = User::factory()->create([
        //     'name' => 'test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'),
        //     'username' => 'test',
        //     'role' => 'director',
        // ]);

        // $product = Product::create([
        //     'name' => 'Camiseta Básica',
        //     'description' => 'Camiseta de algodón suave',
        //     'cost_price' => 200,
        //     'sale_price' => 500,
        //     'sku' => 'TSHIRT001',
        //     'brand' => 'BodyFitt',
        //     'weight' => 0.2,
        //     'dimensions' => '30x20x2',
        //     'status' => 'active',
        //     'featured' => true,
        //     'rating_average' => 4.5,
        //     'tags' => json_encode(['camiseta', 'ropa']),
        //     'category_id' => $category->id,
        //     'size_id' => $size->id,
        //     'user_id' => $user->id,
        // ]);

        // // Crear variante combinando atributos
        // $colorRojo = AttributeValue::where('value', 'Rojo')->first();
        // $tallaM = AttributeValue::where('value', 'M')->first();

        // $variant = ProductVariant::create([
        //     'product_id' => $product->id,
        //     'sku' => 'TSHIRT001-RM',
        //     'price' => 500,
        //     'stock' => 10,
        // ]);

        // $variant->attributeValues()->attach([$colorRojo->id, $tallaM->id]);
    }
}
