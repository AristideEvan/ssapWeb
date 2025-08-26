<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typeoutil extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'typeoutilLibelle',
    ];

    // The primary key associated with the table.
    protected $primaryKey = 'typeoutil_id';
}
