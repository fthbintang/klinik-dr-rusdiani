<?php

namespace App\Models;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObatKeluar extends Model
{
    protected $table = 'obat_keluar';
    protected $guarded = ['id'];

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class)->withTrashed();
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class)->withTrashed();
    }
}