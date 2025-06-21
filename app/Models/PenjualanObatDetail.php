<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanObatDetail extends Model
{
    use HasFactory;
    
    protected $table = 'penjualan_obat_detail';
    protected $guarded = ['id'];

    public function penjualan_obat(): BelongsTo
    {
        return $this->belongsTo(PenjualanObat::class);
    }

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class);
    }
}