@extends('layouts.app', ['pageTitle' => trans('dam.project.projects') ])

@section('content')

    @include('project.partials.submenu')

    <main class="container">
        <div class="row">
            @foreach($projects as $project)
                <div class="col-6">
                    <div class="card">
                        <h3>{{ $project->name }}</h3>
                        <p>{{ $project->description}}</p>
                        <a href="{{ URL::action('ProjectController@show', $project->id)}}" class="button -go -right -margin-top">{{ trans('dam.general.more-information') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

@stop
