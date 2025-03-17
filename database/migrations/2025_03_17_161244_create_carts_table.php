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
        Schema::create('carts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('session_id')->nullable(); // Identificador de sesión para usuarios no registrados
            $table->enum('status', ['active', 'completed', 'abandoned'])->default('active'); // Estado del carrito
            // Campo (Foreign Key)
            $table->ulid('user_id');
            // Referencias (Foreign Key)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
