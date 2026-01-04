<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function afficherProfil($id)
    {
        $user = User::findOrFail($id);
        if (auth()->guest() || auth()->id() !== $user->id) {
            abort(403);
        }

        return view('app.profile', compact('user'));
    }

    public function modifierProfil(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (auth()->guest() || auth()->id() !== $user->id) {
            abort(403);
        }

        $action = $request->input('action', 'info');

        if ($action === 'info') {
            $data = $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
                'email' => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            ]);

            $user->fill($data);
            $user->save();

            return Redirect::back()->with('success', 'Profil mis à jour.');
        }

        if ($action === 'password') {
            $data = $request->validate([
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if (!Hash::check($data['current_password'], $user->password)) {
                return Redirect::back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }

            $user->password = Hash::make($data['password']);
            $user->save();

            return Redirect::back()->with('success', 'Mot de passe mis à jour.');
        }

        return Redirect::back();
    }
}
