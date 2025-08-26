@if (canMakePublic(Auth::user()))
    <div class="w-100">
        <div class="custom-control custom-switch float-right mr-5">
            <input type="checkbox" data-publique="{{ $pratique->publique ? $pratique->pratique_id : '' }}"
                name="selected_publique[]" class="custom-control-input publique-checkbox" id="switchElement"
                value="{{ $pratique->pratique_id }}" {{ $pratique->publique ? 'checked' : '' }}>
            <label class="custom-control-label" for="switchElement" style="font-size: 1rem">{{ __('Publier') }}</label>
        </div>
    </div>
@endif
