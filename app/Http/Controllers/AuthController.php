<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginToAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function home() {
        if (auth()->user()) {
            return redirect()->route('services.show');
        }

        return view('login');
    }


    public function showLoginPage() {
        if (auth()->user()) {
            return redirect()->route('services.show');
        }

        return view('login');
    }

    public function authenticate(LoginToAccount $request) {
        $attributes = $request->validated();

        $user = User::where('login', $attributes['login'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'invalid' => 'Neteisingas prisijungimo vardas/slaptažodis'
            ]);
        }

        if (!auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'invalid' => 'Neteisingas prisijungimo vardas/slaptažodis'
            ]);
        }

        session()->regenerate();

        return redirect()->route('services.show');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
