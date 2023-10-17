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
        if( $user->rfc != null ){
            $frutas = Fruta::where('user_id', $user->id)->orderBy('fecha', 'desc')->paginate(10);
        }else{
            $frutas = Fruta::orderBy('fecha', 'desc')
            ->paginate(10);
        }
        return view('frutas.index', compact('frutas'));
    }
}
