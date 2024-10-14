<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <div class="card custom-card mx-auto my-auto">
        <h2 class="text-center mb-4">Mot de passe oublié</h2>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Entrez votre adresse email pour recevoir un lien de réinitialisation.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3 input-icon">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control" required autofocus placeholder="Email">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-tertiary">
                    {{ __('Envoyer le lien de réinitialisation') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
