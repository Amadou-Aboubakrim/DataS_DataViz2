<?php

namespace App\Http\Controllers;

use App\Models\offre_emplois;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer tous les secteurs distincts de la table offre_emplois en excluant "N/A"
        $secteurs = offre_emplois::select('secteur')
            ->where('secteur', '!=', 'N/A')  // Exclure "N/A"
            ->distinct()
            ->get();

        // Récupérer tous les niveaux d'étude distincts
        $niveauxEtude = offre_emplois::select('niveau_etude')->distinct()->get()->pluck('niveau_etude');

        // Récupérer toutes les années d'expérience distinctes de la table offre_emplois
        $anneesExperience = offre_emplois::select('annee_experience')->distinct()->get()->pluck('annee_experience');

        // Récupérer les offres d'emploi en fonction des filtres appliqués
        $query = offre_emplois::query();

        // Appliquer les filtres en fonction des critères
        if ($request->has('secteur') && $request->input('secteur') != '') {
            $secteurChoisi = $request->input('secteur');
            $query->where('secteur', $secteurChoisi);
        }

        if ($request->has('niveau_etude') && $request->input('niveau_etude') != '') {
            $niveauEtude = $request->input('niveau_etude');
            $query->where('niveau_etude', $niveauEtude);
        }

        if ($request->has('annee_experience') && $request->input('annee_experience') != '') {
            $anneeExperience = $request->input('annee_experience');
            $query->where('annee_experience', '>=', $anneeExperience);
        }

        // Récupérer les offres filtrées et paginées
        $offres = $query->paginate(10);

        // Retourner la vue avec les données
        return view('student.index', compact('secteurs', 'niveauxEtude', 'offres', 'anneesExperience'));
    }

    // Méthode pour afficher les détails d'une offre
    public function show($id)
    {
        // Récupérer l'offre d'emploi par son ID
        $offre = offre_emplois::findOrFail($id);

        // Retourner la vue avec les détails de l'offre
        return view('student.show', compact('offre'));
    }
}
