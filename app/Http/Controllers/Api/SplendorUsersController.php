<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SplendorUser;


class SplendorUsersController extends Controller
{
    public function index()
    {
        $users = SplendorUser::select('CIDCLIENTEPROVEEDOR', 'CCODIGOCLIENTE', 'CRAZONSOCIAL', 'CRFC')
                                ->where('CIDCLIENTEPROVEEDOR', '!=' , 0)
                                ->where('CCODIGOCLIENTE', '!=' , '')
                                ->where('CRAZONSOCIAL', '!=' , '')
                                ->where('CRFC', '!=' , '')
                                ->get();
        return response()->json($users);
    }

}
