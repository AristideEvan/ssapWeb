@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub, $srub, 'localite.create'); @endphp
            <h4>{{ __('Liste des localités') }}</h4>
        </div>
        <div class="card-body table-responsive">
            <table id="example" class="table table-striped table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th>{{ __('Type de localité') }}</th>
                        <th>{{ __('Libellé de la localité') }}</th>
                        <th>{{ __('Code Alpha-2') }}</th>
                        <th>{{ __('Code Alpha-3') }}</th>
                        <th>{{ __('Code numérique') }}</th>
                        <th>{{ __('Parent') }}</th> <!-- Nouvelle colonne pour le Parent -->
                        @php echo $controler->crudheader($rub, $srub); @endphp
                    </tr>
                </thead>
                <tbody>
                    @foreach($localites as $item)
                        <tr>
                            <td>{{ $item->typeLocalite->typeLocaliteLibelle ?? '-' }}</td>
                            <td>{{ $item->nomLocalite }}</td>
                            <td>{{ $item->codeAlpha2 ?? '-' }}</td>
                            <td>{{ $item->codeAlpha3 ?? '-' }}</td>
                            <td>{{ $item->codeNum ?? '-' }}</td>
                            <td>{{ $item->parent_id->nomLocalite ?? '-' }}</td> <!-- Affichage du Parent -->
                            @php 
                                $route = 'route'; 
                                echo $controler->crudbody($rub,$srub,$route,'localite.edit','localite.destroy',$item->localite_id);  
                            @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    {{-- <a href="/exportExcelLocalite">
        <button class="btn btn-primary btnEnregistrer">{{ __('liste.exporter') }}</button>
    </a> --}}
</div>
@endsection
