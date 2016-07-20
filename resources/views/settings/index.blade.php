@extends('layouts.app', ['pageTitle' => trans('dam.menu.settings')])

@section('content')

    <div class="submenu">
        <div class="container">
            <h2>{{ trans('dam.menu.settings') }}</h2>
        </div>
    </div>

    <main class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.company') }}</h3>
                    <a href="{{ URL::action('SettingsController@company') }}" class="button -go -right -margin-top">{{ trans('dam.general.more-information') }}</a>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.account') }}</h3>
                    <a href="{{ URL::action('SettingsController@account') }}" class="button -go -right -margin-top">{{ trans('dam.general.more-information') }}</a>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.vat.vat_percentages') }}</h3>
                    <a href="{{ URL::action('SettingsController@vat') }}" class="button -go -right -margin-top">{{ trans('dam.general.more-information') }}</a>
                </div>
            </div>
        </div>
    </main>

@stop
