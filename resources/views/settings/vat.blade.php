@extends('layouts.app', ['pageTitle' => trans('dam.settings.vat.vat_percentages')])

@section('content')

    <div class="submenu">
        <div class="container">
            <h2>{{ trans('dam.settings.vat.vat_percentages') }}</h2>
        </div>
    </div>

    <main class="container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.vat.vat_percentages') }}</h3>
                    <ul class="list -striped">
                        @foreach($vat_percentages as $percentage)
                        <li class="list-item">
                            <div class="row -align-vert-center">
                                <div class="col-6">
                                    {{ $percentage->percentage }}%
                                </div>
                                <div class="col-6 -align-right">
                                    {{ Form::open(['action' => ['SettingsController@vatDestroy', $percentage->id], 'method' => 'DELETE'])}}
                                        {{ Form::button(trans('dam.general.destroy'), ['class' => 'button', 'type' => 'submit']) }}
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    {{ Form::open(['action' => 'SettingsController@vatStore']) }}
                        <div class="field">
                            {{ Form::label('percentage', trans('dam.settings.vat.add')) }}
                            {{ Form::text('percentage', old('percentage'), ['placeholder' => trans('dam.settings.vat.add')])}}
                        </div>
                        <div class="-align-right">
                            {{ Form::button(trans('dam.general.add'), ['class' => 'button -go', 'type' => 'submit']) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </main>

@stop
