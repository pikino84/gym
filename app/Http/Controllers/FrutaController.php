<?php

namespace App\Http\Controllers;


use App\Models\Fruta;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class FrutaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if( $user->razonsocial != null ){
            $frutas = Invoice::join('users', 'invoices.razonsocial', '=', 'users.razonsocial')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->join('frutas', 'invoices.id', '=', 'frutas.id')
                ->select('frutas.*')
                ->where('invoices.razonsocial', $user->razonsocial)
                ->orderBy('frutas.fecha', 'desc')
                ->paginate(10);
        }else{
            $frutas = Fruta::orderBy('fecha', 'desc')
            ->paginate(10);
        }
        return view('frutas.index', compact('frutas'));
    }
}
