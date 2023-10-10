<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RazonesSocialesByUser extends Model
{
    use HasFactory;
    protected $table = 'user_rfcs';
    protected $fillable = [
        'user_id',
        'cidclienteproveedor',
        'ccodigocliente',
        'crazonsocial',
    ];
}
