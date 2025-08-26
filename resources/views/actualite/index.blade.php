@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub, $srub, 'actualite.create'); @endphp
            <h4>{{ __('Liste des actualités') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead >
                <tr>
                    <th>{{__('Titre')}} </th>
                    <th>{{__('Publique')}} </th>
                    @php
                        echo $controler->crudheader($rub, $srub); 
                    @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($actualites as $item)
                    <tr>
                        <td>{{ __($item->titre) }}</td>
                        <td><span class="badge badge-{{ $item->publique ? 'success' : 'secondary' }}">{{ $item->publique ? 'Oui' : 'Non' }}</span></td>
                        @php $route = 'route'; echo $controler->crudbody($rub, $srub, $route,'actualite.edit','actualite.destroy',$item->id); @endphp
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