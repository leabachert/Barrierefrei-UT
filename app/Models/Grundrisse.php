<?php

 namespace App\Models;

 use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Relations\BelongsTo;


 class Grundrisse extends Model {

     protected $table = 'grundrisse';

     protected $fillable = [
         'gebaeude_id',
         'grundriss'
     ];

     public function gebaeude(): BelongsTo {
         return $this->belongsTo(Gebaeude::class, 'gebaeude_id');
     }
 }
