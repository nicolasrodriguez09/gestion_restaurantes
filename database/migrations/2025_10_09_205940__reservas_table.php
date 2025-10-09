<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('nombreCliente', 100);
            $table->string('telefonoCliente', 20);
            $table->foreignId('id_mesa')->constrained('mesas')->onDelete('cascade');
            $table->dateTime('fechaReserva');
            $table->foreignId('id_estadoReserva')->constrained('estado_reserva')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservas');
    }
};
