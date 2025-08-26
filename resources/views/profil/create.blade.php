@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter un profil') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('profil.store') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="profil">Libellé profil </label>
                                        <input type="text" required class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="profil" id="profil"
                                            placeholder="Libellé du profil">
                                    </div>
                                    <fieldset>
                                        <legend>{{ __("Attribuer les menus à ce profil") }}</legend>
                                        <input type="checkbox" id="toutMenu"><label for="toutMenu">Tout cocher</label><br>
                                        @foreach ($menus as $pkey=>$value)
                                            <input type="checkbox" name="menu[]" value="{{ $value[0]->id }}" 
                                            class="parent" id="m{{ $value[0]->id }}"><label for="m{{ $value[0]->id }}">{{ $value[0]->nomMenu }}</label><br>
                                            @if(array_key_exists(1,$value))
                                            @foreach ($value[1] as $skey=>$sousMenu)
                                                <input type="checkbox" name="menu[]" value="{{ $sousMenu[0]->id }}"
                                                 class="sm fils{{ $value[0]->id }}" id="sm{{ $sousMenu[0]->id }}"><label for="sm{{ $sousMenu[0]->id }}">{{ $sousMenu[0]->nomMenu }}</label><br>
                                                @if(array_key_exists(1,$sousMenu))
                                                 @foreach ( $sousMenu[1] as $action )
                                                    <input type="checkbox" name="{{ $sousMenu[0]->id }}[]" value="{{ $action->id }}" class="ssm fils{{ $sousMenu[0]->id }} pfils{{ $value[0]->id }}" id="a{{ $action->id }}"><label for="a{{ $action->id }}">{{ $action->nomAction }}</label><br>
                                                @endforeach
                                                @endif
                                            @endforeach
                                            @endif
                                        @endforeach
                                        <input type="hidden" name="nbmenu" value="0">
                                        <input type="hidden" name="rub" value=" {{$rub}} ">
                                        <input type="hidden" name="srub" value=" {{$srub}} ">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('profil.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection