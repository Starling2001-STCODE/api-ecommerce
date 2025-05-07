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
            $table->string('name'); 
            $table->text('description')->nullable(); 
            $table->decimal('cost_price', 10, 2); 
            $table->decimal('sale_price', 10, 2); 
            $table->string('sku')->unique(); 
            $table->string('brand')->nullable(); 
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable(); 
            $table->enum('status', ['active', 'inactive'])->default('active'); 
            $table->boolean('featured')->default(false);
            $table->decimal('rating_average', 3, 2)->default(0);
            $table->json('tags')->nullable();
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
