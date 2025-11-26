<?php

use App\Http\Controllers\AmisController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PartageController;
use App\Http\Controllers\RechercheController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(LoginController::class)->group(function() {
    Route::get('/', 'afficherAccueil')->middleware('auth')->name('pageAccueil');

    Route::get('/login', 'afficherLogin')->name('login');
    Route::post('/login/connexion', 'userLogin')->name('verifLogin');

    Route::get('/register', 'afficherRegister')->name('pageRegister');
    Route::post('/register/ajoutUser', 'userRegister')->name('userRegister');

    Route::get('/logout', 'userLogout')->name('logout');
});

Route::controller(RechercheController::class)->middleware('auth')->group(function() {
    Route::get('/recherche', 'afficherRecherche')->name('pageRecherche');

    Route::get('/recherche/result', 'recherche')->name('recherche');
    Route::post('/recherche/{recherche}/ajouterFavori', 'ajouterFavori')->name('ajouterFavori');
});

Route::controller(FavorisController::class)->group(function() {
    Route::get('/favoris', 'afficherFavoris')->name('pageFavoris');

    Route::post('/favoris/{favoris}/ajouter', 'ajouter')->name('ajouterAvis');
    Route::post('/favoris/{favoris}/supprimer', 'supprimer')->name('supprimerFavoris');
    Route::post('/favoris/{favoris}/modifier', 'modifier')->name('modifierAvis');
});

Route::controller(AmisController::class)->group(function() {
    Route::get('/amis', 'afficherAmis')->name('pageAmis');

    Route::post('/amis/{recherche}', 'rechercheAmis')->name('rechercheAmis');
    Route::post('/amis/{recherche}/ajouterAmis', 'ajouterAmis')->name('ajouterAmis');
    Route::post('/amis/{recherche}/supprimerAmis', 'supprimerAmis')->name('supprimerAmis');
});

Route::controller(PartageController::class)->group(function() {
    Route::get('/partage', 'afficherPartage')->name('pagePartage');

    Route::post('/partage/partager/{film}', 'ajouterPartage')->name('ajouterPartage');
    Route::post('/partage/supprimer/{film}', 'supprimerPartage')->name('supprimerPartage');
});

Route::controller(UserController::class)->group(function() {
    Route::get('/profil/{id}', 'afficherProfil')->name('pageProfil');

    Route::post('/profil/{id}/modifier', 'modifierProfil')->name('modifierProfil');
});