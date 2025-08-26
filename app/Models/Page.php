<?php

namespace App\Models;

use App\Traits\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Page extends Model
{
    use HasFactory;
    use File;

    protected $table = 'page';
    protected $fillable = [
        'apropos',
        'but',
        'objectif',
        'contenu',
        'guide',
        'apropos_img_path',
        'communautes_img_path',
    ];


    // Carousel images
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
