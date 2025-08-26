<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pratiquesol extends Model
{
    use HasFactory;
    protected $table = 'pratiquesols'; // Spécifier le nom de la table

    public function sol()
    {
        return $this->belongsTo(Sol::class, 'sol_id');
    }
}
