<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $table = 'presence';
    protected $primaryKey = 'presence_id';
    public $timestamps = false;

    protected $fillable = [
        'code_apoge',
        'date',
        'module_id',
        'classe_id',
        'nbr_present'
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'code_apoge', 'code_apoge');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }
}
