@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="card">
    <div class="card-header py-0">
        @php echo $controler->newFormButton($rub,$srub,'profil.create'); @endphp
        <h4>{{ __('Liste des profils') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                {{ csrf_field() }}
                <table id="example" class="table table-striped table-bordered table-hover dataTable" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>{{ __('Profil') }}</th>
                            @php echo $controler->crudheader($rub,$srub); @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profils  as $profil)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $profil->nomProfil }}</td>
                                @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'profil.edit','profil.destroy',$profil->id); @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection