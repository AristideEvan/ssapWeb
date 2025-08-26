
@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub, $srub, 'beneficiaire.create'); @endphp
            <h4>{{ __('Liste des bénéficiaires') }}</h4>
        </div>
        <div class="card-body table-responsive">
            <table id="example" class="table table-striped table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th>{{ __('Type de bénéficiaire') }}</th>
                        <th>{{ __('Libellé du bénéficiaire') }}</th>
                        @php echo $controler->crudheader($rub, $srub); @endphp
                    </tr>
                </thead>
                <tbody>
                    @foreach($beneficiaires as $item)
                        <tr>
                            <td> {{ mb_convert_case(mb_strtolower($item->typeBeneficiaire->typeBeneficiaireLibelle ?? '-' , 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}} </td>
                            <td>{{ mb_convert_case(mb_strtolower($item->beneficiaireLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}} </td>
                            @php 
                                $route = 'route'; 
                                echo $controler->crudbody($rub, $srub, $route, 'beneficiaire.edit', 'beneficiaire.destroy', $item->beneficiaire_id); 
                            @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    {{-- <a href="/exportExcelBeneficiaire">
        <button class="btn btn-primary btnEnregistrer">{{ __('liste.exporter') }}</button>
    </a> --}}
</div>
@endsection
