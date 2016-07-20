@extends('layouts/app', ['pageTitle' => $project->name])

@section('content')

    @include('project.partials.submenu')

    <main class="container">
        <div class="row -align-hor-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.project.new') }}</h3>
                    {{ Form::model($project, ['action' => ['ProjectController@update', $project->id], 'method' => 'PATCH']) }}
                    @include('project.partials.form', ['buttonText' => trans('dam.general.save')])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </main>

@stop
