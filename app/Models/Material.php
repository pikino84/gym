<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materiales';    
    protected $fillable = [
        'cidproducto',
        'user_id',
        'nombre',
        'u_agregadas',
        'u_restadas'
    ];
}
