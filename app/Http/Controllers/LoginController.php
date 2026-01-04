<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function afficherAccueil() {
        return view('app.accueil');
    }

    public function afficherLogin() {
        return view('login.login');
    }

    public function afficherRegister() {
        if (Auth::check()) {
            return redirect()->route('pageAccueil');
        }

        return view('login.register');
    }

    public function userRegister(Request $request) {

        //VerifData
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
            
        // Create User dans la DB
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->save();

        // Redirection vers la page login
        return redirect('/login')->with('success', 'Compte créé avec succès !');
    }

    public function userLogin(Request $request) {

        //VerifData
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
            
        // Login de l'utilisateur
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/register')->with('success', 'Connexion Réussie');
        }

        return back()->withErrors([
            'username' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function userLogout(Request $request) {   
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
