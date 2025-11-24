<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->decimal('cliente_lat', 11, 8)->nullable()->after('cliente_nota');
            $table->decimal('cliente_lng', 11, 8)->nullable()->after('cliente_lat');
            $table->string('cliente_place_id')->nullable()->after('cliente_lng');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['cliente_lat', 'cliente_lng', 'cliente_place_id']);
        });
    }
};
