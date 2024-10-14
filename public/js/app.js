import './bootstrap';

import 'bootstrap';
import 'jquery';

document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour ouvrir la modale
    window.openDetails = function(id) {
        // Effectuer une requête AJAX pour obtenir les détails de l'offre
        fetch(`/offre-details/${id}`)
            .then(response => response.json())
            .then(data => {
                // Mettre à jour les éléments de la modale avec les données reçues
                document.getElementById('modal-title').innerText = data.titre;
                document.getElementById('modal-description').innerText = data.description;
                document.getElementById('modal-profil').innerText = data.profil;

                // Afficher la modale
                document.getElementById('details-modal').style.display = 'block';
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des détails de l\'offre :', error);
            });
    }

    // Fonction pour fermer la modale
    window.closeDetails = function() {
        document.getElementById('details-modal').style.display = 'none';
    }
});
