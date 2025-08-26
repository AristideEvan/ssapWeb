<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    use HasFactory;

    protected $table = 'partenaires';

    protected $primaryKey = 'partenaire_id';

    protected $fillable = [
        'typePartenaire_id',
        'nomPartenaire',
        'sigle',
        'nomRepondant',
        'prenomRepondant',
        'telephoneRepondant',
        'emailRepondant',
        'logo',  // Ajout du champ logo
    ];

    /**
     * Relation avec le modèle TypePartenaire.
     */
    public function typePartenaire()
    {
        return $this->belongsTo(TypePartenaire::class, 'typePartenaire_id');
    }
}
