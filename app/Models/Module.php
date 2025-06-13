<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_module';
    
    protected $fillable = [
        'nom_module',
        'code_module',
        'nb_heures_total',
        'type_module',
    ];

    protected $casts = [
        'nb_heures_total' => 'integer',
    ];

    // Relations
    public function niveaux()
    {
        return $this->belongsToMany(Niveau::class, 'niveau_module', 'id_module', 'id_niveau')
                    ->withPivot('coefficient', 'semestre')
                    ->withTimestamps();
    }

    public function seances()
    {
        return $this->hasMany(Seance::class, 'id_module', 'id_module');
    }
}
