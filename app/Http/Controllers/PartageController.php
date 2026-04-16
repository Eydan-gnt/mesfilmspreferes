<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Partage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartageController extends Controller
{
    public function afficherPartage()
    {
        // Récupérer tous les partages reçus par l'utilisateur connecté
        $partagesRecus = Partage::where('friend_id', Auth::id())
                                ->with('user')
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        // Récupérer tous les partages envoyés par l'utilisateur connecté
        $partagesEnvoyes = Partage::where('user_id', Auth::id())
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        
        return view('app.partage', compact('partagesRecus', 'partagesEnvoyes'));
    }

    public function ajouterPartage(Request $request, $favoriId)
    {
        // Récupérer le favori
        $favori = Favori::findOrFail($favoriId);
        
        // Vérifier que le favori appartient à l'utilisateur
        if ($favori->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez partager que vos propres favoris');
        }
        
        $request->validate([
            'friend_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:500'
        ]);
        
        $friendId = $request->input('friend_id');
        
        // Vérifier qu'on ne partage pas avec soi-même
        if ($friendId == Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas partager avec vous-même');
        }
        
        // Vérifier si ce film a déjà été partagé avec cet ami
        $dejaPartage = Partage::where('user_id', Auth::id())
                             ->where('favori_id', $favoriId)
                             ->where('friend_id', $friendId)
                             ->exists();
        
        if ($dejaPartage) {
            return redirect()->back()->with('info', 'Vous avez déjà partagé ce film avec cet ami');
        }
        
        // Créer le partage
        Partage::create([
            'user_id' => Auth::id(),
            'favori_id' => $favori->id,
            'film_title' => $favori->film_title,
            'film_poster_path' => $favori->film_poster_path,
            'film_tmdb_id' => $favori->favori_id,
            'friend_id' => $friendId,
            'message' => $request->input('message'),
            'avis' => $favori->avis
        ]);
        
        return redirect()->back()->with('success', 'Film partagé avec succès !');
    }
}
