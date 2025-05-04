<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('display_order_id')->unique();
            $table->foreignUlid('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', [
                'pending_payment',
                'paid',
                'pending_shipping',
                'shipped',
                'delivered',
                'cancelled',
            ])->default('pending_payment');
            $table->string('session_id')->nullable()->unique();
            $table->text('checkout_url')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
