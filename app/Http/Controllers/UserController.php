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
        $users = User::paginate(10);
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
        try{
            $user = User::create($request->only('name', 'username', 'email')
                + [ 'password' => bcrypt($request->input('password')), ] );
            $roles = $request->input('roles', []);
            $user->syncRoles($roles);
            return redirect()->route('users.show', $user->id)->with('success', 'Usuario creado correctamente');
        }catch(\Exception $e){
            return $e;
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
        $password=$request->input('password');
        if($password)
            $data['password'] = bcrypt($password);
        try{
            $user->update($data);
            $roles = $request->input('roles', []);
            $user->syncRoles($roles);
            return redirect()->route('users.show', $user->id)->with('success', 'Usuario actualizado correctamente');
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['idproveedor' => 'El usuario no existe']);
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
