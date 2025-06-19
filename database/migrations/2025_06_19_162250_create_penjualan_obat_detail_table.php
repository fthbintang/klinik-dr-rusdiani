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
        Schema::create('penjualan_obat_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_obat_id')->constrained('penjualan_obat')->onDelete('cascade');
            $table->foreignId('obat_id')->constrained('obat');
            $table->integer('kuantitas');
            $table->integer('harga_final');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_obat_detail');
    }
};