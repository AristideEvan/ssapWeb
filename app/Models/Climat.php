<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Climat extends Model
{
    use HasFactory;

    protected $primaryKey = 'climat_id'; // Définir la clé primaire personnalisée

    protected $fillable = ['libelleClimat', 'description'];

    public function pratiques()
    {
        return $this->belongsToMany(Pratique::class, 'pratiqueclimat', 'climat_id', 'pratique_id');
    }
}
