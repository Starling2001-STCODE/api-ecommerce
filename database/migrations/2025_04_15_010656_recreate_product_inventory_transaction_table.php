<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('product_inventory_transaction');

        Schema::create('product_inventory_transaction', function (Blueprint $table) {
            $table->id(); // clave primaria auto incremental

            $table->ulid('inventory_transaction_id');
            $table->ulid('product_id')->nullable();
            $table->ulid('product_variant_id')->nullable();

            $table->unsignedInteger('quantity')->default(0);
            $table->decimal('cost_price', 10, 2)->nullable(); // para compras
            $table->decimal('sale_price', 10, 2)->nullable(); // para ventas

            $table->timestamps();

            $table->foreign('inventory_transaction_id')->references('id')->on('inventory_transactions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_inventory_transaction');
    }
};
