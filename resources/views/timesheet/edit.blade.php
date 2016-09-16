@extends('layouts/app', ['pageTitle' => trans('dam.timesheet.edit')])

@section('content')

    <div class="submenu">
        <div class="container">
            <h2>{{ trans('dam.timesheet.edit') }}</h2>
            <ul class="menu">
                <li><a href="{{ URL::action('TimesheetController@index', $timesheet->project->id) }}">{{ $timesheet->project->name }}</a></li>
            </ul>
        </div>
    </div>

    <div id="destroy" class="overlay">
        <div class="popup card">
            <h3>{{ trans('dam.timesheet.destroy') }}</h3>
            <a class="close" href="#" data-turbolinks="false">&times;</a>
            <div class="content">
                {{ trans('dam.timesheet.destroy_confirm') }}

                {{ Form::open(['action' => ['TimesheetController@destroy', $timesheet->id], 'method' => 'DELETE']) }}
                    <div class="-align-right">
                        {{ Form::button(trans('dam.timesheet.destroy'), ['type' => 'submit', 'class' => 'button -go']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <main class="container">
        <div class="row -align-hor-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.timesheet.edit') }}</h3>
                    {{ Form::model($timesheet, ['action' => ['TimesheetController@update', $timesheet->id], 'method' => 'PATCH']) }}
                        <div class="field">
                            {{ Form::label('project_id', trans('dam.project.project')) }}
                            {{ Form::select('project_id', $projects) }}
                        </div>

                        <div class="field">
                            {{ Form::label('description', trans('dam.timesheet.description'))}}
                            {{ Form::textarea('description', old('description'), ['size' => '0x0', 'placeholder' => trans('dam.timesheet.description')]) }}
                        </div>

                        <div class="field">
                            {{ Form::label('start_date', trans('dam.timesheet.start.date'))}}
                            {{ Form::text('start_date', (old('start_date') ? old('start_date') : $timesheet->start->format('d-m-Y')), ['placeholder' => trans('dam.timesheet.start.date'), 'class' => 'date start-date']) }}
                        </div>

                        <div class="field">
                            {{ Form::label('start_time', trans('dam.timesheet.start.time'))}}
                            {{ Form::text('start_time', (old('start_time') ? old('start_time') : $timesheet->start->format('H:i')), ['placeholder' => trans('dam.timesheet.start.time'), 'class' => 'time']) }}
                        </div>

                        <div class="field">
                            {{ Form::label('end_date', trans('dam.timesheet.end.date'))}}
                            {{ Form::text('end_date', (old('end_date') ? old('end_date') : $timesheet->end->format('d-m-Y')), ['placeholder' => trans('dam.timesheet.end.date'), 'class' => 'date end-date']) }}
                        </div>

                        <div class="field">
                            {{ Form::label('end_time', trans('dam.timesheet.end.time'))}}
                            {{ Form::text('end_time', (old('end_time') ? old('end_time') : $timesheet->end->format('H:i')), ['placeholder' => trans('dam.timesheet.end.time'), 'class' => 'time']) }}
                        </div>

                        <a href="#destroy" class="button -delete" data-turbolinks="false">{{ trans('dam.timesheet.destroy') }}</a>
                        {{ Form::button(trans('dam.timesheet.save'), ['class' => 'button -add -right', 'type' => 'submit']) }}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </main>

@stop
