@extends('layouts.app')

@section('content')

    @include('customer.partials.submenu')

    <main class="container">
        {{ Form::open(['method' => 'POST', 'action' => 'CustomerController@store'])}}
            @include('customer.partials.form', ['buttonText' => trans('dam.general.save'), 'buttonClass' => '-go'])
        {{ Form::close() }}
    </main>

@stop
