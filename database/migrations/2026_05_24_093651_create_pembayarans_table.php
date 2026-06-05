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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_reservasi');
            $table->decimal('total_awal', 10, 2);
            $table->decimal('dp', 10, 2)->default(0);
            $table->decimal('bayar', 10, 2)->default(0);
            $table->decimal('kembali', 10, 2)->default(0);
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_kasir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
