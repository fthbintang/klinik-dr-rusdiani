<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalDokter extends Model
{
    protected $table = 'jadwal_dokter';
    protected $guarded = ['id'];

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }
}