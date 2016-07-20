@extends('layouts/app', ['pageTitle' => trans('dam.project.projects')])

@section('content')

    @include('project.partials.submenu')

    <main class="container">
        <div class="row -align-hor-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.project.new') }}</h3>
                    {{ Form::open(['action' => 'ProjectController@store', 'method' => 'POST']) }}
                    @include('project.partials.form', ['buttonText' => trans('dam.general.add')])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </main>

@stop
