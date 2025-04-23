<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_inventory_transaction', function (Blueprint $table) {
            $table->dropPrimary(['inventory_transaction_id', 'product_variant_id']);
            $table->ulid('id')->primary()->first();
            $table->ulid('product_variant_id')->nullable()->change();
            $table->ulid('product_id')->nullable()->after('inventory_transaction_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('product_inventory_transaction', function (Blueprint $table) {
            $table->dropPrimary(['id']);
            $table->dropColumn('id');
            $table->ulid('product_variant_id')->nullable(false)->change();
            $table->primary(['inventory_transaction_id', 'product_variant_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};


