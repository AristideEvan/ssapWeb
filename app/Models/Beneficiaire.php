<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiaire extends Model
{
    use HasFactory;

    // Nom de la clé primaire
    protected $primaryKey = 'beneficiaire_id';

    // Attributs assignables
    protected $fillable = [
        'beneficiaireLibelle',
        'typeBeneficiaire_id', // Clé étrangère
    ];

    /**
     * Relation avec le modèle TypeBeneficiaire
     */
    public function typeBeneficiaire()
    {
        return $this->belongsTo(TypeBeneficiaire::class, 'typeBeneficiaire_id', 'typeBeneficiaire_id');
    }
}