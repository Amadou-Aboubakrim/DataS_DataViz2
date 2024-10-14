@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'offre : {{ $offre->titre }}</h1>

    <form action="{{ route('admin.offres.update', $offre->id) }}" method="POST">
        @csrf
        @method('POST')
        
        <!-- Ajoutez ici vos champs de formulaire -->
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="{{ $offre->titre }}" required>
        </div>
        <!-- Ajoutez d'autres champs selon votre modèle -->

        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
</div>
@endsection
