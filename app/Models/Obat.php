<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;
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
    
}