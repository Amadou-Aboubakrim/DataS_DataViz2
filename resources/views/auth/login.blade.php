<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <div class="card custom-card mx-auto my-auto">
        <h2 class="text-center mb-4">Connexion</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3 input-icon">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span> <!-- Icône de l'email -->
                    <input type="email" id="email" name="email" class="form-control" required autofocus placeholder="Email" autocomplete="email">
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3 input-icon">
                <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span> <!-- Icône du mot de passe -->
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Mot de passe" autocomplete="current-password">
                </div>
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">{{ __('Se rappeler de moi') }}</label>
            </div>

            <div class="text-center">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm">{{ __('Mot de passe oublié?') }}</a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-tertiary">
                    {{ __('Se Connecter') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
