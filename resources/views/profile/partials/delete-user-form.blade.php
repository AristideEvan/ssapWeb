<section class="mb-4">
    <header class="mb-3">
        <h2 class="h5 text-dark font-weight-medium">
            {{ __('Suppression du compte') }}
        </h2>
    </header>

    <!-- Trigger Button for Modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmUserDeletionModal">
        {{ __('Supprimer mon compte') }}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" role="dialog" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
                @csrf
                @method('delete')

                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUserDeletionLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="text-muted small">
                        {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront permanentement supprimées. Avant de supprimer votre compte, veuillez enregistrer tout les données que vous souhaitez conserver.') }}
                    </p>

                    <div class="form-group">
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input
                            type="password"
                            class="form-control w-75"
                            id="password"
                            name="password"
                            placeholder="{{ __('Password') }}"
                        >
                        @if ($errors->userDeletion->has('password'))
                            <small class="form-text text-danger mt-2">
                                {{ $errors->userDeletion->first('password') }}
                            </small>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger">
                        {{ __('Supprimer votre compte') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
