<?php

namespace App\Http\Controllers;

use App\Models\FriendUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmisController extends Controller
{
    public function afficherAmis()
    {
        // Récupérer tous les amis de l'utilisateur connecté
        $mesAmis = FriendUser::where('user_id', Auth::id())
                            ->with('user')
                            ->get();
        
        // Transformer pour avoir les données des amis
        $amis = $mesAmis->map(function($relation) {
            return User::find($relation->friend_id);
        })->filter(); // Filtrer les null au cas où
        
        return view('app.amis', compact('amis'));
    }

    public function rechercheAmis(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query) {
            return redirect()->route('pageAmis')->with('error', 'Veuillez entrer un terme de recherche');
        }

        // Rechercher des utilisateurs par username, firstname ou lastname
        $resultats = User::where('id', '!=', Auth::id()) // Exclure l'utilisateur actuel
                        ->where(function($q) use ($query) {
                            $q->where('username', 'LIKE', "%{$query}%")
                              ->orWhere('firstname', 'LIKE', "%{$query}%")
                              ->orWhere('lastname', 'LIKE', "%{$query}%")
                              ->orWhere('email', 'LIKE', "%{$query}%");
                        })
                        ->limit(20)
                        ->get();

        // Récupérer mes amis actuels
        $mesAmisIds = FriendUser::where('user_id', Auth::id())
                                ->pluck('friend_id')
                                ->toArray();
        
        // Récupérer tous les amis pour l'affichage principal
        $mesAmis = FriendUser::where('user_id', Auth::id())
                            ->with('user')
                            ->get();
        
        $amis = $mesAmis->map(function($relation) {
            return User::find($relation->friend_id);
        })->filter();

        return view('app.amis', compact('amis', 'resultats', 'mesAmisIds', 'query'));
    }

    public function ajouterAmis($userId)
    {
        // Vérifier que l'utilisateur existe
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('pageAmis')->with('error', 'Utilisateur introuvable');
        }

        // Vérifier qu'on n'ajoute pas soi-même
        if ($userId == Auth::id()) {
            return redirect()->route('pageAmis')->with('error', 'Vous ne pouvez pas vous ajouter vous-même');
        }

        // Vérifier que l'ami n'existe pas déjà
        $dejaAmi = FriendUser::where('user_id', Auth::id())
                             ->where('friend_id', $userId)
                             ->exists();

        if ($dejaAmi) {
            return redirect()->route('pageAmis')->with('info', 'Cet utilisateur est déjà dans vos amis');
        }

        // Ajouter l'ami
        FriendUser::create([
            'user_id' => Auth::id(),
            'friend_id' => $userId
        ]);

        return redirect()->route('pageAmis')->with('success', "Vous êtes maintenant ami avec {$user->firstname} {$user->lastname}");
    }

    public function supprimerAmis($userId)
    {
        // Supprimer la relation d'amitié
        $deleted = FriendUser::where('user_id', Auth::id())
                            ->where('friend_id', $userId)
                            ->delete();

        if ($deleted) {
            return redirect()->route('pageAmis')->with('success', 'Ami supprimé de votre liste');
        } else {
            return redirect()->route('pageAmis')->with('error', 'Impossible de supprimer cet ami');
        }
    }
}
