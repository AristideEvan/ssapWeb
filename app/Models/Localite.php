<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Localite extends Model
{
    use HasFactory;
    protected $primaryKey = 'localite_id';
    // Définit le nom de la table si c'est différent du modèle
    protected $table = 'localites';

    // Définition des attributs modifiables
    protected $fillable = [
        'typeLocalite_id',
        'parent_id',
        'nomLocalite',
        'codeAlpha2',
        'codeAlpha3',
        'codeNum',
        'centroid',
    ];

    // Relation avec le modèle TypeLocalite
    public function typeLocalite()
    {
        return $this->belongsTo(TypeLocalite::class, 'typeLocalite_id');
    }

    /**
     * Relation avec la localité parente
     */
    public function parent()
    {
        return $this->belongsTo(Localite::class, 'parent_id');
    }

    /**
     * Relation avec les sous-localités (enfants)
     */
    public function enfants()
    {
        return $this->hasMany(Localite::class, 'parent_id');
    }

    public function getParentsAttribute()
    {
        if (!$this) {
            return collect([]);
        }
        $parent = optional($this)->parent->typeLocalite ?? null;
        $parents = collect([]);

        while ($parent) {
            $parents->push($parent);
            $parent = $parent->typeLocalite;
        }
        return $parents->unique('typeLocalite_id');
    }

    public function pratiques(): BelongsToMany
    {
        return $this->belongsToMany(Pratique::class, 'pratiquezoneapplis', 'localite_id', 'pratique_id')->withPivot('latitude', 'longitude', 'geom')->as('coordonnees');
    }
    
    public function estPremierGrandParent(Localite $localiteDonnee) 
    { // Si la localité actuelle n'a pas de parent, retourne false 
        if (is_null($this->parent_id)) 
        { 
            return false; 
        } // Récupère le parent de la localité actuelle
        $parent = $this->parent; // Si le parent de la localité actuelle n'a pas de parent (premier grand-parent) 
        if (is_null($parent->parent_id))
        { // Compare le parent à la localité passée en paramètre
            return $parent->is($localiteDonnee); 
        } // Appelle récursivement la méthode sur le parent 
        return $parent->estPremierGrandParent($localiteDonnee); 
    }

    public function ascendance() 
    { 
        $parent = $this->parent; // Commencez par ajouter le nom de la localité actuelle au début de la chaîne
        $ascendance = $this->nomLocalite; 
        while ($parent) 
        { 
            $ascendance = $parent->nomLocalite . '__' . $ascendance; 
            $parent = $parent->parent; 
        } 
        return $ascendance; 
    }

    public function getFils() 
    { 
        $enfants = $this->enfants()->whereHas('pratiquesZoneApplis')->get(); 
        foreach ($this->enfants as $enfant) { $enfants = $enfants->merge($enfant->getFils()); 
        } 
        return $enfants; 
    }

    public function pratiquesZoneApplis() 
    { 
        return $this->hasMany(Pratiquezoneappli::class, 'localite_id');
    }
    // Si tu veux ajouter des fonctions géographiques pour manipuler le champ 'centroid', tu peux utiliser le trait HasSpatial
    // public $spatial = ['centroid']; // Exemple si tu utilises une bibliothèque de gestion spatiale
}
