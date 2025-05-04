<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('addresses');
    }

    public function down(): void
    {
        // (opcional) Puedes dejar el `down` vacío o recrear la tabla anterior si quieres.
    }
};
