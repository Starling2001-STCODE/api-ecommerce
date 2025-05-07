<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_inventory_transaction', function (Blueprint $table) {
            $table->ulid('inventory_transaction_id');
            $table->ulid('product_variant_id');

            $table->unsignedInteger('quantity')->default(0);
            $table->decimal('cost_price', 10, 2)->nullable(); 
            $table->decimal('sale_price', 10, 2)->nullable(); 

            $table->timestamps();

            $table->primary(['inventory_transaction_id', 'product_variant_id']);

            $table->foreign('inventory_transaction_id')->references('id')->on('inventory_transactions')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_inventory_transaction');
    }
};
