<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <div class="header">
        <div class="navbar"> 
            <a href="{{ route('login') }}" class="btn-primary">Connexion</a>
            <a href="{{ route('register') }}" class="btn-secondary">Inscription</a>
        </div>
    </div>
    <div class="container">
        <h1>Bienvenue sur notre plateforme</h1>
        <p>
        Elle a été conçue pour centraliser et faciliter l'accès aux offres d'emploi au Sénégal. Grâce à une interface intuitive, vous pouvez explorer une vaste sélection d'opportunités d'emploi que vous soyez à la recherche d'un stage, d'un emploi ou que vous soyez recruteur. En plus des indicateurs pour avoir un apercu des tendances du marché de l'emploi en toute simplicité.
        </p>
        <p>
            Inscrivez-vous dès maintenant pour accéder à des fonctionnalités personnalisées
        </p>
    </div>      
</body>
</html>
