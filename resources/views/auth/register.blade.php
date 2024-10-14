<x-guest-layout>
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <div class="card custom-card">
        <h2 class="text-center mb-4">Inscription</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

           <!-- Prénom -->
            <div class="mb-3 input-icon">
                <x-input-label for="prenom" :value="__('Prénom')" />
                <x-text-input id="prenom" class="form-control" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="name" />
                <i class="fas fa-user"></i> <!-- Icône du bonhomme pour le prénom -->
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>

            <!-- Nom -->
            <div class="mb-3 input-icon">
                <x-input-label for="name" :value="__('Nom')" />
                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <i class="fas fa-user"></i> <!-- Icône du bonhomme pour le nom -->
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-3 input-icon">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <i class="fas fa-envelope"></i> <!-- Icône de l'enveloppe pour l'email -->
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-3 input-icon">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                <i class="fas fa-lock"></i> <!-- Icône de la serrure pour le mot de passe -->
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 input-icon">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                <i class="fas fa-lock"></i> <!-- Icône de la serrure pour confirmer le mot de passe -->
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-tertiary">
                    {{ __('Crée un Compte') }}
                </button>
            </div>

            <div class="text-center mt-2">
            <p class="text-inscription">Déjà inscrit? <a href="{{ route('login') }}" class="text-link">{{ __('Connecter-vous') }}</a></p>
            </div>
        </form>
    </div>
</x-guest-layout>
