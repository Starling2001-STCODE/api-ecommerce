<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->ulid('product_id')->nullable()->change();
            $table->ulid('product_variant_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->ulid('product_id')->nullable(false)->change();
            $table->ulid('product_variant_id')->nullable(false)->change();
        });
    }
};
