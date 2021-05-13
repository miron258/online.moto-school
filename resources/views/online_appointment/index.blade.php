@extends('layouts.app')
@section('title', 'Список записей')
@section('content')
    <div class="container-fluid">
        <div class="row-fluid justify-content-center">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <router-view :bikes='@json($bikes)'></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
