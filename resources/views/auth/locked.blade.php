@extends('layouts.app', ['pageTitle' => trans('dam.auth.locked') ])

@section('content')
    <main class="container">
        <div class="row -align-hor-center">
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.auth.locked') }}</h3>
                    <p>{{ trans('dam.auth.locked_explained') }} <a href="{{ URL::action('Auth\AuthController@logout') }}">{{ trans('dam.auth.logout') }} &raquo;</a></p>
                    {{ Form::open(['action' => 'Auth\AuthController@unlock']) }}
                        <div class="field">
                            {{ Form::email('email', Auth::User()->email, ['placeholder' => trans('dam.auth.emailaddress'), 'disabled' => 'disabled'])}}
                        </div>
                        <div class="field">
                            {{ Form::label('password', trans('dam.auth.password')) }}
                            {{ Form::password('password', ['placeholder' => trans('dam.auth.password'), 'autofocus'])}}
                        </div>
                        {{ Form::button(trans('dam.auth.unlock'), ['class' => 'button -go -right', 'type' => 'submit']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </main>
@endsection
