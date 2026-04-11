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
        Schema::create('bukus', function (Blueprint $table) {
            $table->bigIncrements('id_buku');
            $table->string('judul_buku');
            $table->string('penulis');
            $table->string('slug_buku')->unique();
            $table->string('gambar_buku')->nullable();
            $table->string('penerbit');
            $table->integer('tahun_terbit');
            $table->integer('stok')->default(0);
            $table->enum('status', ['tersedia', 'dipinjam']);
            $table->enum('kategori', ['novel', 'komik', 'pengetahuan', 'sejarah']);
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
