<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Chercher l'utilisateur par email
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Connexion réussie : on stocke l'utilisateur dans la session
            Auth::login($user);

            return redirect()->route('dashboard');
        }

        // Sinon erreur
        return back()->withErrors(['email' => 'Email ou mot de passe incorrect'])
            ->withInput();
    }

    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    
}
