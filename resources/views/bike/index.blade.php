@extends('layouts.app')
@section('title', 'Список мотоциклов')
@section('content')
<div class="container-fluid">
    <modal-bike ref="modalBike"></modal-bike>
    <div class="row-fluid justify-content-center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">@yield('title')</div>


                <div class="col-12 ml-1 mt-2">
                    <a @click.prevent="$refs.modalBike.show()" class="btn btn-primary btn-sm" href=""><i class="far fa-plus-square mr-2"></i>Создать мотоцикл</a>
                </div>




                <div class="card-body">

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                  <bike-table></bike-table>


                </div>





            </div>
        </div>
    </div>
</div>
@endsection
