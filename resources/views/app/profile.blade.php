@extends('base')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Mon profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Informations</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('modifierProfil', ['id' => $user->id]) }}">
                        @csrf
                        <input type="hidden" name="action" value="info">

                        <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="firstname" class="form-control" value="{{ old('firstname', $user->firstname) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="lastname" class="form-control" value="{{ old('lastname', $user->lastname) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pseudo</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <button class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Changer le mot de passe</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('modifierProfil', ['id' => $user->id]) }}">
                        @csrf
                        <input type="hidden" name="action" value="password">

                        <div class="mb-3">
                            <label class="form-label">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-warning">Changer le mot de passe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('pageAccueil') }}" class="btn btn-link">Retour</a>
</div>
@endsection
