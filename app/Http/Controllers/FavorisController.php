<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function afficherFavoris()
    {
        // Récupérer tous les favoris de l'utilisateur connecté
        $favoris = Favori::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        return view('app.favoris', compact('favoris'));
    }

    public function ajouter(Request $request, $id)
    {
        $favori = Favori::findOrFail($id);
        
        // Vérifier que le favori appartient à l'utilisateur
        if ($favori->user_id !== Auth::id()) {
            return redirect()->route('pageFavoris')->with('error', 'Action non autorisée');
        }
        
        $favori->avis = $request->input('avis');
        $favori->save();
        
        return redirect()->route('pageFavoris')->with('success', 'Avis ajouté avec succès');
    }

    public function modifier(Request $request, $id)
    {
        $favori = Favori::findOrFail($id);
        
        // Vérifier que le favori appartient à l'utilisateur
        if ($favori->user_id !== Auth::id()) {
            return redirect()->route('pageFavoris')->with('error', 'Action non autorisée');
        }
        
        $favori->avis = $request->input('avis');
        $favori->save();
        
        return redirect()->route('pageFavoris')->with('success', 'Avis modifié avec succès');
    }

    public function supprimer($id)
    {
        $favori = Favori::findOrFail($id);
        
        // Vérifier que le favori appartient à l'utilisateur
        if ($favori->user_id !== Auth::id()) {
            return redirect()->route('pageFavoris')->with('error', 'Action non autorisée');
        }
        
        $favori->delete();
        
        return redirect()->route('pageFavoris')->with('success', 'Film supprimé des favoris');
    }
}
