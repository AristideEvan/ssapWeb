<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domaine extends Model
{
    use HasFactory;
    protected $primaryKey="domaine_id";
    
    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'theme_domaine', 'domaine_id', 'theme_id');
    }

}
