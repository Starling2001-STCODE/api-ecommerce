<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $total = 1;
        $batch = 1;

        $start = Carbon::now();
        Log::channel('product_factory')->info("🚀 Inicio de inserción masiva de productos: {$start->toDateTimeString()}");

        for ($i = 0; $i < $total; $i += $batch) {
            Product::factory()->count($batch)->create();

            if (($i + $batch) % 500 === 0) {
                Log::channel('product_factory')->info("✅ Insertados: " . ($i + $batch) . " productos.");
            }
        }

        $end = Carbon::now();
        $duration = $start->diffForHumans($end, true); 
        Log::channel('product_factory')->info("🎉 Inserción completada a las {$end->toDateTimeString()} (Duración: {$duration})");
    }
}
