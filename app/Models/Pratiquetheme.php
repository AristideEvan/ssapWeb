<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pratiquetheme extends Model
{
    use HasFactory;
    
    protected $table = 'pratiquethemes'; // Spécifier le nom de la table

    protected $fillable = [
        'pratique_id',
        'theme_id'
    ];

    // Définir les relations
    public function pratique()
    {
        return $this->belongsTo(Pratique::class, 'pratique_id');
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}
