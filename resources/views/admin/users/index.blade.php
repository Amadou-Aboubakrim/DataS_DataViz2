@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-center">Gestion des Utilisateurs</h2>

    <!-- Bouton pour aller à la gestion des offres d'emploi -->
    <div class="text-right mb-3">
        <a href="{{ route('admin.offres.index') }}" class="btn btn-primary">Gérer les offres d'emploi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($users->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->prenom }}</td> <!-- Affiche le prénom -->
                        <td>{{ $user->name }}</td> <!-- Affiche le nom -->
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-links">
            {{ $users->links() }}
        </div>
    @else
        <p>Aucun utilisateur trouvé.</p>
    @endif
</div>
@endsection
