@extends('layouts.app', ['pageTitle' => $project->name])

@section('content')

    <div class="submenu">
        <div class="container">
            <h2>{{ $project->name }}</h2>
        </div>
    </div>


    <main class="container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ $project->name }}</h3>
                    <p>{{ $project->description }}</p>
                </div>
            </div>

            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ trans('dam.general.overview') }}</h3>
                    <div class="list">
                        @foreach($project->timesheets as $timesheet)
                            <div class="list-item">
                                {{ $timesheet->description }}
                                <div class="footer">
                                    <div class="row -no-gutter">
                                        <div class="col">{{ $timesheet->start->format('d-m-Y H:i') }}</div>
                                        <div class="col">{{ ($timesheet->in_progress ? trans('dam.timesheet.ongoing') : $timesheet->end->format('d-m-Y H:i')) }}</div>
                                        <div class="col -align-right"><strong>{{ ($timesheet->in_progress ? '' : $timesheet->timeSpent(true)) }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="list-item">
                            <div class="row">
                                <div class="col">{{ trans('dam.timesheet.total') }}</div>
                                <div class="col -align-right"><strong>{{ $project->timeSpent(true) }}</strong></div>
                        </div>
                    </div>
                </div>
        </div>
    </main>
@stop
