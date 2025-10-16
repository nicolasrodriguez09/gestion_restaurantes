<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ----------- ESTADO_MESA -----------
        Schema::create('estado_mesa', function (Blueprint $table) {
            $table->id();
            $table->string('nombreEstado', 50);
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        // ----------- MESA -----------
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();
            $table->integer('numeroMesa');
            $table->integer('capacidad');
            $table->string('ubicacion')->nullable();
            $table->foreignId('id_estado')->constrained('estado_mesa')->onDelete('cascade');
            $table->timestamps();
        });

        // ----------- ESTADO_RESERVA -----------
        Schema::create('estado_reserva', function (Blueprint $table) {
            $table->id();
            $table->string('nombreEstado', 50);
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        // ----------- RESERVA -----------
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('nombreCliente', 100);
            $table->string('telefonoCliente', 20);
            $table->foreignId('id_mesa')->constrained('mesas')->onDelete('cascade');
            $table->dateTime('fechaReserva');
            $table->foreignId('id_estadoReserva')->constrained('estado_reserva')->onDelete('cascade');
            $table->timestamps();
        });

        // ----------- PRODUCTO -----------
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombreProducto', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->string('categoria', 50)->nullable();
            $table->boolean('disponibilidad')->default(true);
            $table->timestamps();
        });

        // ----------- ESTADO_PEDIDO -----------
        Schema::create('estado_pedido', function (Blueprint $table) {
            $table->id();
            $table->string('nombreEstado', 50);
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        // ----------- PEDIDO -----------
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mesero')->constrained('users')->onDelete('cascade'); // Usa la tabla 'users' de Laravel
            $table->foreignId('id_mesa')->constrained('mesas')->onDelete('cascade');
            $table->foreignId('id_estadoPedido')->constrained('estado_pedido')->onDelete('cascade');
            $table->dateTime('fechaPedido');
            $table->decimal('totalPago', 10, 2)->default(0);
            $table->timestamps();
        });

        // ----------- DETALLE_PEDIDO -----------
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pedido')->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precioUnitario', 10, 2);
            $table->decimal('subTotal', 10, 2);
            $table->timestamps();
        });

        // ----------- CANCELACION_PEDIDO -----------
        Schema::create('cancelacion_pedido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pedido')->constrained('pedidos')->onDelete('cascade');
            $table->string('motivo')->nullable();
            $table->dateTime('fechaCancelacion')->nullable();
            $table->string('autorizacion')->nullable(); // mesero, admin o sistema
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cancelacion_pedido');
        Schema::dropIfExists('detalle_pedido');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('estado_pedido');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('reservas');
        Schema::dropIfExists('estado_reserva');
        Schema::dropIfExists('mesas');
        Schema::dropIfExists('estado_mesa');
    }
};
