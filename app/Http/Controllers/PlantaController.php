<?php

namespace App\Http\Controllers;

use App\Models\Planta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PlantaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if( $user->rfc != null ){
            $plantas = Invoice::join('users', 'invoices.rfc', '=', 'users.rfc')
                ->join('estatus', 'invoices.id_status', '=', 'estatus.id')
                ->join('plantas', 'invoices.id_invoice', '=', 'plantas.cididdocumento')
                ->select('plantas.*')
                ->where('invoices.rfc', "$user->rfc")
                ->orderBy('plantas.fecha', 'desc')
                ->paginate(10);
        }else{
            $plantas = Planta::orderBy('fecha', 'desc')
            ->paginate(10);
        }
        return view('plantas.index', compact('plantas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Planta  $planta
     * @return \Illuminate\Http\Response
     */
    public function show(Planta $planta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Planta  $planta
     * @return \Illuminate\Http\Response
     */
    public function edit(Planta $planta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Planta  $planta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Planta $planta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Planta  $planta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planta $planta)
    {
        //
    }
}
