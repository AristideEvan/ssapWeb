@foreach ($zones as $zone)
    @php
        $parent = DB::table('localites')
            ->where('localite_id', $zone['pays'])
            ->first();
        $enfants = DB::select('SELECT "localite_id", "nomLocalite" FROM "listeLocalite" WHERE "p0" = ?', [
            $parent->localite_id,
        ]);
    @endphp
    <div class="zonep-container">
        <div class="row">
            <div class="col-12 col-md-6">
                <label for="paysp{{ $loop->iteration }}">{{ __('Pays') }}</label>
                <span title="{{ __('Supprimer') }}" class="fa fa-trash text-danger float-right d-md-none removeZone"
                    style="cursor: pointer;"></span>

                <select name="zonesp[{{ $loop->iteration }}][pays]" id="pays{{ $loop->iteration }}"
                    class="form-control paysp js-example-basic-single">
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
                <label for="localitep{{ $loop->iteration }}">{{ __('Localité') }}</label>
                <span title="{{ __('Supprimer') }}"
                    class="fa fa-trash text-danger float-right d-none d-md-inline removeZonep"
                    style="cursor: pointer;"></span>
                <select name="zonesp[{{ $loop->iteration }}][localite]" id="localitep{{ $loop->iteration }}"
                    class="localitep js-example-basic-single">
                    @foreach ($enfants as $enfant)
                        <option value="{{ $enfant->localite_id }}"
                            {{ $enfant->localite_id == $zone['localite'] ? 'selected' : '' }}>
                            {{ $enfant->nomLocalite }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endforeach
