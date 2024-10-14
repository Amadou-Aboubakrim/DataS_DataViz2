<x-app-layout>
    <!-- Ajout d'un conteneur pour tout le contenu de la page -->
    <div class="container">
        <div class="card custom-card">
            <h2 class="text-center mb-4">Mise à jour du profil</h2>

            <!-- Formulaire pour mettre à jour le profil -->
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <!-- Prénom -->
                <div class="mb-3 input-icon">
                    <x-input-label for="prenom" :value="__('Prénom')" />
                    <x-text-input id="prenom" class="form-control" type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" required autofocus />
                    <i class="fas fa-user"></i>
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                </div>

                <!-- Nom -->
                <div class="mb-3 input-icon">
                    <x-input-label for="name" :value="__('Nom')" />
                    <x-text-input id="name" class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required />
                    <i class="fas fa-user"></i>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Adresse e-mail -->
                <div class="mb-3 input-icon">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                    <i class="fas fa-envelope"></i>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Nouveau mot de passe (optionnel) -->
                <div class="mb-3 input-icon">
                    <x-input-label for="password" :value="__('Nouveau mot de passe (optionnel)')" />
                    <x-text-input id="password" class="form-control" type="password" name="password" />
                    <i class="fas fa-lock"></i>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmation du mot de passe -->
                <div class="mb-3 input-icon">
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                    <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" />
                    <i class="fas fa-lock"></i>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Bouton de mise à jour -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-tertiary">
                        {{ __('Mettre à jour') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
