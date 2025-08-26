<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pratiqueclimat extends Model
{
    use HasFactory;
    protected $table = 'pratiqueclimats'; // Spécifier le nom de la table

    public function climat()
    {
        return $this->belongsTo(Climat::class, 'climat_id');
    }
}
