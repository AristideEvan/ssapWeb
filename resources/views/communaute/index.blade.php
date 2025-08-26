@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">

            @php 
              echo $controler->newFormButton($rub, $srub,'communaute.create'); 
            @endphp
            <h4>{{ __('Communautés') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead >
                <tr>
                    <th>{{__('Titre')}} </th>
                    @php
                        echo $controler->crudheader($rub, $srub); 
                    @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($communautes as $item)
                    <tr>
                        <td>{{ __($item->titre) }}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub, $srub, $route,'communaute.edit','communaute.destroy',$item->id); @endphp
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