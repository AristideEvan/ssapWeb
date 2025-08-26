<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'themeLibelle',
    ];

    // The primary key associated with the table.
    protected $primaryKey = 'theme_id';
    // Relationships
    
    public function domaines()
    {
        return $this->belongsToMany(Domaine::class, 'theme_domaine', 'theme_id', 'domaine_id');
    }

}
