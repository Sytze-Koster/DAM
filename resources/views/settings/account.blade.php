@extends('layouts.app', ['pageTitle' => trans('dam.settings.account')])

@section('content')

    <div class="submenu">
        <div class="container">
            <h2>{{ trans('dam.settings.account') }}</h2>
        </div>
    </div>

    <main class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.change_username') }}</h3>
                    {{ Form::model($user, ['action' => 'SettingsController@accountUpdate']) }}
                    <div class="field">
                        {{ Form::label('email', trans('dam.settings.change_username')) }}
                        {{ Form::email('email', old('email'), ['placeholder' => trans('dam.settings.change_username')])}}
                    </div>
                    <div class="-align-right">
                        {{ Form::hidden('change_username', 1) }}
                        {{ Form::button(trans('dam.general.save'), ['class' => 'button -go', 'type' => 'submit']) }}
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="card">
                    <h3>{{ trans('dam.settings.change_password') }}</h3>
                    {{ Form::model($user, ['action' => 'SettingsController@accountUpdate']) }}
                    <div class="field">
                        {{ Form::label('password', trans('dam.settings.current_password')) }}
                        {{ Form::password('password', ['placeholder' => trans('dam.settings.current_password')])}}
                    </div>
                    <hr />
                    <div class="field">
                        {{ Form::label('new_password', trans('dam.settings.new_password')) }}
                        {{ Form::password('new_password', ['placeholder' => trans('dam.settings.new_password')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('new_password_confirmation', trans('dam.settings.new_password_confirmation')) }}
                        {{ Form::password('new_password_confirmation', ['placeholder' => trans('dam.settings.new_password_confirmation')])}}
                    </div>
                    <div class="-align-right">
                        {{ Form::hidden('change_password', 1) }}
                        {{ Form::button(trans('dam.general.save'), ['class' => 'button -go', 'type' => 'submit']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.two_factor_authentication.two_factor_authentication') }}</h3>
                    @if($user->gauth_token)
                        <p>{{ trans('dam.settings.two_factor_authentication.on') }}</p>
                        <div class="-align-right">
                            <a href="{{ URL::action('SettingsController@toggleTwoFactorAuthentication') }}" class="button -go">{{ trans('dam.settings.two_factor_authentication.turn_off') }}</a>
                        </div>
                    @else
                        <p>{{ trans('dam.settings.two_factor_authentication.off') }}</p>
                        <div class="-align-right">
                            <a href="{{ URL::action('SettingsController@toggleTwoFactorAuthentication') }}" class="button -go">{{ trans('dam.settings.two_factor_authentication.turn_on') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

@stop
