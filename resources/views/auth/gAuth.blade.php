@extends('layouts.app', ['pageTitle' => trans('dam.auth.two_factorauthentication') ])

@section('content')
    <main class="container">
        <div class="row -align-hor-center">
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.auth.two_factorauthentication') }}</h3>
                    {{ Form::open(['action' => 'Auth\AuthController@gAuthenticate']) }}
                        <div class="field">
                            {{ Form::label('gAuth', trans('dam.auth.response_code')) }}
                            {{ Form::text('gAuth', null, ['placeholder' => trans('dam.auth.response_code'), 'autofocus'])}}
                        </div>
                        {{ Form::button(trans('dam.auth.authenticate'), ['class' => 'button -go -right', 'type' => 'submit']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </main>
@endsection
