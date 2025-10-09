<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mesero')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('id_mesa')->constrained('mesas')->onDelete('cascade');
            $table->foreignId('id_estadoPedido')->constrained('estado_pedido')->onDelete('cascade');
            $table->dateTime('fechaPedido');
            $table->decimal('totalPago', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pedidos');
    }
};
