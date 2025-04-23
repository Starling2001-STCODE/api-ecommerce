<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attribute_category', function (Blueprint $table) {
            $table->ulid('id'); 
            $table->foreignUlid('attribute_id')->constrained('attributes')->cascadeOnDelete();
            $table->foreignUlid('category_id')->constrained('categories')->cascadeOnDelete();
            $table->boolean('required')->default(false);
            $table->timestamps();

            $table->unique(['attribute_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_category');
    }
};