<?php

namespace App\Http\Controllers;

use App\Models\ProveedoresCompac;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProveedoresCompacController extends Controller
{
    public function getProveedoresCompac(Request $request)
    {
        try {
            $results = ProveedoresCompac::Select('CCODIGOCLIENTE', 'CRAZONSOCIAL')->get();
            return response()->json($results);
        } catch   ( Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\ProveedoresCompac  $proveedoresCompac
     * @return \Illuminate\Http\Response
     */
    public function show(ProveedoresCompac $proveedoresCompac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProveedoresCompac  $proveedoresCompac
     * @return \Illuminate\Http\Response
     */
    public function edit(ProveedoresCompac $proveedoresCompac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProveedoresCompac  $proveedoresCompac
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProveedoresCompac $proveedoresCompac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProveedoresCompac  $proveedoresCompac
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProveedoresCompac $proveedoresCompac)
    {
        //
    }
}
