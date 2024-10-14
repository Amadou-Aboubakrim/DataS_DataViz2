<?php

// Fonction pour attribuer des couleurs aux indicateurs
function getColorByIndex($index)
{
    // Liste de couleurs attribuées en fonction de l'indice
    $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-secondary'];
    return $colors[$index % count($colors)];
}
