<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'obat';
    protected $guarded = ['id'];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function resep_obat(): HasMany
    {
        return $this->hasMany(ResepObat::class);
    }

    public function obat_masuk(): HasMany
    {
        return $this->hasMany(ObatMasuk::class)->withTrashed();
    }

    public function obat_keluar(): HasMany
    {
        return $this->hasMany(ObatKeluar::class)->withTrashed();
    }
    
}