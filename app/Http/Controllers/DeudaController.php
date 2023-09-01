<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Deuda;
use APP\Models\Invoice;


class DeudaController extends Controller
{
    public function index(){
        $user = Auth::user();
        if( $user->razonsocial != null ){
            $deudas = Invoice::join('users', 'invoices.razonsocial', '=', 'users.razonsocial')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->join('deudas', 'invoices.id', '=', 'deudas.id')
                ->select('deudas.*')
                ->where('invoices.razonsocial', $user->razonsocial)
                ->orderBy('deudas.fecha', 'desc')
                ->paginate(10);
        }else{
            $deudas = Deuda::orderBy('fecha', 'desc')
            ->paginate(10);
        }
        return view('deudas.index', compact('deudas'));
    }
}
