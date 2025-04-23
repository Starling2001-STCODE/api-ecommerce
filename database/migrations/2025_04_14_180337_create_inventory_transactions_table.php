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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
        
            $table->ulid('product_variant_id');
            $table->enum('type', ['compra', 'ajuste', 'venta', 'devolucion'])->index();
            $table->string('invoice_number')->nullable();
            $table->text('note')->nullable();
        
            $table->ulid('user_id')->nullable();
            $table->timestamps();
        
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
