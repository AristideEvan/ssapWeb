<section class="mb-4">
    <header class="mb-3">
        <h2 class="h5 text-dark font-weight-medium">
            {{ __('Mise à jour du mot de passe') }}
        </h2>
        <p class="text-muted small">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aleatoire pour rester safe.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">{{ __('Mot de passe actuel') }}</label>
            <input
                type="password"
                id="update_password_current_password"
                name="current_password"
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                autocomplete="current-password"
            >
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">{{ __('Nouveau mot de passe') }}</label>
            <input
                type="password"
                id="update_password_password"
                name="password"
                class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password"
            >
            @error('password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">{{ __('Confirmer le mot de passe') }}</label>
            <input
                type="password"
                id="update_password_password_confirmation"
                name="password_confirmation"
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password"
            >
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group d-flex align-items-center">
            <button type="submit" class="btn btn-primary mr-3">
                {{ __('Enregistrer') }}
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-success mb-0">
                    {{ __('Enregistré.') }}
                </p>
            @endif
        </div>
    </form>
</section>
