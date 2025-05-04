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
        // Schema::create('orders', function (Blueprint $table) {
        //     $table->ulid('id')->primary();
        //     $table->string('user_id')->nullable()->constrained('users')->onDelete('set null');
        //     $table->string('status')->default('pending_payment');
        //     $table->string('session_id')->nullable()->unique();
        //     $table->text('checkout_url')->nullable();
        //     $table->timestamp('expires_at')->nullable();
        //     $table->decimal('total', 10, 2)->default(0);
        //     $table->timestamps();
        // });       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
