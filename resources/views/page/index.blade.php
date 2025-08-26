@extends('layouts.' . getTemplate($rub, $srub))

@section('content')
    <div class="container-fluid">
        <div class="main-card card">
            <div class="card-header py-0">

                @php
                    if (!$page) {
                        echo $controler->newFormButton($rub, $srub, 'page.create');
                    }
                @endphp
                <h4>{{ __('Paramétrages des pages') }}</h4>
            </div>
            <div class="card-body table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('Paramètres') }}</td>
                            @isset($page)
                                @php
                                    $route = 'route';
                                    echo $controler->crudbody($rub, $srub, $route, 'page.edit', 'page.destroy', $page->id);
                                @endphp
                            @endisset
                        </tr>
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
