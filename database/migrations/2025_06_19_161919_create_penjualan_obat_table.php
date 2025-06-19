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
        Schema::create('penjualan_obat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi');
            $table->foreignId('pasien_id')->nullable()->constrained('pasien');
            $table->date('tanggal_transaksi');
            $table->integer('total_harga');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_obat');
    }
};