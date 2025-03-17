<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name'); // Nombre del producto
            $table->text('description')->nullable(); // Descripción del producto
            $table->decimal('cost_price', 10, 2); // Precio costo
            $table->decimal('sale_price', 10, 2); // Precio de venta
            $table->string('sku')->unique(); // SKU único del producto
            $table->string('brand')->nullable(); // Marca del producto
            $table->decimal('weight', 8, 2)->nullable(); // Peso del producto
            $table->string('dimensions')->nullable(); // Dimensiones del producto
            $table->enum('status', ['active', 'inactive'])->default('active'); // Estado del producto
            $table->boolean('featured')->default(false); // ¿Es un producto destacado?
            $table->decimal('rating_average', 3, 2)->default(0); // Calificación promedio
            $table->json('tags')->nullable(); // Etiquetas o palabras clave
            //
            $table->ulid('category_id');
            $table->ulid('size_id');
            $table->ulid('user_id');
            //
            $table->timestamps();
            $table->unique(['name', 'size_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
