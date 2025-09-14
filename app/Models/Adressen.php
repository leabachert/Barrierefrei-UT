<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adressen extends Model {
    protected $table = 'adressen';
    protected $fillable = [
        'gebaeude_id',
        'adresse',
        'latitude',
        'longitude'
    ];

    public function gebaeude(): BelongsTo {
        return $this->belongsTo(Gebaeude::class, 'gebaeude_id');
    }
}
