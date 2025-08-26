<?php

namespace App\Models;

use App\Models\Sol;
use App\Traits\File;
use App\Models\Climat;
use App\Models\Pilier;
use App\Models\Domaine;
use App\Models\Localite;
use App\Models\TypeChoc;
use App\Models\Partenaire;
use App\Models\TypeReponse;
use App\Models\Beneficiaire;
use App\Models\SecteurActivite;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pratique extends Model
{
    use HasFactory;
    use SoftDeletes;
    use File;

    protected $primaryKey = "pratique_id";

    protected $fillable = [
        'pratiqueLibelle',
        'description',
        'objectif',
        'periodeDebut',
        'periodeFin',
        'avantage',
        'contrainte',
        'cout',
        'conseil',
        'mesure',
        'description_env_humain',
        'recommandation',
        'defis',
        'publique',
        'user_id',
        'vedette_path',
        'periode'
    ];

    protected $cast =
    [
        'periodeDebut' => 'datetime',
        'periodeFin' => 'datetime',
    ];

    public function domaines(): BelongsToMany
    {
        return $this->belongsToMany(Domaine::class, 'pratiquedomaines', 'pratique_id', 'domaine_id');
    }
    public function reponses(): BelongsToMany
    {
        return $this->belongsToMany(TypeReponse::class, 'pratiquereponses', 'pratique_id', 'typeReponse_id');
    }

    public function piliers(): BelongsToMany
    {
        return $this->belongsToMany(Pilier::class, 'pratiquepiliers', 'pratique_id', 'pilier_id');
    }

    /**
     *  Zone d'application.
     */
    public function zonesActuelles(): BelongsToMany
    {
        return $this->belongsToMany(Localite::class, 'pratiquezoneapplis', 'pratique_id', 'localite_id')->withPivot('latitude', 'longitude', 'geom')->as('coordonnees');
    }

    public function typesChocs(): BelongsToMany
    {
        return $this->belongsToMany(TypeChoc::class, 'pratiquetypechocs', 'pratique_id', 'typeChoc_id');
    }

    public function secteurs(): BelongsToMany
    {
        return $this->belongsToMany(SecteurActivite::class, 'pratiquesectacts', 'pratique_id', 'secteurActivite_id');
    }

    public function beneficiaires(): BelongsToMany
    {
        return $this->belongsToMany(Beneficiaire::class, 'pratiquebenefs', 'pratique_id', 'beneficiaire_id');
    }

    public function partenaires()
    {
        return $this->belongsToMany(Partenaire::class, 'pratiqueparts', 'pratique_id', 'partenaire_id');
    }

    public function zonesPotentielles(): BelongsToMany
    {
        return $this->belongsToMany(Localite::class, 'pratiquezonepotents', 'pratique_id', 'localite_id');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
    public function sols()
    {
        return $this->belongsToMany(Sol::class, 'pratiquesols', 'pratique_id', 'sol_id');
    }

    public function climats()
    {
        return $this->belongsToMany(Climat::class, 'pratiqueclimats', 'pratique_id', 'climat_id');
    }
    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'pratiquethemes', 'pratique_id', 'theme_id');
    }
}
