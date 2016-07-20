@extends('layouts.app', ['pageTitle' => trans('dam.settings.account')])

@section('content')

    <div class="submenu">
        <div class="container">
            <h2>{{ trans('dam.settings.account') }}</h2>
        </div>
    </div>

    <main class="container">
        <div class="row -align-hor-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.two_factor_authentication.two_factor_authentication') }}</h3>
                    <ol>
                        <li>{!! trans('dam.settings.two_factor_authentication.steps.1') !!}</li>
                        <li>{{ trans('dam.settings.two_factor_authentication.steps.2')}}</li>
                    </ol>
                    <br />
                    <center><img src="{{ $google2fa_url }}" alt="QR-code" width="50%" height="50%"></center>

                    <div class="-align-right">
                        <a href="{{ URL::action('SettingsController@account') }}" class="button -go">{{ trans('dam.general.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

@stop
