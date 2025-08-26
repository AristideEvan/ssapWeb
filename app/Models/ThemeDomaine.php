<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeDomaine extends Model
{
    use HasFactory;

    protected $table = 'theme_domaine';

    protected $fillable = [
        'theme_id',
        'domaine_id',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function domaine()
    {
        return $this->belongsTo(Domaine::class);
    }
}
