<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SplendorTablaMovimientos extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'admMovimientos';
}
