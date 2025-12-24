@extends('base')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Connexion</h2>
    <div class="row justify-content-center">
        <div class="col-md-6"> <!-- Colonne de largeur 6 pour la mise en page -->
            <form method="POST" action="{{ route('verifLogin') }}" class="bg-light p-4 border rounded shadow-sm">
                @csrf
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>
            <div class="text-center mt-3">
                <small>Pas de compte ? <a href="{{ route('pageRegister') }}">Inscrivez-vous ici</a></small>
            </div>
        </div>
    </div>
</div>
@endsection
