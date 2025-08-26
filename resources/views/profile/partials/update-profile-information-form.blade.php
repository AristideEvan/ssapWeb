<section class="mb-4">
    <header class="mb-3">
        <h2 class="h5 text-dark font-weight-medium">
            {{ __('Informations du profil') }}
        </h2>
        <p class="text-muted small">
            {{ __("Mettez à jour les informations de profil et l'adresse e-mail de votre compte.") }}
        </p>
    </header>

    <!-- Formulaire pour renvoyer le lien de vérification -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Formulaire de mise à jour du profil -->
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="nom">{{ __('nom') }}</label>
            <input
                type="text"
                id="nom"
                name="nom"
                class="form-control @error('nom') is-invalid @enderror"
                value="{{ old('nom', $user->nom) }}"
                required
                autofocus
                autocomplete="nom"
            >
            @error('nom')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="prenom">{{ __('prenom') }}</label>
            <input
                type="text"
                id="prenom"
                name="prenom"
                class="form-control @error('prenom') is-invalid @enderror"
                value="{{ old('prenom', $user->prenom) }}"
                required
                autofocus
                autocomplete="prenom"
            >
            @error('prenom')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="identifiant">{{ __('identifiant') }}</label>
            <input
                type="text"
                id="identifiant"
                name="identifiant"
                class="form-control @error('identifiant') is-invalid @enderror"
                value="{{ old('identifiant', $user->identifiant) }}"
                required
                autofocus
                autocomplete="identifiant"
            >
            @error('identifiant')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 small text-dark">
                    {{ __('Votre adresse email n\'est pas encore verifiée.') }}
                    <button
                        type="submit"
                        form="send-verification"
                        class="btn btn-link p-0 align-baseline"
                    >
                        {{ __('Cliquer ici pour renvoyer le lien de vérification.') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="text-success small mt-2">
                        {{ __('Un nouveau lien de vérification a été envoyé par email.') }}
                    </div>
                @endif
            @endif
        </div>

        <div class="form-group d-flex align-items-center">
            <button type="submit" class="btn btn-primary mr-3">
                {{ __('Enregistrer') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-success mb-0">
                    {{ __('Enregistré.') }}
                </p>
            @endif
        </div>
    </form>
</section>
