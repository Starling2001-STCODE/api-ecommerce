<?php

namespace Database\Factories;

use App\Models\{
    Product,
    ProductVariant,
    Attribute,
    AttributeValue,
    ProductVariantAttributeValue,
    Inventory
};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;


class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'id' => Str::ulid(),
            'name' => 'Producto ' . fake()->unique()->words(3, true) . ' ' . Str::random(6),
            'description' => fake()->sentence(12),
            'cost_price' => fake()->randomFloat(2, 10, 50),
            'sale_price' => fake()->randomFloat(2, 60, 120),
            'brand' => fake()->randomElement(['BodyFitt', 'SteelWear', 'TechFit']),
            'weight' => fake()->randomFloat(2, 0.1, 2),
            'dimensions' => fake()->numberBetween(10, 50) . 'x' . fake()->numberBetween(10, 50) . 'cm',
            'status' => 'active',
            'featured' => fake()->boolean(),
            'rating_average' => fake()->randomFloat(2, 3.5, 5.0),
            'tags' => fake()->randomElements(['nuevo', 'oferta', 'popular'], 2),
            'category_id' => '01JSAE1385BAFNVXYQG5RNJPNP', 
            'size_id' => '01JSAEMZ1P5SRJ5MH390Q75BJ6',
            'user_id' => '01JSADVF0B1MBAWYVXG8Y8YX6F',
        ];
    }

    // public function configure(): static
    // {
    //     return $this->afterCreating(function (Product $product) {
    //         $attributes = Attribute::whereHas('categories', function ($q) use ($product) {
    //             $q->where('category_id', $product->category_id)
    //               ->where('attribute_category.required', true);
    //         })->with('values')->get();
    
    //         foreach (range(1, 10) as $i) {
    //             $sku = 'VAR-' . Str::ulid()->toBase32(); 
                    
    //             $variant = ProductVariant::create([
    //                 'product_id' => $product->id,
    //                 'sku' => $sku,
    //                 'price' => fake()->randomFloat(2, 60, 120),
    //                 'cost_price' => fake()->randomFloat(2, 10, 50),
    //                 'sale_price' => fake()->randomFloat(2, 80, 140),
    //                 'is_active' => true,
    //             ]);
    
    //             foreach ($attributes as $attribute) {
    //                 $value = $attribute->values->random();
    //                 ProductVariantAttributeValue::create([
    //                     'product_variant_id' => $variant->id,
    //                     'attribute_id' => $attribute->id,
    //                     'attribute_value_id' => $value->id,
    //                 ]);
    //             }
    
    //             Inventory::create([
    //                 'product_variant_id' => $variant->id,
    //                 'quantity' => fake()->numberBetween(10, 50),
    //                 'minimum_stock' => 5,
    //             ]);
    
    //             $images = [];
    //             foreach (range(1, 7) as $index) {
    //                 $images[] = UploadedFile::fake()->image("{$sku}-img{$index}.jpg", 500, 500);
    //             }
    
    //             app(\App\VariantImage\Domain\Services\UploadVariantImageService::class)
    //                 ->execute($variant->id, $sku, $images);
    //         }
    //     });
    // }
    
    public function configure(): static
{
    return $this->afterCreating(function (Product $product) {
        $attributes = Attribute::whereHas('categories', function ($q) use ($product) {
            $q->where('category_id', $product->category_id)
              ->where('attribute_category.required', true);
        })->with('values')->get();

        $usedValueIds = [];

        foreach (range(1, 10) as $i) {
            $sku = 'VAR-' . Str::ulid()->toBase32();

            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'sku' => $sku,
                'price' => fake()->randomFloat(2, 60, 120),
                'cost_price' => fake()->randomFloat(2, 10, 50),
                'sale_price' => fake()->randomFloat(2, 80, 140),
                'is_active' => true,
            ]);

            foreach ($attributes as $attribute) {
                $value = $attribute->values->random();
                $usedValueIds[$value->id] = $attribute->name;
                ProductVariantAttributeValue::create([
                    'product_variant_id' => $variant->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => $value->id,
                ]);
            }

            Inventory::create([
                'product_variant_id' => $variant->id,
                'quantity' => fake()->numberBetween(10, 50),
                'minimum_stock' => 5,
            ]);
        }

        foreach ($usedValueIds as $attributeValueId => $attrName) {
            if (strtolower($attrName) !== 'color') {
                continue;
            }
        
            $images = [];
            foreach (range(1, 3) as $index) {
                $images[] = UploadedFile::fake()->image("{$attrName}-{$attributeValueId}-{$index}.jpg", 500, 500);
            }
            app(\App\AttributeValueImage\Domain\Services\UpdateAttributeValueImageService::class)
                ->execute(
                    productId: $product->id,
                    attributeValueId: $attributeValueId,
                    productName: $product->name,
                    images: $images
                );
        }
    });
}

}
