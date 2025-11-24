<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('cliente_nombre')->nullable()->after('stock_aplicado');
            $table->string('cliente_telefono')->nullable()->after('cliente_nombre');
            $table->string('cliente_direccion')->nullable()->after('cliente_telefono');
            $table->string('cliente_nota')->nullable()->after('cliente_direccion');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['cliente_nombre', 'cliente_telefono', 'cliente_direccion', 'cliente_nota']);
        });
    }
};
