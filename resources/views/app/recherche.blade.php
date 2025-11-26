@extends('base')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4">Rechercher un Film</h2>
            
            <form action="{{ route('recherche') }}" method="GET" class="mb-4">
                <div class="input-group input-group-lg">
                    <input type="text" name="query" class="form-control" placeholder="Entrez le titre d'un film..." value="{{ request('query') }}" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Rechercher</button>
                    </div>
                </div>
            </form>

            @if(isset($results) && count($results) > 0)
                <div class="row">
                    @foreach($results as $film)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <img src="https://image.tmdb.org/t/p/w500{{ $film['poster_path'] ?? '' }}" class="card-img-top" alt="{{ $film['title'] }}" onerror="this.src='https://via.placeholder.com/500x750?text=Pas+d\'image'">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $film['title'] }}</h5>
                                    <p class="card-text text-muted">
                                        <small>Date de sortie : {{ $film['release_date'] ?? 'N/A' }}</small>
                                    </p>
                                    <p class="card-text">{{ Str::limit($film['overview'] ?? 'Pas de description', 150) }}</p>
                                    <form action="{{ route('ajouterFavori', ['recherche' => $film['id']]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-heart"></i> Ajouter aux favoris
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif(request('query'))
                <div class="alert alert-info text-center">
                    Aucun résultat trouvé pour "{{ request('query') }}"
                </div>
            @endif
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection