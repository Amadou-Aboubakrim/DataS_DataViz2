@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-center">Gestion des Offres d'Emploi</h2>

    <!-- Bouton pour aller à la gestion des utilisateurs -->
    <div class="text-right mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Gérer les utilisateurs</a>
    </div>

    <form action="{{ route('admin.offres.index') }}" method="GET" class="mb-4">
        <!-- Filtre Secteur -->
        <div class="form-group">
            <label for="secteur">Choisir un secteur :</label>
            <select name="secteur" id="secteur" class="form-control" onchange="this.form.submit()">
                <option value="">-- Sélectionner un secteur --</option>
                @foreach ($secteurs as $secteur)
                    <option value="{{ $secteur->secteur }}" {{ request('secteur') == $secteur->secteur ? 'selected' : '' }}>
                        {{ $secteur->secteur }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filtre Niveau d'étude -->
        <div class="form-group">
            <label for="niveau_etude">Choisir un niveau d'étude :</label>
            <select name="niveau_etude" id="niveau_etude" class="form-control" onchange="this.form.submit()">
                <option value="">-- Sélectionner un niveau d'étude --</option>
                @foreach ($niveauxEtude as $niveau)
                    <option value="{{ $niveau }}" {{ request('niveau_etude') == $niveau ? 'selected' : '' }}>
                        {{ $niveau }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if ($offres->isNotEmpty())
        <div class="offre-table">
            @foreach ($offres as $offre)
                <div class="offre-card text-center">
                    <h3>{{ $offre->titre }}</h3>
                    <div class="offre-info">
                        <p><strong>Employeur:</strong> {{ $offre->employeur }}</p>
                        <p><strong>Niveau d'étude:</strong> {{ $offre->niveau_etude }}</p>
                        <p><strong>Type de contrat:</strong> {{ $offre->contrat }}</p>
                        <p><strong>Date d'expiration:</strong> {{ \Carbon\Carbon::parse($offre->date_expiration)->format('d/m/Y') }}</p>
                    </div>
                    <a href="{{ route('admin.offres.show', ['id' => $offre->id]) }}" class="btn-logout mt-2">
                        <i class="fas fa-info-circle"></i> Détails
                    </a>
                    <form action="{{ route('admin.offres.destroy', $offre->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="pagination-links">
            {{ $offres->appends(request()->query())->links() }}
        </div>
    @else
        <p>Aucune offre trouvée pour ces critères.</p>
    @endif
</div>
@endsection
