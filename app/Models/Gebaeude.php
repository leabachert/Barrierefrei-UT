<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gebaeude extends Model {
    protected $table = 'gebaeude';
    protected $fillable = [
        'name',
        'bereich',
        'infos'
    ];

    public function adressen(): HasOne {
        return $this->hasOne(Adressen::class);
    }

    public function infosAussen(): HasOne {
        return $this->hasOne(InfosAussen::class);
    }

    public function infosInnen(): HasOne {
        return $this->hasOne(InfosInnen::class);
    }

    public function grundrisse(): HasOne {
        return $this->hasOne(Grundrisse::class);
    }

    public static function findeGebaeudeInDerNahe($latitude, $longitude, $maxDist = 0.1)
    {
        return self::join('adressen', 'gebaeude.id', '=', 'adressen.gebaeude_id')
            ->whereNotNull('adressen.latitude')
            ->whereNotNull('adressen.longitude')
            ->select('gebaeude.*', 'adressen.latitude', 'adressen.longitude')
            ->selectRaw("
            (
                6371 * acos(
                    cos(radians(?)) * cos(radians(adressen.latitude)) *
                    cos(radians(adressen.longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(adressen.latitude))
                )
            ) AS distance
        ", [$latitude, $longitude, $latitude])
            ->having('distance', '<', $maxDist)
            ->orderBy('distance')
            ->first();
    }
}
