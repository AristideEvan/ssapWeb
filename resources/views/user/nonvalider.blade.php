-@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class=" main-card card">
        <div class="card-header py-0">
            {{-- <a href="{{route('inscription.create')}}">
                <input value="Nouveau" type="button" class="btn btn-primary btnEnregistrer" style="float:right">
            </a> --}}
            <h5>{{ __('Liste des comptes non actif') }}</h5>
        </div>
        <div class="card-body table-responsive">
            <table id="example" class="table table-hover dataTable" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>{{__('Nom & prénoms')}} </th>
                        <th>{{__('Identifiant')}} </th>
                        <th>{{__('Téléphone')}} </th>
                        <th>{{__('E-mail')}} </th>
                        <th>{{__('Etat')}} </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users  as $item  )
                    <tr>
                        <td>{{ $loop->iteration }}</td>
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
                        <td>
                            <a href="#" id="/changerEtatCompte/{{ $item->id }}"
                                onclick="changerEtatCompte(this.id,'')" 
                                @if($item->actif) title="Desactiver cet utilisateur" @else title="Activer cet utilisateur" @endif>
                                @if($item->actif) <i class="fas fa-times" style="color: #F00"></i> @else <i class="fas fa-check-circle" style="color: #060"></i> @endif    
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection