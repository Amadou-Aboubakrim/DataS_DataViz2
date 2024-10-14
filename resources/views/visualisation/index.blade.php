@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Titre de la page -->
    <h1 class="text-center">Page de Visualisation de quelques indicateurs</h1>
    <p class="text-center text-muted">Utilisez le menu ci-dessous pour choisir l'indicateur qui vous intéresse.</p>

    <!-- Dashboard principal pour le nombre total d'offres -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card-dashboard total-offers-dashboard">
                <h5 class="dashboard-text-center">Nombre total d'offres</h5>
                <p class="dashboard-text-center">{{ $totalOffers }} offres</p>
                <div class="dashboard-text-center">
                    <i class="fas fa-briefcase fa-3x dashboard-icon"></i> <!-- Icône pour le total des offres -->
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de sélection de l'indicateur -->
    <form method="GET" action="{{ route('visualisation.index') }}" class="mb-4">
        <div class="form-group">
            <label for="selectedIndicator">Sélectionner un indicateur :</label>
            <select name="selectedIndicator" id="selectedIndicator" class="form-control">
                <option value="">-- Choisir un indicateur --</option>
                <option value="region" {{ request('selectedIndicator') == 'region' ? 'selected' : '' }}>Région</option>
                <option value="contrat" {{ request('selectedIndicator') == 'contrat' ? 'selected' : '' }}>Type de contrat</option>
                <option value="secteur" {{ request('selectedIndicator') == 'secteur' ? 'selected' : '' }}>Secteur</option> <!-- Ajout de l'option secteur -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Appliquer</button>
    </form>

    <!-- Vérification s'il y a des données -->
    @if($indicateurs->isEmpty())
        <p class="text-center text-muted">Aucune donnée disponible pour cet indicateur.</p>
    @else
        <div class="row">
            @foreach ($indicateurs as $index => $indicateur)
                <div class="col-md-4 mb-4"> <!-- Afficher 3 dashboards par ligne -->
                    <div class="card-dashboard card-filter color-{{ $index % 6 }}"> 
                        <h5 class="dashboard-text-center">{{ $indicateur->secteur ?? $indicateur->region ?? $indicateur->contrat }}</h5>
                        <p class="dashboard-text-center">{{ $indicateur->total_offers }} offres</p>
                        <div class="dashboard-text-center">
                            @if($selectedIndicator === 'region')
                                <i class="fas fa-map-marker-alt fa-2x dashboard-icon"></i> <!-- Icône pour les régions -->
                            @elseif($selectedIndicator === 'contrat')
                                <i class="fas fa-file-contract fa-2x dashboard-icon"></i> <!-- Icône pour les types de contrat -->
                            @else
                                <i class="fas fa-briefcase fa-2x dashboard-icon"></i> <!-- Icône par défaut -->
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Diagramme pour la répartition par secteur d'activité -->
    @if($selectedIndicator === 'secteur' && !$secteurs->isEmpty())
        <h1 class="text-center">Répartition par Secteur d'Activité</h1>
        <canvas id="secteurChart" width="400" height="400"></canvas>

        <script>
            var ctx = document.getElementById('secteurChart').getContext('2d');
            var secteurChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($labels), // Tableau contenant les noms des secteurs
                    datasets: [{
                        label: 'Répartition par secteur',
                        data: @json($data), // Tableau contenant les valeurs des offres par secteur
                        backgroundColor: @json($colors), // Utilisation des couleurs générées
                        borderColor: 'rgba(255, 255, 255, 1)', // Couleur de la bordure
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right', // Position de la légende
                            labels: {
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    return data.labels.map((label, index) => {
                                        const value = data.datasets[0].data[index];
                                        const total = data.datasets[0].data.reduce((acc, val) => acc + val, 0);
                                        const percentage = ((value / total) * 100).toFixed(2) + '%'; // Calcul du pourcentage
                                        return {
                                            text: `${label}: ${percentage}`, // Texte à afficher
                                            fillStyle: data.datasets[0].backgroundColor[index],
                                        };
                                    });
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw + ' offres';
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endif
</div>
@endsection
