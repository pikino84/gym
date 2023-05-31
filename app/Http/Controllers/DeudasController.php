<?php

namespace App\Http\Controllers;

use App\Models\Deudas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DeudasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('deuda_index'), 403);
        $deudas = Deudas::paginate(5);
        return view('deudas.index', compact('deudas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('deuda_create'), 403);

        return view('deudas.create');
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
     * @param  \App\Models\Deudas  $deudas
     * @return \Illuminate\Http\Response
     */
    public function show(Deudas $deudas)
    {
        abort_if(Gate::denies('deuda_show'), 403);

        return view('deudas.show', compact('deudas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deudas  $deudas
     * @return \Illuminate\Http\Response
     */
    public function edit(Deudas $deudas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deudas  $deudas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deudas $deudas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deudas  $deudas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deudas $deudas)
    {
        //
    }
}
