@extends('layouts.app')

@section('content')

    @include('customer.partials.submenu')

    <main class="container">
        {{ Form::model($customer, ['method' => 'PATCH', 'action' => ['CustomerController@update', $customer->id]])}}
            @include('customer.partials.form', ['buttonText' => trans('dam.general.save'), 'buttonClass' => '-go'])
        {{ Form::close() }}
    </main>

@stop
