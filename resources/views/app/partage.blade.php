@extends('base')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Mes Partages</h2>

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

    <!-- Onglets -->
    <ul class="nav nav-tabs mb-4" id="partageTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="recus-tab" data-toggle="tab" href="#recus" role="tab" aria-controls="recus" aria-selected="true">
                <i class="fas fa-inbox"></i> Partages reçus 
                @if($partagesRecus->count() > 0)
                    <span class="badge badge-primary">{{ $partagesRecus->count() }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="envoyes-tab" data-toggle="tab" href="#envoyes" role="tab" aria-controls="envoyes" aria-selected="false">
                <i class="fas fa-paper-plane"></i> Partages envoyés
                @if($partagesEnvoyes->count() > 0)
                    <span class="badge badge-secondary">{{ $partagesEnvoyes->count() }}</span>
                @endif
            </a>
        </li>
    </ul>

    <div class="tab-content" id="partageTabContent">
        <!-- Partages reçus -->
        <div class="tab-pane fade show active" id="recus" role="tabpanel" aria-labelledby="recus-tab">
            @if($partagesRecus->count() > 0)
                <div class="row">
                    @foreach($partagesRecus as $partage)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm border-primary">
                                <div class="card-header bg-primary text-white">
                                    <small>
                                        <i class="fas fa-user"></i> Partagé par 
                                        <strong>{{ $partage->user->firstname }} {{ $partage->user->lastname }}</strong>
                                    </small>
                                </div>
                                @if($partage->film_poster_path)
                                    <img src="https://image.tmdb.org/t/p/w500{{ $partage->film_poster_path }}" 
                                         class="card-img-top" 
                                         alt="{{ $partage->film_title }}"
                                         onerror="this.src='https://via.placeholder.com/500x750?text=Pas+d\'image'">
                                @else
                                    <img src="https://via.placeholder.com/500x750?text=Pas+d'image" 
                                         class="card-img-top" 
                                         alt="{{ $partage->film_title }}">
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $partage->film_title }}</h5>
                                    
                                    <p class="card-text text-muted">
                                        <small><i class="far fa-clock"></i> {{ $partage->created_at->diffForHumans() }}</small>
                                    </p>

                                    @if($partage->message)
                                        <div class="alert alert-light border">
                                            <strong><i class="fas fa-envelope"></i> Message :</strong>
                                            <p class="mb-0 mt-2">{{ $partage->message }}</p>
                                        </div>
                                    @endif

                                    @if($partage->avis)
                                        <div class="alert alert-info">
                                            <strong><i class="fas fa-comment"></i> Avis de {{ $partage->user->firstname }} :</strong>
                                            <p class="mb-0 mt-2">{{ $partage->avis }}</p>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">Aucun partage reçu</h4>
                    <p class="text-muted">Vos amis n'ont pas encore partagé de films avec vous.</p>
                </div>
            @endif
        </div>

        <!-- Partages envoyés -->
        <div class="tab-pane fade" id="envoyes" role="tabpanel" aria-labelledby="envoyes-tab">
            @if($partagesEnvoyes->count() > 0)
                <div class="row">
                    @foreach($partagesEnvoyes as $partage)
                        @php
                            $ami = \App\Models\User::find($partage->friend_id);
                        @endphp
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm border-success">
                                <div class="card-header bg-success text-white">
                                    <small>
                                        <i class="fas fa-user"></i> Partagé avec 
                                        @if($ami)
                                            <strong>{{ $ami->firstname }} {{ $ami->lastname }}</strong>
                                        @else
                                            <strong>Utilisateur inconnu</strong>
                                        @endif
                                    </small>
                                </div>
                                @if($partage->film_poster_path)
                                    <img src="https://image.tmdb.org/t/p/w500{{ $partage->film_poster_path }}" 
                                         class="card-img-top" 
                                         alt="{{ $partage->film_title }}"
                                         onerror="this.src='https://via.placeholder.com/500x750?text=Pas+d\'image'">
                                @else
                                    <img src="https://via.placeholder.com/500x750?text=Pas+d'image" 
                                         class="card-img-top" 
                                         alt="{{ $partage->film_title }}">
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $partage->film_title }}</h5>
                                    
                                    <p class="card-text text-muted">
                                        <small><i class="far fa-clock"></i> {{ $partage->created_at->diffForHumans() }}</small>
                                    </p>

                                    @if($partage->message)
                                        <div class="alert alert-light border">
                                            <strong><i class="fas fa-envelope"></i> Votre message :</strong>
                                            <p class="mb-0 mt-2">{{ $partage->message }}</p>
                                        </div>
                                    @endif

                                    @if($partage->avis)
                                        <div class="alert alert-info">
                                            <strong><i class="fas fa-comment"></i> Votre avis :</strong>
                                            <p class="mb-0 mt-2">{{ $partage->avis }}</p>
                                        </div>
                                    @endif

                                    <div class="mt-auto">
                                        <a href="https://www.themoviedb.org/movie/{{ $partage->film_tmdb_id }}" 
                                           target="_blank" 
                                           class="btn btn-info btn-sm btn-block">
                                            <i class="fas fa-external-link-alt"></i> Voir sur TMDB
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-paper-plane" style="font-size: 4rem; color: #ccc;"></i>
                    <h4 class="mt-3">Aucun partage envoyé</h4>
                    <p class="text-muted">Vous n'avez pas encore partagé de films avec vos amis.</p>
                    <a href="{{ route('pageFavoris') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-share-alt"></i> Partager un film
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Inclusion de Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Scripts Bootstrap nécessaires pour les onglets -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .card-img-top {
        height: 350px;
        object-fit: cover;
    }

    .nav-tabs .nav-link.active {
        font-weight: bold;
    }

    .badge {
        font-size: 0.8rem;
    }
</style>
@endsection
