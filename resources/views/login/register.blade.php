@extends('base')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Créer un Nouveau Compte</h2>
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Colonne de largeur 8 pour la mise en page -->
            <form method="POST" action="{{ route('userRegister') }}" class="bg-light p-4 border rounded shadow-sm">
                @csrf

                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                    @error('firstname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lastname">Nom de Famille</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                    @error('lastname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mot de Passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le Mot de Passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Créer un Compte</button>
            </form>
            <div class="text-center mt-3">
                <small>Déjà un compte ? <a href="{{ route('verifLogin') }}">Connectez-vous ici</a></small>
            </div>
        </div>
    </div>
</div>
@endsection