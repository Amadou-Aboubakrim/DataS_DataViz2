@extends('layouts.app')

@section('content')
<div class="container">
    <div class="offre-card">
        <!-- Titre Détails de l'offre à l'intérieur de la carte -->
        <h2>Détails de l'offre</h2>
        
        <h3>{{ $offre->titre }}</h3>
        
        <p><strong>Description :</strong></p>
        <p>{{ $offre->description }}</p>

        <p><strong>Profil recherché :</strong></p>
        <p>{{ $offre->profil }}</p>
    </div>

    <!-- Bouton "Retour" avec gestion du paramètre secteur -->
    <a href="{{ url()->previous() }}" class="btn-logout mt-4">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>
@endsection

