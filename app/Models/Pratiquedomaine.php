<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pratiquedomaine extends Model
{
    use HasFactory;
    protected $table = 'pratiquedomaines';
    public function domaine()
    {
        return $this->belongsTo(Domaine::class, 'domaine_id');
    }
}
