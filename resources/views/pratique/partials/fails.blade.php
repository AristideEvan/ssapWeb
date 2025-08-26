@foreach ($zones as $zone)
    @php
        $parent = DB::table('localites')
            ->where('localite_id', $zone['pays'])
            ->first();
        $enfants = DB::select('SELECT "localite_id", "nomLocalite" FROM "listeLocalite" WHERE "p0" = ?', [
            $parent->localite_id,
        ]);
    @endphp
    <div class="zone-container">
        <div class="row">
            <div class="col-12 col-md-6">
                <label for="pays{{ $loop->iteration }}">{{ __('Pays') }}</label>
                <span title="{{ __('Supprimer') }}" class="fa fa-trash text-danger float-right d-md-none removeZone"
                    style="cursor: pointer;"></span>

                <select name="zones[{{ $loop->iteration }}][pays]" id="pays{{ $loop->iteration }}"
                    class="form-control pays js-example-basic-single">
                    <option value="">{{ __('Sélectionnez une localité') }}
                    </option>
                    @foreach ($pays as $item)
                        <option value="{{ $item->localite_id }}"
                            {{ $item->localite_id == $zone['pays'] ? 'selected' : '' }}>
                            {{ $item->nomLocalite }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label for="localite{{ $loop->iteration }}">{{ __('Localité') }}</label>
                <span title="{{ __('Supprimer') }}"
                    class="fa fa-trash text-danger float-right d-none d-md-inline removeZone"
                    style="cursor: pointer;"></span>
                <select name="zones[{{ $loop->iteration }}][localite]" id="localite{{ $loop->iteration }}"
                    class="localite js-example-basic-single">
                    @foreach ($enfants as $enfant)
                        <option value="{{ $enfant->localite_id }}"
                            {{ $enfant->localite_id == $zone['localite'] ? 'selected' : '' }}>
                            {{ $enfant->nomLocalite }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <label for="latitude{{ $loop->iteration }}">
                    {{ __('latitude') }}</label>
                <input type="text" name="zones[{{ $loop->iteration }}][latitude]"
                    class="form-control coordinates latitude" id="latitude{{ $loop->iteration }}"
                    value="{{ $zone['latitude'] }}" pattern="^-?([1-8]?\d(\.\d+)?|90(\.0+)?)$" placeholder="12.2418505">
                @if ($errors->has("zones.{$loop->iteration}.latitude"))
                    <small class="text-danger">{{ $errors->first("zones.{$loop->iteration}.latitude") }}
                    </small>
                @endif
            </div>
            <div class="col-12 col-md-6">
                <label for="longitude{{ $loop->iteration }}">
                    {{ __('Longitude') }}</label>
                <input type="text" name="zones[{{ $loop->iteration }}][longitude]"
                    class="form-control coordinates longitude" id="longitude{{ $loop->iteration }}"
                    value="{{ $zone['longitude'] }}" pattern="^-?((1[0-7]\d|[1-9]?\d)(\.\d+)?|180(\.0+)?)$" placeholder="-1.5567604999999958">
                @if ($errors->has("zones.{$loop->iteration}.longitude"))
                    <small class="text-danger">{{ $errors->first("zones.{$loop->iteration}.longitude") }}
                        - </small>
                @endif
            </div>
        </div>
    </div>
@endforeach
