@extends('layouts.'.getTemplate($rub,$srub))
@section('content')
    <div class="container-fluid">
        <div class="main-card card">
            <div class="card-header py-0">
                @php echo $controler->newFormButton($rub,$srub,'partenaire.create'); @endphp
                <h4 class="card-title">
                    {{__('Liste des partenaires')}}
                </h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>{{__('Nom du partenaire')}}</th>
                            <th>{{__('Sigle du partenaire')}}</th>
                            <th>{{__('Type de partenaire')}}</th>
                            <th>{{__('Nom du répondant')}}</th>
                            <th>{{__('Prénom du répondant')}}</th>
                            <th>{{__('Téléphone du répondant')}}</th>
                            <th>{{__('Email du répondant')}}</th>
                            @php echo $controler->crudheader($rub,$srub); @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listePartenaires as $partenaire)
                            <tr>
                                <td>  {{ mb_convert_case(mb_strtolower($partenaire->nomPartenaire, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}  </td>
                                <td>{{ $partenaire->sigle }}</td>
                                <td> {{ mb_convert_case(mb_strtolower($partenaire->typePartenaire ? $partenaire->typePartenaire->typePartenaireLibelle : 'Non spécifié', 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}  </td>
                                <td>  {{ mb_convert_case(mb_strtolower($partenaire->nomRepondant ?? 'Non précisé', 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}} </td>
                                <td> {{ mb_convert_case(mb_strtolower($partenaire->prenomRepondant ?? 'Non précisé' ?? 'Non précisé', 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}} </td>
                                <td>{{ $partenaire->telephoneRepondant ?? 'Non précisé' }}</td>
                                <td>{{ $partenaire->emailRepondant ?? 'Non précisé' }}</td>
                                @php 
                                    $route = 'route'; 
                                    echo $controler->crudbody($rub,$srub,$route,'partenaire.edit','partenaire.destroy',$partenaire->partenaire_id); 
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
