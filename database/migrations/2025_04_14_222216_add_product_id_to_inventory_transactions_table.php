<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->ulid('product_id')->nullable()->after('id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->ulid('product_variant_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            $table->ulid('product_variant_id')->nullable(false)->change();
        });
    }
};

