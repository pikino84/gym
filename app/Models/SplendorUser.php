<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SplendorUser extends Model
{
    protected $table = 'admClientes';

    protected $filable = [
        'CIDCLIENTEPROVEEDOR',
        'CCODIGOCLIENTE',
        'RAZONSOCIAL'
    ];
}
