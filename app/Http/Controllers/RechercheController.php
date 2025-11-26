<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
