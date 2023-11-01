<?php

namespace App\Http\Controllers;

use App\Models\Regalia;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class RegaliasController extends Controller
{
    public function index(){
        $user = Auth::user();
        if( $user->razonsocial != null ){
            $regalias = Invoice::join('users', 'invoices.razonsocial', '=', 'users.razonsocial')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->join('regalias', 'invoices.id', '=', 'regalias.id')
                ->select('regalias.*')
                ->where('invoices.razonsocial', $user->razonsocial)
                ->orderBy('regalias.fecha', 'desc')
                ->paginate(20);
        }else{
            $regalias = Regalia::orderBy('fecha', 'desc')
            ->paginate(20);
        }
        return view('regalias.index', compact('regalias')); 
    }
}
