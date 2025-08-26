@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub,$srub,'typeChoc.create'); @endphp
            <h4>{{ __('Liste des typeChoc') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead >
                <tr>
                    <th>{{__('Type de Choc')}} </th>
                    @php echo $controler->crudheader($rub,$srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($typeChocs as $item)
                    <tr>
                        <td>{{ mb_convert_case(mb_strtolower($item->typeChocLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}}   </td>
                        @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'typeChoc.edit','typeChoc.destroy',$item->typeChoc_id); @endphp
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