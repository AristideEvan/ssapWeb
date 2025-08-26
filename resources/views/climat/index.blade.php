@extends('layouts.'.getTemplate($rub, $srub))

@section('content')
    <div class="container-fluid">
        <div class="main-card card">
            <div class="card-header py-0">
                @php echo $controler->newFormButton($rub, $srub, 'climat.create'); @endphp
                <h4 class="card-title">
                    {{__('Liste des climats')}}
                </h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>{{ __('Libellé du climat') }}</th>
                            <th>{{ __('Description') }}</th>
                            @php echo $controler->crudheader($rub, $srub); @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listeClimats as $climat)
                            <tr>
                                <td>{{ mb_convert_case(mb_strtolower($climat->libelleClimat, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}} </td>
                                <td>{{ mb_strtolower($climat->description ,'UTF-8')}}</td>
                                @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'climat.edit','climat.destroy',$climat->climat_id); @endphp

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
