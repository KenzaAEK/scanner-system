<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiant';
    protected $primaryKey = 'code_apoge';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code_apoge',
        'nom',
        'prenom',
        'id_niveau',
        'id_classe',
        'email',
        'telephone'
    ];

    /**
     * Relation avec le niveau
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'id_niveau');
    }

    /**
     * Relation avec la classe
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'id_classe');
    }

    /**
     * Relation avec les présences
     */
    public function presences()
    {
        return $this->hasMany(Presence::class, 'code_apoge');
    }

    /**
     * Scope pour rechercher un étudiant par nom ou prénom
     */
    public function scopeSearchByName($query, $search)
    {
        return $query->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('prenom', 'like', '%' . $search . '%')
                    ->orWhere('code_apoge', 'like', '%' . $search . '%');
    }

    /**
     * Scope pour filtrer par niveau
     */
    public function scopeByNiveau($query, $niveauId)
    {
        return $query->where('id_niveau', $niveauId);
    }

    /**
     * Scope pour filtrer par classe
     */
    public function scopeByClasse($query, $classeId)
    {
        return $query->where('id_classe', $classeId);
    }

    /**
     * Accessor pour le nom complet
     */
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Accessor pour les initiales
     */
    public function getInitialesAttribute()
    {
        return strtoupper(substr($this->prenom, 0, 1) . substr($this->nom, 0, 1));
    }

    /**
     * Méthode pour calculer le taux de présence d'un étudiant
     */
    public function getTauxPresence($moduleId = null, $dateDebut = null, $dateFin = null)
    {
        $query = $this->presences();

        if ($moduleId) {
            $query->where('id_module', $moduleId);
        }

        if ($dateDebut) {
            $query->where('date', '>=', $dateDebut);
        }

        if ($dateFin) {
            $query->where('date', '<=', $dateFin);
        }

        $totalSeances = $query->count();
        $totalPresences = $query->sum('nbr_present');

        return $totalSeances > 0 ? round(($totalPresences / $totalSeances) * 100, 2) : 0;
    }

    /**
     * Méthode pour obtenir les présences par module
     */
    public function getPresencesByModule()
    {
        return $this->presences()
            ->selectRaw('id_module, COUNT(*) as total_seances, SUM(nbr_present) as total_presents')
            ->groupBy('id_module')
            ->with('module')
            ->get();
    }

    /**
     * Méthode pour vérifier si l'étudiant était présent à une date donnée
     */
    public function estPresentLe($date, $moduleId = null)
    {
        $query = $this->presences()->where('date', $date);
        
        if ($moduleId) {
            $query->where('id_module', $moduleId);
        }

        return $query->where('nbr_present', '>', 0)->exists();
    }
}