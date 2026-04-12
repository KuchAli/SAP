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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('id_tarif')->nullable();
            $table->decimal('total_bayar', 10, 0);
            $table->enum('jenis_transaksi', ['peminjaman', 'denda']);
            $table->date('tanggal_transaksi'); 
            $table->timestamps();

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman');
            $table->foreign('id_tarif')->references('id_tarif')->on('tarifs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
