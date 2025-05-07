<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_variant_attribute_value', function (Blueprint $table) {
            $table->ulid('attribute_id')->after('product_variant_id');
    
            $table->foreign('attribute_id')
                  ->references('id')
                  ->on('attributes')
                  ->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('product_variant_attribute_value', function (Blueprint $table) {
            $table->dropForeign(['attribute_id']);
            $table->dropColumn('attribute_id');
        });
    }
    
};
