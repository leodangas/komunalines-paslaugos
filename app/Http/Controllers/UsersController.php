<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUser;
use App\Http\Requests\EditUser;
use App\Models\User;

class UsersController extends Controller
{
    //

    public function showUsersPage() {
        $users = User::with('role')->get();
        return view('users', compact('users'));
    }

    public function createUser(CreateUser $request) {
        $attributes = $request->validated();
        $attributes['login'] = User::getValidName($attributes['name']);
        $attributes['password'] = $attributes['last_name'];

        $user = User::create($attributes);

        return redirect()->back()->with('status', "Vartotojas $user->name $user->last_name sėkmingai sukurtas");
    }

    public function editUser(EditUser $request, $id) {
        $user = User::findOrFail($id);
        $attributes = $request->validated();

        $user->update($attributes);

        return redirect()->back()->with('status', "Vartotojas $user->name $user->last_name sėkmingai atnaujintas");
    }


    public function deleteUser($id) {
        $single_user = User::findOrFail($id);
        $single_user->delete();

        return redirect()->back()->with('status', "Vartotojo $single_user->email paskyra sėkmingai ištrinta");
    }
}
