@extends('base')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4">Rechercher un Film</h2>

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
            
            <form action="{{ route('recherche') }}" method="GET" class="mb-4">
                <div class="input-group input-group-lg">
                    <input type="text" name="query" class="form-control" placeholder="Entrez le titre d'un film..." value="{{ request('query') }}" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>

            @if(isset($results) && count($results) > 0)
                <div class="alert alert-success">
                    <i class="fas fa-film"></i> <strong>{{ count($results) }}</strong> résultat{{ count($results) > 1 ? 's' : '' }} trouvé{{ count($results) > 1 ? 's' : '' }} pour "{{ request('query') }}"
                </div>
                <div class="row">
                    @foreach($results as $film)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="https://image.tmdb.org/t/p/w500{{ $film['poster_path'] ?? '' }}" class="card-img-top" alt="{{ $film['title'] }}" onerror="this.src='https://via.placeholder.com/500x750?text=Pas+d\'image'">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $film['title'] }}</h5>
                                    <p class="card-text text-muted">
                                        <small>
                                            <i class="far fa-calendar-alt"></i> Date de sortie : {{ $film['release_date'] ?? 'N/A' }}
                                        </small>
                                    </p>
                                    @if(isset($film['vote_average']) && $film['vote_average'] > 0)
                                        <p class="card-text text-warning">
                                            <small>
                                                <i class="fas fa-star"></i> Note : {{ number_format($film['vote_average'], 1) }}/10
                                            </small>
                                        </p>
                                    @endif
                                    <p class="card-text">{{ Str::limit($film['overview'] ?? 'Pas de description disponible.', 150) }}</p>
                                    <div class="mt-auto">
                                        <form action="{{ route('ajouterFavori', ['recherche' => $film['id']]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-block">
                                                <i class="fas fa-heart"></i> Ajouter aux favoris
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif(request('query'))
                <div class="alert alert-warning text-center">
                    <i class="fas fa-search"></i> Aucun résultat trouvé pour "<strong>{{ request('query') }}</strong>"
                    <p class="mt-2 mb-0">Essayez avec un autre titre de film.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Scripts Bootstrap nécessaires pour les alertes -->
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
        height: 400px;
        object-fit: cover;
    }

    .btn-danger {
        transition: all 0.3s;
    }

    .btn-danger:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4);
    }
</style>
@endsection