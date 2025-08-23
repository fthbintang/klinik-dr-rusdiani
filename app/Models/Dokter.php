<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokter extends Model
{
    use HasFactory;
    
    protected $table = 'dokter';
    protected $guarded = ['id'];

    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }
}