<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class SplendorUsersController extends Controller
{
    public function index()
    {
        $users = DB::connection('sqlsrv')->table('admClientes')->get();        
        return response()->json($users);
    }

}
