<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'etudiant';
    protected $primaryKey = 'code_apoge';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['code_apoge', 'nom', 'prenom', 'niveau_id'];

    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class, 'code_apoge', 'code_apoge');
    }
}
