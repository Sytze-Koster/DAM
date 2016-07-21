@extends('layouts.app', ['pageTitle' => $project->name])

@section('content')

    @include('project.partials.submenu')

    <main class="container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ trans('dam.timesheet.add') }}</h3>
                    {{ Form::open(['url' => URL::action('TimesheetController@store', $project->id), 'method' => 'POST']) }}
                        <div class="field">
                            {{ Form::label('description', trans('dam.timesheet.description'))}}
                            {{ Form::textarea('description', old('description'), ['size' => '0x0', 'placeholder' => trans('dam.timesheet.description')]) }}
                        </div>
                        <div class="field">
                            <div class="row">
                                <div class="col-6">
                                    {{ Form::label('start_date', trans('dam.timesheet.start.date'))}}
                                    {{ Form::text('start_date', (old('start_date') ? old('start_date') : date('d-m-Y')), ['placeholder' => trans('dam.timesheet.start.date'), 'class' => 'date start-date']) }}
                                </div>
                                <div class="col-6">
                                    {{ Form::label('start_time', trans('dam.timesheet.start.time'))}}
                                    {{ Form::text('start_time', (old('start_time') ? old('start_time') : date('H:i')), ['placeholder' => trans('dam.timesheet.start.time'), 'class' => 'time']) }}
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row">
                                <div class="col-6">
                                    {{ Form::label('end_date', trans('dam.timesheet.end.date'))}}
                                    {{ Form::text('end_date', (old('end_date') ? old('end_date') : date('d-m-Y')), ['placeholder' => trans('dam.timesheet.end.date'), 'class' => 'date end-date']) }}
                                </div>
                                <div class="col-6">
                                    {{ Form::label('end_time', trans('dam.timesheet.end.time'))}}
                                    {{ Form::text('end_time', (old('end_time') ? old('end_time') : date('H:i')), ['placeholder' => trans('dam.timesheet.end.time'), 'class' => 'time']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::button(trans('dam.general.add'), ['class' => 'button -add -right', 'type' => 'submit']) }}
                    {{ Form::close() }}
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
