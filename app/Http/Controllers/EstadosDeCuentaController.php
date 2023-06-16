<?php

namespace App\Http\Controllers;

use App\Models\EstadosDeCuenta;
use Illuminate\Http\Request;

class EstadosDeCuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = EstadosDeCuenta::all();

        return view('estadosdecuenta.index', compact('estadosdecuenta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('estadosdecuenta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate((new EstadosDeCuenta)->validar());

        EstadosDeCuenta::create($request->all());

        return redirect()->route('estadosdecuenta.index')->with('success', 'Prefactura creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EstadosDeCuenta  $estadosDeCuenta
     * @return \Illuminate\Http\Response
     */
    public function show(EstadosDeCuenta $estadosDeCuenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EstadosDeCuenta  $estadosDeCuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(EstadosDeCuenta $estadosDeCuenta)
    {
        return view('estadosdecuenta.edit', compact('estadosdecuenta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EstadosDeCuenta  $estadosDeCuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EstadosDeCuenta $estadosDeCuenta)
    {
        $request->validate((new EstadosDeCuenta)->validar());

        $estadosDeCuenta->update($request->all());

        return redirect()->route('estadosdecuenta.index')->with('success', 'Prefactura actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EstadosDeCuenta  $estadosDeCuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstadosDeCuenta $estadosDeCuenta)
    {
        $estadosDeCuenta->delete();

        return redirect()->route('estadosdecuenta.index')->with('success', 'Prefactura eliminada exitosamente.');
    }
}
