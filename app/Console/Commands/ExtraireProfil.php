<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\offre_emplois; // Import du modèle

class ExtraireProfil extends Command
{
    protected $signature = 'extraire:profil';
    protected $description = 'Extraction du profil recherché depuis la description des offres d\'emploi';

    public function handle()
    {
        // Récupérer toutes les offres d'emploi via le modèle
        $offres = offre_emplois::all();

        foreach ($offres as $offre) {
            // Vérifier si la description contient "Profil recherché"
            if (preg_match('/Profil\s+recherché\s*(:|\n)/i', $offre->description)) {
                // Extraire le contenu après "Profil recherché"
                $profil = $this->extraireProfil($offre->description);

                if ($profil) {
                    // Mettre à jour la colonne 'profil' via le modèle Eloquent
                    $offre->update(['profil' => $profil]);

                    $this->info("Profil extrait pour l'offre ID {$offre->id}");
                } else {
                    $this->info("Aucun profil trouvé pour l'offre ID {$offre->id}");
                }
            } else {
                $this->info("Pas de 'Profil recherché' trouvé pour l'offre ID {$offre->id}");
            }
        }
    }

    /**
     * Fonction pour extraire le texte après "Profil recherché".
     */
    protected function extraireProfil($description)
    {
        // Extraire tout ce qui suit "Profil recherché"
        $regex = '/Profil\s+recherché\s*(:|\n)(.*?)(Missions|Avantages|Responsabilités|$)/is';

        if (preg_match($regex, $description, $match)) {
            return trim($match[2]); // Retourne le texte extrait entre "Profil recherché" et la section suivante
        }

        return null; // Si aucun profil n'est trouvé
    }
}
