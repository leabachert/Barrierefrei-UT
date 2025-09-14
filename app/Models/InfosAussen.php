<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfosAussen extends Model {
    protected $table = 'infos_aussen';
    protected $fillable = [
        'gebaeude_id',
        'barrierefrei',
        'eingang',
        'tueroeffner',
        'haltestelle',
        'parkplatz',
        'parkplatz_ort',
        'wegbeschaffenheit',
        'blindenleitsystem',
        'infosaeule',
        'infosaeule_ort'
    ];

    public function gebaeude(): BelongsTo {
        return $this->belongsTo(Gebaeude::class, 'gebaeude_id');
    }
}
