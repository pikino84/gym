<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MaterialController extends Controller
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
            $materiales = Material::select(
                'users.id as userId',
                'users.name as userName',
                'users.razonsocial',
                'materiales.cidproducto',
                'materiales.nombre',
                DB::raw('SUM(materiales.entradas) as totalEntradas'),
                DB::raw('SUM(materiales.salidas) as totalSalidas'),
                DB::raw('(SUM(materiales.entradas) - SUM(materiales.salidas)) as existencias')
            )
            ->leftJoin('users', 'materiales.user_id', '=', 'users.id')
            ->where('user_id', $user->id)
            ->groupBy('users.id', 'materiales.cidproducto', 'materiales.nombre')
            ->orderBy('users.razonsocial', 'desc')
            ->paginate(20);
        }else{
            $materiales = Material::select(
                'users.id as userId',
                'users.name as userName',
                'users.razonsocial',
                'materiales.cidproducto',
                'materiales.nombre',
                DB::raw('SUM(materiales.entradas) as totalEntradas'),
                DB::raw('SUM(materiales.salidas) as totalSalidas'),
                DB::raw('(SUM(materiales.entradas) - SUM(materiales.salidas)) as existencias')
            )
            ->leftJoin('users', 'materiales.user_id', '=', 'users.id')
            ->groupBy('users.id', 'materiales.cidproducto', 'materiales.nombre')
            ->orderBy('users.razonsocial', 'desc')
            ->paginate(20);
        }
        return view('materiales.index', compact('materiales'));
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
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
    }
}
