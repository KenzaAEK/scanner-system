<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Niveau extends Model
{
    use HasFactory;
    
    protected $table = 'niveau';
    protected $primaryKey = 'id_niveau';
    
    protected $fillable = [
        'nom_niveau'
    ];
    
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'id_niveau');
    }
    
    public function presences()
    {
        return $this->hasMany(Presence::class, 'id_niveau');
    }
}