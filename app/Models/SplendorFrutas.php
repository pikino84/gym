<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SplendorFrutas extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'admDocumentos';
}
