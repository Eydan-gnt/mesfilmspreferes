<!DOCTYPE html>
<html
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MesFilmsPreferes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="bg-dark text-white text-center py-4">
        <h1 class="display-4 mb-2">Mes Films Préférés</h1>
        <p class="lead">Découvrez et partagez vos films favoris</p>
        
        <nav>
            <ul class="nav justify-content-center mt-3">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pageAcceuil') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pageLogin') }}">Rechercher un Film</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pageLogin') }}">Mes Favoris</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pageLogin') }}">Mes Amis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pageLogin') }}">Mes Partages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('pageLogin') }}">Mon Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('logout') }}">Déconnexion</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
