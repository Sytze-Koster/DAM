@extends('layouts.app', ['pageTitle' => trans('dam.customer.customers') ])

@section('content')

    @include('customer.partials.submenu')

    <main class="container">
        <div class="row">
            @foreach($customers as $customer)
                <div class="col-6">
                    <div class="card">
                        <h3>{{ $customer->customerDetail->name }}</h3>
                        <a href="{{ URL::action('CustomerController@show', $customer->id)}}" class="button -go -right -margin-top">{{ trans('dam.general.more-information') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

@stop
