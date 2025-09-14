<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfosInnen extends Model {
    protected $table = 'infos_innen';

    protected $fillable = [
        'gebaeude_id',
        'aufzug',
        'toilette',
        'infosaeule',
        'infosaeule_ort',
        'blindenleitsystem',
        'raumzugang',
        'sitzplaetze',
        'sitzplaetze_raum',
        'induktionsschleife',
        'induktionsschleife_raum',
        'ruheraum',
        'ruheraum_raum',
        'sanitaetsraum',
        'sanitaetsraum_raum',
    ];

    public function gebaeude(): BelongsTo {
        return $this->belongsTo(Gebaeude::class, 'gebaeude_id');
    }
}
