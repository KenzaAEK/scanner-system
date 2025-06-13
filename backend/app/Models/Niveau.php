<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $table = 'niveau';
    protected $primaryKey = 'niveau_id';
    public $timestamps = false;

    protected $fillable = ['nom_niveau'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'niveau_id');
    }
}
