<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cancelacion_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pedido')->constrained('pedidos')->onDelete('cascade');
            $table->string('motivo')->nullable();
            $table->dateTime('fechaCancelacion')->nullable();
            $table->string('autorizacion')->nullable(); // puede ser mesero, sistema, admin
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cancelacion_pedido');
    }
};
