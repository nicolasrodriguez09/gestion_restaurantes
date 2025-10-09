<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('estado_pedido', function (Blueprint $table) {
            $table->id();
            $table->string('nombreEstado', 50);
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('estado_pedido');
    }
};
