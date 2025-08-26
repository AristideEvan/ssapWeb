@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter un profil') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('profil.update',$profil->id) }}">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="form-group">
                                        <label for="profil">Libellé profil </label>
                                        <input type="text" required class="form-control" value="{{$profil->nomProfil}}" name="profil" id="profil"
                                            placeholder="Libellé du profil">
                                    </div>
                                    
                                    <fieldset>
                                        <legend>{{ __("Attribuer les menus à ce profil") }}</legend>
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