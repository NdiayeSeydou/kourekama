<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class SettingsController extends Controller
{
    public function settings()
    {
        return view('settings');
    }

    /**
     * Mettre à jour les informations du profil (nom, email, niveau, confirmé) et le mot de passe.
     * Le changement de mot de passe nécessite la confirmation du mot de passe actuel.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ];

        // Si la colonne level existe, autoriser sa mise à jour
        if (Schema::hasColumn('users', 'level')) {
            $rules['level'] = 'nullable|string|max:50';
        }

        // Si la colonne confirmed existe, autoriser sa mise à jour
        if (Schema::hasColumn('users', 'confirmed')) {
            $rules['confirmed'] = 'nullable|boolean';
        }

        $data = $request->validate($rules);

        // Gestion du changement de mot de passe — nécessite le mot de passe actuel
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $pwdRules = [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ];

            $request->validate($pwdRules);

            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])->withInput();
            }

            $user->password = Hash::make($request->input('new_password'));
        }

        // Appliquer les changements simples
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (isset($data['level']) && Schema::hasColumn('users', 'level')) {
            $user->level = $data['level'];
        }

        if (isset($data['confirmed']) && Schema::hasColumn('users', 'confirmed')) {
            $user->confirmed = (bool) $data['confirmed'];
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}
