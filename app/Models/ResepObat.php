<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResepObat extends Model
{
    use HasFactory;

    protected $table = 'resep_obat';
    protected $guarded = ['id'];

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class);
    }
}