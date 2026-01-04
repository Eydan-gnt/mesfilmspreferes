@extends('base')

@section('content')
<div class="container my-5">
    <!-- Section d'accueil hero -->
    <div class="jumbotron bg-primary text-white text-center py-5 rounded">
        <h1 class="display-3 font-weight-bold">Bienvenue {{ auth()->user()->username }} !</h1>
        <p class="lead mt-3">Découvrez, partagez et gérez vos films préférés en toute simplicité</p>
        <hr class="my-4 bg-white">
        <p>Explorez notre collection, ajoutez vos favoris et partagez-les avec vos amis</p>
        <a class="btn btn-light btn-lg mt-3" href="{{ route('pageRecherche') }}" role="button">
            <i class="fas fa-search"></i> Rechercher un film
        </a>
    </div>

    <!-- Section fonctionnalités -->
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-search fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Rechercher des Films</h5>
                    <p class="card-text">Trouvez vos films préférés grâce à notre moteur de recherche connecté à la base TMDB</p>
                    <a href="{{ route('pageRecherche') }}" class="btn btn-outline-primary">Rechercher</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-heart fa-3x text-danger"></i>
                    </div>
                    <h5 class="card-title">Mes Favoris</h5>
                    <p class="card-text">Gérez votre collection personnelle de films favoris et ajoutez vos avis</p>
                    <a href="{{ route('pageFavoris') }}" class="btn btn-outline-danger">Voir mes favoris</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Mes Amis</h5>
                    <p class="card-text">Connectez-vous avec d'autres cinéphiles et partagez vos découvertes</p>
                    <a href="{{ route('pageAmis') }}" class="btn btn-outline-success">Gérer mes amis</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section partage -->
    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-share-alt fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">Partager avec mes Amis</h5>
                    <p class="card-text">Partagez vos films favoris avec votre communauté</p>
                    <a href="{{ route('pagePartage') }}" class="btn btn-outline-info">Mes partages</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title">Mon Profil</h5>
                    <p class="card-text">Personnalisez votre profil et gérez vos informations</p>
                    <a href="{{ route('pageProfil', ['id' => auth()->user()->id]) }}" class="btn btn-outline-warning">Voir mon profil</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection