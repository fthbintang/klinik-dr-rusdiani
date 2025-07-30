<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenjualanObat extends Model
{
    use HasFactory;
    
    protected $table = 'penjualan_obat';
    protected $guarded = ['id'];

    public function penjualan_obat_detail(): HasMany
    {
        return $this->HasMany(PenjualanObatDetail::class);
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class)->withTrashed();
    }
}