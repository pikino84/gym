<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PrestamoController extends Controller
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
            $prestamos = Prestamo::leftJoin('users', 'prestamos.user_id', '=', 'users.id')
            ->where('user_id', $user->id)->orderBy('fecha', 'asc')->paginate(20);
            $montos = Prestamo::select(['total', 'naturaleza', 'pendiente','moneda'])->where('user_id', $user->id)->get();
        }else{
            $prestamos = Prestamo::leftJoin('users', 'prestamos.user_id', '=', 'users.id')
            ->orderBy('fecha', 'asc')
            ->paginate(20);
            $montos = Prestamo::select(['total', 'naturaleza', 'pendiente','moneda'])->get();
        }
        return view('prestamos.index', compact(['prestamos', 'montos']));
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
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function show(Prestamo $prestamo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Prestamo $prestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestamo $prestamo)
    {
        //
    }
}
