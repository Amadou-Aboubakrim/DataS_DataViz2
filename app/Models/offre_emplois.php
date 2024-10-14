<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offre_emplois extends Model
{
    use HasFactory;
    protected $table = 'offre_emplois'; // Nom de la table dans la base de données

    protected $fillable = [
        'titre',
        'region',
        'secteur',
        'niveau_etude',
        'annee_experience',
        'contrat',
        'mode_travail',
        'date_publication',
        'date_expiration',
        'employeur',
        'description',
        'profil',
        'competences',
    ];
}