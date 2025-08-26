@extends('layouts.'.getTemplate($rub,$srub))
@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            
            @php echo $controler->newFormButton($rub,$srub,'user.create'); @endphp
            <h5 class="card-title">
                {{__('Liste des utilisateurs')}}
            </h5>
        </div>
        <div class="card-body table-responsive">
            
            <table class="table table-hover dataTable">
                <thead >
                    <tr>
                        <th>{{__('Nom & prénoms')}} </th>
                        <th>{{__('Identifiant')}} </th>
                        <th>{{__('Téléphone')}} </th>
                        <th>{{__('E-mail')}} </th>
                        <th>{{__('Etat')}} </th>
                        <th>{{__('Profil')}} </th>
                        <th></th>
                        @if($tabParam[0])<th></th>@endif
                        @if($tabParam[1])<th></th>@endif
                        @php echo $controler->crudheader($rub,$srub); @endphp
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $item)
                        <tr>
                            <td>{{$item->nom}} {{$item->prenom}}</td>
                            <td>{{$item->identifiant}}</td>
                            <td>{{$item->telephone}}</td>
                            <td>{{$item->email}}</td>
                            <td>@if($item->actif)
                                <span class="styleedit">Actif</span>
                                @else 
                                <span class="styledelete">Inactif</span>
                                @endif
                            </td>
                            <td>{{$item->profil?->nomProfil}}</td>
                            <td>
                                <a href="#" id="/changerEtatCompte/{{ $item->id }}"
                                    onclick="changerEtatCompte(this.id,'')" 
                                    @if($item->actif) title="Desactiver cet utilisateur" @else title="Activer cet utilisateur" @endif>
                                    @if($item->actif) <i class="fas fa-times" style="color: #F00"></i> @else <i class="fas fa-check-circle" style="color: #060"></i> @endif    
                                </a>
                            </td>
                            @if($tabParam[0])<td>
                                <a href="/addRemoveRole/{{$item->id}}/{{$rub}}/{{$srub}}" title="Ajouter ou retirer des droits">
                                    <i class="fa fa-plus" style="color: #060"></i>/<i class="fa fa-minus styledelete"></i>
                                </a>
                            </td>@endif
                            
                            @if($tabParam[1])<td>
                                <a href="/editPass/{{$item->id}}/{{$rub}}/{{$srub}}" title="Modifier le mot de passe">
                                    <i class="fa fa-key" style="color: #060"></i>
                                </a>
                            </td>@endif
                            @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'user.edit','user.destroy',$item->id); @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    {{-- <a href="/exportExcelCause" >
        <button class="btn btn-primary btnEnregistrer">{{ __('liste.exporter') }}</button>
    </a> --}}
</div>
@endsection
