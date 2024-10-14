<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <div class="card custom-card mx-auto my-auto">
        <h2 class="text-center mb-4">Confirmez votre mot de passe</h2>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Veuillez confirmer votre mot de passe avant de continuer.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-3 input-icon">
                <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Mot de passe">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-tertiary">
                    {{ __('Confirmer') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
