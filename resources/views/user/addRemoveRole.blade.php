@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Mdifier role utilisateur') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="/saveAddRemoveRole/{{$user->id}}">
                            @csrf
                            <div class="form-group row">
                                <label for="identifiant" class="col-md-4 col-form-label text-md-right">{{ __('Identifiant') }}</label>
                                <div class="col-md-6">
                                    <input id="identifiant" type="identifiant" class="form-control formulaire @error('identifiant') is-invalid @enderror" 
                                    name="identifiant" value="{{ $user->identifiant }}" required readonly autocomplete="identifiant" autofocus>
                                    @error('identifiant')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="actif" class="col-md-4 col-form-label text-md-right">{{ __('Activer le compte?') }}</label>
                                <div class="col-md-6">
                                    <label class="switch">
                                        <input name="actif" id="actif" type="checkbox" @if($user->actif) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <fieldset>
                                        <legend>{{ __("Attribuer les menus à cet utilisateur") }}</legend>
                                        <input type="checkbox" id="toutMenu"><label for="toutMenu">Tout cocher</label><br>
                                        @foreach ($menusComplet as $pkey=>$value)
                                            <input type="checkbox" name="menu[]" value="{{ $value[0]->id }}" 
                                                @foreach ($menusUser as $ukey=>$valueUser)
                                                    @if($value[0]->id == $valueUser[0]->id) checked @endif
                                                @endforeach
                                                class="parent" id="m{{ $value[0]->id }}"><label for="m{{ $value[0]->id }}">{{ $value[0]->nomMenu }}</label><br>
                                                @foreach ($value[1] as $skey=>$sousMenu)
                                                    <input type="checkbox" name="menu[]" value="{{ $sousMenu[0]->id }}"
                                                    @foreach ($menusUser as $ukey=>$valueUse)
                                                        @foreach ($valueUse[1] as $sukey=>$sousUserMenu)
                                                            @if($sousMenu[0]->id == $sousUserMenu[0]->id) checked @endif
                                                        @endforeach
                                                    @endforeach
                                                    class="sm fils{{ $value[0]->id }}" id="sm{{ $sousMenu[0]->id }}"><label for="sm{{ $sousMenu[0]->id }}">{{ $sousMenu[0]->nomMenu }}</label><br>
                                                    @foreach ( $sousMenu[1] as $action )
                                                        <input type="checkbox" name="{{ $sousMenu[0]->id }}[]" value="{{ $action->id }}" 
                                                        @foreach ($menusUser as $ukey=>$valueUse)
                                                            @foreach ($valueUse[1] as $sukey=>$sousUserMenu)
                                                                @foreach($sousUserMenu[1] as $userAction)
                                                                    @if($action->id == $userAction) checked @endif
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                        class="ssm fils{{ $sousMenu[0]->id }} pfils{{ $value[0]->id }}" id="a{{ $action->id }}"><label for="a{{ $action->id }}">{{ $action->nomAction }}</label><br>
                                                    @endforeach
                                                @endforeach
                                        @endforeach
                                        <input type="hidden" name="nbmenu" value="0">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="hidden" name="rub" value="{{$rub}}">
                                    <input type="hidden" name="srub" value="{{$srub}}">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('user.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection