<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sol extends Model
{
    use HasFactory;
    protected $primaryKey = 'sol_id'; // Définir la clé primaire personnalisée

    protected $fillable = ['solLibelle', 'description'];

    
    public function pratiques()
    {
        return $this->belongsToMany(Pratique::class, 'pratiquesol', 'sol_id', 'pratique_id');
    }
}
