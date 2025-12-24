@extends('base')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Mes Amis</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i> {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Section de recherche d'amis -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user-plus"></i> Rechercher et ajouter des amis</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('rechercheAmis', ['recherche' => 'search']) }}" method="POST">
                @csrf
                <div class="input-group input-group-lg">
                    <input type="text" 
                           name="query" 
                           class="form-control" 
                           placeholder="Recherchez par nom, prénom, username ou email..." 
                           value="{{ $query ?? '' }}" 
                           required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>

            @if(isset($resultats) && $resultats->count() > 0)
                <hr>
                <h6 class="mt-3 mb-3">
                    <i class="fas fa-users"></i> Résultats de recherche ({{ $resultats->count() }})
                </h6>
                <div class="list-group">
                    @foreach($resultats as $resultat)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                @if($resultat->avatar)
                                    <img src="{{ asset('storage/' . $resultat->avatar) }}" 
                                         alt="{{ $resultat->username }}" 
                                         class="rounded-circle mr-3" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mr-3" 
                                         style="width: 50px; height: 50px; font-size: 1.5rem;">
                                        {{ strtoupper(substr($resultat->firstname, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $resultat->firstname }} {{ $resultat->lastname }}</h6>
                                    <small class="text-muted">@{{ $resultat->username }}</small>
                                </div>
                            </div>
                            @if(in_array($resultat->id, $mesAmisIds ?? []))
                                <span class="badge badge-success badge-pill">
                                    <i class="fas fa-check"></i> Déjà ami
                                </span>
                            @else
                                <form action="{{ route('ajouterAmis', ['recherche' => $resultat->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-user-plus"></i> Ajouter
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @elseif(isset($query))
                <div class="alert alert-warning mt-3 mb-0">
                    <i class="fas fa-search"></i> Aucun utilisateur trouvé pour "<strong>{{ $query }}</strong>"
                </div>
            @endif
        </div>
    </div>

    <!-- Liste de mes amis -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-user-friends"></i> Ma liste d'amis</h5>
        </div>
        <div class="card-body">
            @if($amis->count() > 0)
                <div class="row">
                    @foreach($amis as $ami)
                        @if($ami)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body text-center">
                                        @if($ami->avatar)
                                            <img src="{{ asset('storage/' . $ami->avatar) }}" 
                                                 alt="{{ $ami->username }}" 
                                                 class="rounded-circle mb-3" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-3" 
                                                 style="width: 80px; height: 80px; font-size: 2rem;">
                                                {{ strtoupper(substr($ami->firstname, 0, 1)) }}
                                            </div>
                                        @endif
                                        <h5 class="card-title mb-1">{{ $ami->firstname }} {{ $ami->lastname }}</h5>
                                        <p class="card-text text-muted mb-3">
                                            <small>{{ $ami->username }}</small>
                                        </p>
                                        <div class="btn-group w-100" role="group">
                                            <a href="{{ route('pageProfil', ['id' => $ami->id]) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-user"></i> Profil
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal{{ $ami->id }}">
                                                <i class="fas fa-user-times"></i> Retirer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de confirmation de suppression -->
                            <div class="modal fade" id="deleteModal{{ $ami->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $ami->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $ami->id }}">
                                                Confirmer la suppression
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Êtes-vous sûr de vouloir retirer <strong>{{ $ami->firstname }} {{ $ami->lastname }}</strong> de votre liste d'amis ?</p>
                                            <p class="text-muted">Vous pourrez toujours l'ajouter à nouveau plus tard.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <form action="{{ route('supprimerAmis', ['recherche' => $ami->id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-user-times"></i> Retirer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="text-center mt-3">
                    <p class="text-muted mb-0">
                        <i class="fas fa-users"></i> Vous avez <strong>{{ $amis->count() }}</strong> ami{{ $amis->count() > 1 ? 's' : '' }}
                    </p>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-friends" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">Vous n'avez pas encore d'amis</h4>
                    <p class="text-muted">Utilisez la barre de recherche ci-dessus pour trouver et ajouter des amis !</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Inclusion de Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Scripts Bootstrap nécessaires pour les modals -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .list-group-item {
        transition: background-color 0.2s;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
