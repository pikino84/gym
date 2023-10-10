<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_index'), 403);
        $users = User::paginate(20);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), 403);
        $roles = Role::all()->pluck('name', 'id');
        $user = Auth::user();
        return view('users.create', compact('roles', 'user'));
    }

    public function store(UserCreateRequest $request)
    {
        if(isset($request->idproveedor) && $request->idproveedor != '')
        {
            $productor = explode(' - ', trim( $request->input('idproveedor') ));
            $idClienteproveedor = trim($productor[0]);
            $razonsocial = trim($productor[1]);
            $rfc = trim($productor[2]); 
        }
        else
        {
            $idClienteproveedor = '';
            $razonsocial = '';
            $rfc = '';
        }
        
        try{
            $user = User::create($request->only('name', 'username', 'email')
                + [ 'password' => bcrypt($request->input('password')), ] 
                + [ 'razonsocial' => $razonsocial, 'idclienteproveedor' => $idClienteproveedor, 'rfc' => $rfc  ]);

            $roles = $request->input('roles', []);
            $user->syncRoles($roles);
            return redirect()->route('users.show', $user->id)->with('success', 'Usuario creado correctamente');
        }catch(\Exception $e){
            return $e;
            //return redirect()->back()->withErrors(['idproveedor' => 'El Proveedor no existe']);
        }
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), 403);
        $user->load('roles');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), 403);
        $roles = Role::all()->pluck('name', 'id');
        $user->load('roles');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UserEditRequest $request, User $user)
    {
        abort_if(Gate::denies('user_edit'), 403);
        $data = $request->only('name', 'username', 'email');
        if($request->input('idproveedor') != null or $request->input('idproveedor') != ''){
            $productor = explode(' - ', trim( $request->input('idproveedor') ));
            if( count($productor ) > 1 ){
                $idClienteproveedor = trim($productor[0]);
                $razonsocial = trim($productor[1]);
                $rfc = trim($productor[2]);
                $data['razonsocial'] = $razonsocial;
                $data['idclienteproveedor'] = $idClienteproveedor;
                $data['rfc'] = $rfc;
            }else{
                $data['razonsocial'] = $user->razonsocial;
                $data['idclienteproveedor'] = $user->idclienteproveedor;
                $data['rfc'] = $user->rfc;
            }
        }
        $password=$request->input('password');
        if($password)
            $data['password'] = bcrypt($password);
        try{
            $user->update($data);
            $roles = $request->input('roles', []);
            $user->syncRoles($roles);
            return redirect()->route('users.show', $user->id)->with('success', 'Usuario actualizado correctamente');
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['idproveedor' => 'El Proveedor no existe']);
        }
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_destroy'), 403);

        if (auth()->user()->id == $user->id) {
            return redirect()->route('users.index');
        }

        $user->delete();
        return back()->with('succes', 'Usuario eliminado correctamente');
    }
}
