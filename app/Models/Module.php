<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $table = 'module';
    protected $primaryKey = 'id_module';
    
    protected $fillable = [
        'nom_module',
        'code_module',
        'description',
        'credits'
    ];

    /**
     * Relation avec les présences
     * Un module peut avoir plusieurs enregistrements de présence
     */
    public function presences()
    {
        return $this->hasMany(Presence::class, 'id_module');
    }

    /**
     * Relation avec les niveaux (many-to-many)
     * Un module peut être enseigné à plusieurs niveaux
     */
    public function niveaux()
    {
        return $this->belongsToMany(Niveau::class, 'module_niveau', 'id_module', 'id_niveau');
    }

    /**
     * Scope pour rechercher par nom de module
     */
    public function scopeByName($query, $name)
    {
        return $query->where('nom_module', 'like', '%' . $name . '%');
    }

    /**
     * Scope pour rechercher par code de module
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code_module', 'like', '%' . $code . '%');
    }

    /**
     * Accessor pour formater le nom du module
     */
    public function getNomModuleFormattedAttribute()
    {
        return ucwords(strtolower($this->nom_module));
    }

    /**
     * Méthode pour obtenir le nombre total de présences enregistrées pour ce module
     */
    public function getTotalPresencesAttribute()
    {
        return $this->presences()->sum('nbr_present');
    }

    /**
     * Méthode pour obtenir les statistiques de présence par niveau
     */
    public function getPresencesByNiveau()
    {
        return $this->presences()
            ->selectRaw('id_niveau, COUNT(*) as total_seances, SUM(nbr_present) as total_presents')
            ->groupBy('id_niveau')
            ->with('niveau')
            ->get();
    }

    /**
     * Méthode pour obtenir le taux de présence global du module
     */
    public function getTauxPresenceAttribute()
    {
        $totalSeances = $this->presences()->count();
        $totalPresents = $this->presences()->sum('nbr_present');
        
        if ($totalSeances == 0) {
            return 0;
        }
        
        // Supposons qu'en moyenne il y a 30 étudiants par séance
        $totalPossible = $totalSeances * 30;
        
        return round(($totalPresents / $totalPossible) * 100, 2);
    }
}