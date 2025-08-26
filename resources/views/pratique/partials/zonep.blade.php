<div class="zonep-container" id="zonep-container{{ $uniqueIndex }}">
    <div class="row">
        <div class="col-12 col-md-6">
            <label for="paysp{{ $uniqueIndex }}"> {{ __('Pays') }} <span style="color: red">*</span></label>
            <span title="{{ __('Supprimer') }}" class="fa fa-trash text-danger float-right d-md-none removeZonep" style="cursor: pointer;"></span>
            <select class="form-control paysp js-example-basic-single @error('zonesp.' . $uniqueIndex . '.pays') is-invalid @enderror"
                name="zonesp[{{ $uniqueIndex }}][pays]" id="paysp{{ $uniqueIndex }}">
                <option value="" selected disabled>
                    {{ __('Selectionner le pays') }}</option>
                @foreach ($pays as $item)
                    <option value="{{ $item->localite_id }}">
                        {{ $item->nomLocalite }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ __('formulaire.Obligation') }}
            </div>
            @error('zonesp.' . $uniqueIndex . '.pays')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="col-12 col-md-6">
            <label for="localitep{{ $uniqueIndex }}"> {{ __('Localité') }} <span style="color: red">*</span></label>
            <span title="{{ __('Supprimer') }}" class="fa fa-trash text-danger float-right d-none d-md-inline removeZonep" style="cursor: pointer;"></span>
            <select id="localitep{{ $uniqueIndex }}"
                class="form-control localitep js-example-basic-single @error('zonesp.' . $uniqueIndex . '.localite') is-invalid @enderror"
                name="zonesp[{{ $uniqueIndex }}][localite]">
                <option value="" selected disabled>
                    {{ __('Selectionner localité') }}</option>
            </select>
            <div class="invalid-feedback">
                {{ __('formulaire.Obligation') }}
            </div>
            @error('zonesp.' . $uniqueIndex . '.localite')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </div>
</div>
