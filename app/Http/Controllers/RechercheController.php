<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RechercheController extends Controller
{
    public function afficherRecherche(){
        return view('app.recherche');
    }

    public function recherche(){
        $error = null;
        if(request('query')) { //si la requete existe
        try {
        $apiKey = '63905b28b94957ba2d061a85b849243f';//clé obligatoire pour TMDB
        $query = urlencode(request('query'));
        //On forme l'URL de la requête à l'API
        $url = "https://api.themoviedb.org/3/search/movie?query={$query}&api_key={$apiKey}";
        $response = file_get_contents($url);//on récupère les données
        if($response === false) throw new Exception('Erreur lors de la requête API');
        //on met les données dans un tableau associatif qu'on peut exploiter
        $data = json_decode($response, true);
        if(isset($data['results'])) {
            $results = $data['results'];
        } else {
            $error = 'Aucun film trouvé.';
        }
        } catch(Exception $e) {
            $error = $e->getMessage();
        }
        } else {
            $results = [];
        }
        
        return view('app.recherche', compact('results', 'error'));
    }

    public function ajouterFavori($filmId)
    {
        try {
            // Vérifier si le film n'est pas déjà dans les favoris
            $existeDeja = Favori::where('user_id', Auth::id())
                                ->where('favori_id', $filmId)
                                ->exists();
            
            if ($existeDeja) {
                return redirect()->back()->with('info', 'Ce film est déjà dans vos favoris !');
            }

            // Récupérer les détails du film depuis l'API TMDB
            $apiKey = '63905b28b94957ba2d061a85b849243f';
            $url = "https://api.themoviedb.org/3/movie/{$filmId}?api_key={$apiKey}&language=fr-FR";
            $response = file_get_contents($url);
            
            if ($response === false) {
                throw new Exception('Erreur lors de la récupération des détails du film');
            }
            
            $film = json_decode($response, true);
            
            // Créer le favori
            Favori::create([
                'favori_id' => $filmId,
                'film_title' => $film['title'] ?? 'Titre inconnu',
                'film_year' => isset($film['release_date']) ? substr($film['release_date'], 0, 4) : null,
                'film_overview' => $film['overview'] ?? null,
                'film_poster_path' => $film['poster_path'] ?? null,
                'user_id' => Auth::id()
            ]);
            
            return redirect()->back()->with('success', 'Film ajouté à vos favoris avec succès !');
            
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du favori : ' . $e->getMessage());
        }
    }
}
