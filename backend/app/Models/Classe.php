<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classe';
    protected $primaryKey = 'classe_id';
    public $timestamps = false;

    protected $fillable = ['nom_classe'];

    public function presences()
    {
        return $this->hasMany(Presence::class, 'classe_id');
    }
}
