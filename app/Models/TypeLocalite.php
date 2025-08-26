<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeLocalite extends Model
{
    use HasFactory;

    protected $primaryKey = "typeLocalite_id";

    public function localites(): HasMany
    {
        return $this->hasMany(Localite::class, 'typeLocalite_id');
    }
}
