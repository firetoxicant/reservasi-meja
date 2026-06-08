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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_menu', 40);
            $table->decimal('harga', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->unsignedTinyInteger('stok'); // tinyint(3) UNSIGNED
            $table->enum('kategori', ['makanan', 'minuman']);
            $table->string('gambar', 100)->nullable();
            $table->enum('status', ['tersedia', 'tidak tersedia']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
