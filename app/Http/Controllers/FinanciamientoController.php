<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Financiamiento;
use App\Models\Invoice;


class FinanciamientoController extends Controller
{
    public function index(){
        $user = Auth::user();
        if( $user->razonsocial != null ){
            $financiamientos = Invoice::join('users', 'invoices.razonsocial', '=', 'users.razonsocial')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->join('financiamientos', 'invoices.id', '=', 'financiamientos.id')
                ->select('financiamientos.*')
                ->where('invoices.razonsocial', $user->razonsocial)
                ->orderBy('financiamientos.fecha', 'desc')
                ->paginate(10);
        }else{
            $financiamientos = Financiamiento::orderBy('fecha', 'desc')
            ->paginate(10);
        }
        return view('financiamientos.index', compact('financiamientos'));
    }
}
