<?php

namespace App\Http\Controllers;

use App\Models\offre_emplois;
use App\Models\User; // Importation du modèle User
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Méthode pour gérer les offres d'emploi (déjà présente)
    public function index(Request $request)
    {
        $secteurs = offre_emplois::select('secteur')->distinct()->get();
        $niveauxEtude = offre_emplois::select('niveau_etude')->distinct()->get()->pluck('niveau_etude');
        
        $query = offre_emplois::query();
        
        if ($request->has('secteur') && $request->input('secteur') != '') {
            $query->where('secteur', $request->input('secteur'));
        }
        
        if ($request->has('niveau_etude') && $request->input('niveau_etude') != '') {
            $query->where('niveau_etude', $request->input('niveau_etude'));
        }
        
        $offres = $query->paginate(10);
        
        return view('admin.offres.index', compact('secteurs', 'niveauxEtude', 'offres'));
    }

    // Méthode pour afficher les détails d'une offre d'emploi (déjà présente)
    public function show($id)
    {
        $offre = offre_emplois::findOrFail($id);
        return view('admin.offres.show', compact('offre'));
    }

    // Méthode pour supprimer une offre d'emploi (déjà présente)
    public function destroy($id)
    {
        $offre = offre_emplois::findOrFail($id);
        $offre->delete();
        return redirect()->route('admin.offres.index')->with('success', 'Offre supprimée avec succès.');
    }

    // **Nouvelle fonctionnalité : Gestion des utilisateurs**

    // Méthode pour afficher la liste des utilisateurs
    public function usersIndex()
    {
        $users = User::paginate(10); // Récupère les utilisateurs paginés
        return view('admin.users.index', compact('users'));
    }

    // Méthode pour supprimer un utilisateur
    public function destroyUser($id)
    {
        $user = User::findOrFail($id); // Récupérer l'utilisateur par ID
        $user->delete(); // Supprimer l'utilisateur
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
