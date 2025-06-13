<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presence extends Model
{
    use HasFactory;
    
    protected $table = 'presence';
    
    protected $fillable = [
        'code_apoge',
        'date',
        'id_module',
        'id_niveau',
        'nbr_present'
    ];
    
    protected $casts = [
        'date' => 'date',
    ];
    
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'code_apoge');
    }
    
    public function module()
    {
        return $this->belongsTo(Module::class, 'id_module');
    }
    
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'id_niveau');
    }
}