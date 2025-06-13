<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pasien';
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rekam_medis(): HasOne
    {
        return $this->hasOne(RekamMedis::class);
    }

    public function obat_keluar(): HasMany
    {
        return $this->hasMany(ObatKeluar::class)->withTrashed();
    }
}