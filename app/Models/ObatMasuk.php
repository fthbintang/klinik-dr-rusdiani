<?php

namespace App\Models;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObatMasuk extends Model
{
    protected $table = 'obat_masuk';
    protected $guarded = ['id'];
    
    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class);
    }
}