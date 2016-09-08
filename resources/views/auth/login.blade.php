@extends('layouts.app', ['pageTitle' => trans('dam.auth.login') ])

@section('content')
    <main class="container">
        <div class="row -align-hor-center">
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.auth.login') }}</h3>
                    {{ Form::open(['action' => 'Auth\AuthController@login']) }}
                        <div class="field">
                            {{ Form::label('email', trans('dam.auth.emailaddress')) }}
                            {{ Form::email('email', old('email'), ['placeholder' => trans('dam.auth.emailaddress'), 'autofocus'])}}
                        </div>
                        <div class="field">
                            {{ Form::label('password', trans('dam.auth.password')) }}
                            {{ Form::password('password', ['placeholder' => trans('dam.auth.password')])}}
                        </div>
                        <div class="field">
                            {{ Form::checkbox('remember', 1, old('remember') || 1, ['id' => 'remember']) }}
                            {{ Form::label('remember', trans('dam.auth.remember_me'))}}
                        </div>
                        {{ Form::button(trans('dam.auth.login'), ['class' => 'button -go -right', 'type' => 'submit']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </main>
@endsection
