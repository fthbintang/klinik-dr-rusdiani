<?php

namespace App\Models;

use App\Models\Pasien;
use App\Models\ResepObat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $guarded = ['id'];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function resep_obat(): HasMany
    {
        return $this->hasMany(ResepObat::class);
    }
}