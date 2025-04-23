<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('variant_images', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('product_variant_id');
            $table->string('url');
            
            $table->timestamps();

            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_images');
    }
};
