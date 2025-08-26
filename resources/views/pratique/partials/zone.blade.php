<div class="zone-container" id="zone-container{{ $uniqueIndex }}">
    <div class="row">
        <div class="col-12 col-md-6">
            <label for="pays{{ $uniqueIndex }}"> {{ __('Pays') }} <span style="color: red">*</span></label>
            <span title="{{ __('Supprimer') }}" class="fa fa-trash text-danger float-right d-md-none removeZone" style="cursor: pointer;"></span>
            <select class="form-control pays js-example-basic-single @error('zones.' . $uniqueIndex . '.pays') is-invalid @enderror"
                name="zones[{{ $uniqueIndex }}][pays]" id="pays{{ $uniqueIndex }}">
                <option value="" selected disabled>{{ __('Selectionner le pays') }}</option>
                @foreach ($pays as $item)
                    <option value="{{ $item->localite_id }}">{{ $item->nomLocalite }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ __('formulaire.Obligation') }}
            </div>
            @error('zones.' . $uniqueIndex . '.pays')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
        <div class="col-12 col-md-6">
            <label for="localite{{ $uniqueIndex }}"> {{ __('Localité') }} <span style="color: red">*</span></label>
            <span title="{{ __('Supprimer') }}" class="fa fa-trash text-danger float-right d-none d-md-inline removeZone" style="cursor: pointer;"></span>
            <select id="localite{{ $uniqueIndex }}"
                class="form-control localite js-example-basic-single @error('zones.' . $uniqueIndex . '.localite') is-invalid @enderror"
                name="zones[{{ $uniqueIndex }}][localite]">
                <option value="" selected disabled>
                    {{ __('Selectionner localité') }}</option>
            </select>
            <div class="invalid-feedback">
                {{ __('formulaire.Obligation') }}
            </div>
            @error('zones.' . $uniqueIndex . '.localite')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label for="latitude{{ $uniqueIndex }}"> {{ __('Latitude') }}</label>
            <input type="text" name="zones[{{ $uniqueIndex }}][latitude]" class="form-control" id="latitude{{ $uniqueIndex }}" pattern="^-?([1-8]?\d(\.\d+)?|90(\.0+)?)$" placeholder="12.2418505">
        </div>
        @if ($errors->has("zones.$uniqueIndex.latitude"))
            <small class="text-danger">{{ $errors->first("zones.$uniqueIndex.latitude") }}</small>
        @endif
        <div class="col-6">
            <label for="longitude{{ $uniqueIndex }}"> {{ __('Longitude') }}</label>
            <input type="text" name="zones[{{ $uniqueIndex }}][longitude]" class="form-control" id="longitude{{ $uniqueIndex }}" pattern="^-?((1[0-7]\d|[1-9]?\d)(\.\d+)?|180(\.0+)?)$" placeholder="-1.5567604999999958">
        </div>
        @if ($errors->has("zones.$uniqueIndex.longitude"))
            <small class="text-danger">{{ $errors->first("zones.$uniqueIndex.longitude") }}</small>
        @endif
    </div>
</div>
<script>
     jQuery('select').select2({
        language: "fr",
        width: '100%'
    });

    $(".js-select2").select2({
        closeOnSelect : false,
        placeholder : "",
        allowHtml: true,
        allowClear: true,
        tags: true
    });
</script>
