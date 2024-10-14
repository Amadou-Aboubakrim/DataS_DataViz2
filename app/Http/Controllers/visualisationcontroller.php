<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisualisationController extends Controller
{
    public function index(Request $request)
    {
        $selectedIndicator = $request->get('selectedIndicator', 'region');

        // Récupération du nombre total d'offres
        $totalOffers = DB::table('offre_emplois')->count();

        // Récupération des secteurs et du nombre d'offres par secteur, excluant les secteurs 'N/A'
        $secteurs = DB::table('offre_emplois')
            ->select('secteur', DB::raw('COUNT(*) as total_offers'))
            ->whereNotNull('secteur')
            ->where('secteur', '<>', '')
            ->where('secteur', '<>', 'N/A') // Exclure 'N/A'
            ->groupBy('secteur')
            ->orderBy('total_offers', 'desc')
            ->get();

        $labels = $secteurs->pluck('secteur');
        $data = $secteurs->pluck('total_offers');

        // Générer des couleurs aléatoires pour chaque secteur
        $colors = [];
        foreach ($secteurs as $secteur) {
            $colors[] = sprintf(
                'rgba(%d, %d, %d, 0.8)',
                rand(0, 255), // Rouge
                rand(0, 255), // Vert
                rand(0, 255)  // Bleu
            );
        }

        // Vérification si l'indicateur sélectionné est 'region' ou 'contrat'
        if ($selectedIndicator === 'region') {
            $indicateurs = DB::table('offre_emplois')
                ->select('region', DB::raw('COUNT(*) as total_offers'))
                ->whereNotNull('region')
                ->where('region', '<>', '')
                ->groupBy('region')
                ->orderByDesc('total_offers')
                ->get();
        } elseif ($selectedIndicator === 'contrat') {
            $indicateurs = DB::table('offre_emplois')
                ->select('contrat', DB::raw('COUNT(*) as total_offers'))
                ->whereNotNull('contrat')
                ->where('contrat', '<>', '')
                ->groupBy('contrat')
                ->orderByDesc('total_offers')
                ->get();
        } elseif ($selectedIndicator === 'secteur') {
            $indicateurs = $secteurs; // Utiliser les secteurs pour la sélection
        } else {
            $indicateurs = collect(); // Collection vide si aucun indicateur valide sélectionné
        }

        return view('visualisation.index', compact('indicateurs', 'totalOffers', 'selectedIndicator', 'labels', 'data', 'colors', 'secteurs'));
    }
}
