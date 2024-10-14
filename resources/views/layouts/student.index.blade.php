@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Rechercher des offres d'emploi</h2>

    <!-- Formulaire de sélection de secteur -->
    <form action="{{ route('student.index') }}" method="GET" class="mb-4">
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
    </form>

    <!-- Si des offres sont disponibles, afficher le tableau -->
    @if ($offres->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Employeur</th>
                    <th>Année d'expérience</th>
                    <th>Niveau d'étude</th>
                    <th>Type de contrat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offres as $offre)
                    <tr>
                        <td>{{ $offre->titre }}</td>
                        <td>{{ $offre->employeur }}</td>
                        <td>{{ $offre->annee_experience }}</td>
                        <td>{{ $offre->niveau_etude }}</td>
                        <td>{{ $offre->contrat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucune offre trouvée pour ce secteur.</p>
    @endif
</div>
@endsection
