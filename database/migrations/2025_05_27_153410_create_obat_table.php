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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->string('kategori');
            $table->string('satuan');
            $table->integer('stok');
            $table->integer('harga');
            $table->date('expired_date');
            $table->foreignId('supplier_id')->nullable()->constrained('supplier')->onDelete('set null');
            $table->text('keterangan')->nullable();
            $table->boolean('obat_bebas')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};