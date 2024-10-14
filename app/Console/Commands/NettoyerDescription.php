<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\offre_emplois;

class NettoyerDescription extends Command
{
    protected $signature = 'nettoyer:description';
    protected $description = 'Supprime la partie "Profil recherché" de la description des offres d\'emploi';

    public function handle()
    {
        // Récupérer toutes les offres d'emploi depuis la table offre_emplois
        $offres = offre_emplois::all();

        foreach ($offres as $offre) {
            // Vérifier si la description contient "Profil recherché"
            if (preg_match('/Profil\s+recherché\s*(:|\n)/i', $offre->description)) {
                // Supprimer la partie de la description après "Profil recherché"
                $updatedDescription = preg_replace('/Profil\s+recherché\s*(:|\n).*$/is', '', $offre->description);

                // Mettre à jour la colonne 'description' dans la base de données
                $offre->update(['description' => $updatedDescription]);

                $this->info("Description mise à jour pour l'offre ID {$offre->id}");
            } else {
                $this->info("Pas de 'Profil recherché' trouvé pour l'offre ID {$offre->id}");
            }
        }
    }
}
