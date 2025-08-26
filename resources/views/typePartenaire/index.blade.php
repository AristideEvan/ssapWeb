@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'typePartenaire.create'); @endphp
            <h4>{{ __('Liste des types de Partenaires') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead >
                <tr>
                    <th>{{__('Type de Partenaire')}} </th>
                    @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($typePartenaires as $item)
                    <tr>
                        <td> {{ mb_convert_case(mb_strtolower($item->typePartenaireLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}} </td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'typePartenaire.edit','typePartenaire.destroy',$item->typePartenaire_id); @endphp
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