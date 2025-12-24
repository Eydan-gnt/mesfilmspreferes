@extends('base')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Mes Films Favoris</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($favoris->count() > 0)
        <div class="row">
            @foreach($favoris as $favori)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($favori->film_poster_path)
                            <img src="https://image.tmdb.org/t/p/w500{{ $favori->film_poster_path }}" 
                                 class="card-img-top" 
                                 alt="{{ $favori->film_title }}"
                                 onerror="this.src='https://via.placeholder.com/500x750?text=Pas+d\'image'">
                        @else
                            <img src="https://via.placeholder.com/500x750?text=Pas+d'image" 
                                 class="card-img-top" 
                                 alt="{{ $favori->film_title }}">
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $favori->film_title }}</h5>
                            
                            @if($favori->film_year)
                                <p class="card-text text-muted">
                                    <small><i class="far fa-calendar-alt"></i> Année : {{ $favori->film_year }}</small>
                                </p>
                            @endif

                            @if($favori->film_overview)
                                <p class="card-text">
                                    {{ Str::limit($favori->film_overview, 120) }}
                                </p>
                            @endif

                            <div class="mt-auto">
                                @if($favori->avis)
                                    <div class="alert alert-info">
                                        <strong><i class="fas fa-comment"></i> Mon avis :</strong>
                                        <p class="mb-0">{{ $favori->avis }}</p>
                                    </div>
                                @else
                                    <div class="alert alert-secondary">
                                        <small><i class="fas fa-info-circle"></i> Vous n'avez pas encore ajouté d'avis</small>
                                    </div>
                                @endif

                                <div class="btn-group btn-group-sm w-100 mt-2" role="group">
                                    <button type="button" 
                                            class="btn btn-primary" 
                                            data-toggle="modal" 
                                            data-target="#avisModal{{ $favori->id }}">
                                        <i class="fas fa-edit"></i> {{ $favori->avis ? 'Modifier l\'avis' : 'Ajouter un avis' }}
                                    </button>
                                    <button type="button" 
                                            class="btn btn-danger" 
                                            data-toggle="modal" 
                                            data-target="#deleteModal{{ $favori->id }}">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                    <button type="button" 
                                            class="btn btn-success" 
                                            data-toggle="modal"
                                            data-target="#shareModal{{ $favori->id }}">
                                        <i class="fas fa-share-alt"></i> Partager
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal pour ajouter/modifier un avis -->
                <div class="modal fade" id="avisModal{{ $favori->id }}" tabindex="-1" role="dialog" aria-labelledby="avisModalLabel{{ $favori->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="avisModalLabel{{ $favori->id }}">
                                    {{ $favori->avis ? 'Modifier' : 'Ajouter' }} un avis pour "{{ $favori->film_title }}"
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route($favori->avis ? 'modifierAvis' : 'ajouterAvis', ['favoris' => $favori->id]) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="avis{{ $favori->id }}">Votre avis</label>
                                        <textarea class="form-control" 
                                                  id="avis{{ $favori->id }}" 
                                                  name="avis" 
                                                  rows="5" 
                                                  placeholder="Écrivez votre avis sur ce film..." 
                                                  required>{{ $favori->avis }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal de confirmation de suppression -->
                <div class="modal fade" id="deleteModal{{ $favori->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $favori->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteModalLabel{{ $favori->id }}">
                                    Confirmer la suppression
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Êtes-vous sûr de vouloir supprimer <strong>"{{ $favori->film_title }}"</strong> de vos favoris ?</p>
                                <p class="text-muted">Cette action est irréversible.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <form action="{{ route('supprimerFavoris', ['favoris' => $favori->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de partage -->
                <div class="modal fade" id="shareModal{{ $favori->id }}" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel{{ $favori->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="shareModalLabel{{ $favori->id }}">
                                    <i class="fas fa-share-alt"></i> Partager "{{ $favori->film_title }}"
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('ajouterPartage', ['film' => $favori->id]) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="friend_id{{ $favori->id }}">
                                            <i class="fas fa-user-friends"></i> Choisir un ami
                                        </label>
                                        @php
                                            $mesAmis = Auth::user()->friend_users()->with('user')->get();
                                        @endphp
                                        
                                        @if($mesAmis->count() > 0)
                                            <select class="form-control" id="friend_id{{ $favori->id }}" name="friend_id" required>
                                                <option value="">-- Sélectionnez un ami --</option>
                                                @foreach($mesAmis as $ami)
                                                    @php
                                                        $friendUser = \App\Models\User::find($ami->friend_id);
                                                    @endphp
                                                    @if($friendUser)
                                                        <option value="{{ $friendUser->id }}">
                                                            {{ $friendUser->firstname }} {{ $friendUser->lastname }} ({{ $friendUser->username }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Vous n'avez pas encore d'amis. 
                                                <a href="{{ route('pageAmis') }}" class="alert-link">Ajoutez des amis</a> pour pouvoir partager vos films !
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="message{{ $favori->id }}">
                                            <i class="fas fa-envelope"></i> Message (optionnel)
                                        </label>
                                        <textarea class="form-control" 
                                                  id="message{{ $favori->id }}" 
                                                  name="message" 
                                                  rows="3" 
                                                  placeholder="Ajoutez un message personnel pour votre ami..."></textarea>
                                    </div>

                                    @if($favori->avis)
                                        <div class="alert alert-info">
                                            <strong><i class="fas fa-info-circle"></i> Votre avis sera également partagé :</strong>
                                            <p class="mb-0 mt-2">{{ Str::limit($favori->avis, 100) }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times"></i> Annuler
                                    </button>
                                    @if($mesAmis->count() > 0)
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-paper-plane"></i> Partager
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <p class="text-muted">
                <i class="fas fa-film"></i> Vous avez <strong>{{ $favoris->count() }}</strong> film{{ $favoris->count() > 1 ? 's' : '' }} en favoris
            </p>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-heart-broken" style="font-size: 4rem; color: #ccc;"></i>
            <h4 class="mt-3">Vous n'avez pas encore de films favoris</h4>
            <p class="text-muted">Commencez par rechercher des films et ajoutez-les à vos favoris !</p>
            <a href="{{ route('pageRecherche') }}" class="btn btn-primary mt-3">
                <i class="fas fa-search"></i> Rechercher des films
            </a>
        </div>
    @endif
</div>

<!-- Inclusion de Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Scripts Bootstrap nécessaires pour les modals -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    .card {
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .card-img-top {
        height: 400px;
        object-fit: cover;
    }
</style>
@endsection
