<?php

namespace App\Models;

use App\Traits\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outil extends Model
{
    use HasFactory;
    use File;

    protected $fillable = [
        'typeoutil_id',
        'titre',
        'contenu',
        'publique',
        'image_path'
    ];

    protected $cast = [
        'publique' => 'boolean'
    ];

    public function typeOutil(): BelongsTo
    {
        return $this->belongsTo(Typeoutil::class, 'typeoutil_id');
    }
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
