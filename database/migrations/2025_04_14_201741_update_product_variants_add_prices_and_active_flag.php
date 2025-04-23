<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('cost_price', 10, 2)->nullable()->after('price');
            $table->decimal('sale_price', 10, 2)->nullable()->after('cost_price');
            $table->boolean('is_active')->default(true)->after('sale_price');

            if (Schema::hasColumn('product_variants', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['cost_price', 'sale_price', 'is_active']);

            $table->integer('stock')->default(0);
        });
    }
};

