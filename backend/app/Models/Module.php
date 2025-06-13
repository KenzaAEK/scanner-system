<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'module';
    protected $primaryKey = 'module_id';
    public $timestamps = false;

    protected $fillable = ['nom_module'];

    public function presences()
    {
        return $this->hasMany(Presence::class, 'module_id');
    }
}
