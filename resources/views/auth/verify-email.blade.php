<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <div class="card custom-card mx-auto my-auto">
        <h2 class="text-center mb-4">Vérification de l'email</h2>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous vous avons envoyé. Si vous n’avez pas reçu l’email, nous vous en enverrons un autre.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Un nouveau lien de vérification a été envoyé à l’adresse email fournie lors de l’inscription.') }}
            </div>
        @endif

        <div class="text-center mt-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-tertiary">
                    {{ __('Renvoyer l\'email de vérification') }}
                </button>
            </form>
        </div>

        <div class="text-center mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-tertiary">
                    {{ __('Se déconnecter') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
