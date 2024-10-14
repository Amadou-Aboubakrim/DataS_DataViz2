<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <div class="card custom-card mx-auto my-auto">
        <h2 class="text-center mb-4">Réinitialiser le mot de passe</h2>
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-3 input-icon">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control" required value="{{ old('email', $request->email) }}" placeholder="Email">
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3 input-icon">
                <label for="password" class="form-label">{{ __('Nouveau mot de passe') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Mot de passe">
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 input-icon">
                <label for="password_confirmation" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required placeholder="Confirmer le mot de passe">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-tertiary">
                    {{ __('Réinitialiser le mot de passe') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
