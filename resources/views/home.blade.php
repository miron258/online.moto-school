@extends('layouts.app')

@section('content')
    <div id="app" class="container-fluid">
        <div class="row-fluid justify-content-center">
            <div class="col-xl-12">
            <div class="card">
                <div class="card-header">{{ __('Статистика') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif




                </div>
            </div>
        </div>
    </div>
</div>
@endsection
