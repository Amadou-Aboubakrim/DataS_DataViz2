<?php

namespace App\Http\Controllers;

use App\Models\offre_emplois;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    public function getDetails($id)
    {
        // Récupérer l'offre par son ID
        $offre = offre_emplois::find($id);

        if ($offre) {
            return response()->json([
                'titre' => $offre->titre,
                'description' => $offre->description,
                'profil' => $offre->profil
            ]);
        } else {
            return response()->json(['message' => 'Offre non trouvée'], 404);
        }
    }
}
