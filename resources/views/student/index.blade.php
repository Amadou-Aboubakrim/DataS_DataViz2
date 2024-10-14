@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Titre de la page centré -->
    <h2 class="text-center">Listes des  offres d'emploi</h2>

    <!-- Description de la page, centrée également -->
    <p class="text-center mb-4"> Utilisez les filtres ci-dessous pour trouvez l'offre qui correspond à votre profil. </p>

    <!-- Formulaire de sélection des filtres -->
    <form action="{{ route('student.index') }}" method="GET" class="mb-4">
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
                    @if ($niveau !== 'N/A') <!-- Exclure "N/A" -->
                        <option value="{{ $niveau }}" {{ request('niveau_etude') == $niveau ? 'selected' : '' }}>
                            {{ $niveau }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <!-- Si des offres sont disponibles, afficher le tableau sous forme de carte -->
    @if ($offres->isNotEmpty())
        <div class="offre-table">
            @foreach ($offres as $offre)
                <div class="offre-card text-center">
                    <!-- Titre de l'offre centré -->
                    <h3>{{ $offre->titre }}</h3>
                    <div class="offre-info">
                        <p>
                            <i class="fas fa-building"></i> <strong>Employeur:</strong> {{ $offre->employeur }}
                        </p>
                        <p>
                            <i class="fas fa-graduation-cap"></i> <strong>Niveau d'étude:</strong> {{ $offre->niveau_etude }}
                        </p>
                        <p>
                            <i class="fas fa-briefcase"></i> <strong>Type de contrat:</strong> {{ $offre->contrat }}
                        </p>
                        <p>
                            <i class="fas fa-briefcase"></i> <strong>Année expérience:</strong> {{ $offre->annee_experience}}
                        </p>
                        <p>
                            <i class="fas fa-calendar-alt"></i> <strong>Date
                                d'expiration:</strong> {{ \Carbon\Carbon::parse($offre->date_expiration)->format('d/m/Y') }}
                        </p>
                    </div>

                    <!-- Bouton détails avec style et icône -->
                    <a href="{{ route('student.show', ['id' => $offre->id]) }}" class="btn-logout mt-2">
                        <i class="fas fa-info-circle"></i> Détails
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Liens de pagination avec conservation des paramètres de requête -->
        <div class="pagination-links">
            {{ $offres->appends(request()->query())->links() }}
        </div>

    @else
        <p>Aucune offre trouvée pour ce secteur.</p>
    @endif
</div>
@endsection
