<nav class="navbar"> 
   <!-- Boutons Offre, Visualisation, Profil et Déconnexion -->
    <div class="auth-buttons">
        <!-- Nouveau bouton pour la page Étudiant -->
        <a href="{{ url('/student') }}" class="btn-offre-emplois">
            <i class="fa fa-briefcase"></i> Offre d'Emplois
        </a>

        <!-- Nouveau bouton pour la page Visualisation -->
        <a href="{{ url('/visualisation') }}" class="btn-visualisation">
            <i class="fa fa-chart-bar"></i> Visualisation
        </a>

        <!-- Bouton Administrateur -->
        <a href="{{ url('/admin/offres') }}" class="btn-admin">
            <i class="fa fa-cogs"></i> Administrateur
        </a>

        <!-- Bouton Profil -->
        <a href="{{route('profile.edit') }}" class="btn-profile">
            <i class="fa fa-user"></i> Profil
        </a>

        <!-- Bouton Déconnexion -->
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <a href="{{ route('logout') }}" class="btn-logout"
               onclick="event.preventDefault(); this.closest('form').submit();">
               <i class="fa fa-sign-out-alt"></i> Déconnexion
            </a>
        </form>
    </div>
</nav>
