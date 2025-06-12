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
        Schema::create('obat_masuk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_obat_masuk');
            $table->foreignId('obat_id')->constrained('obat');
            $table->integer('stok_awal');
            $table->integer('stok_masuk');
            $table->integer('stok_final');
            $table->foreignId('supplier_id')->constrained('supplier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_masuk');
    }
};