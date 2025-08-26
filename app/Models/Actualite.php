<?php

namespace App\Models;

use App\Traits\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actualite extends Model
{
    use HasFactory;
    use SoftDeletes;
    use File;


    protected $fillable = [
        'titre',
        'contenu',
        'publique',
        'image_path',
    ];

    protected $cast = [
        'publique' => 'boolean',
    ];
}
