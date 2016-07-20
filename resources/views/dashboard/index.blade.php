@extends('layouts.app', ['pageTitle' => trans('dam.dashboard.dashboard') ])

@section('content')

    @include('dashboard.partials.submenu')

    <main class="container">
        <div class="row">
            <div class="col-6">
                @if(count($projects))
                    <div class="card">
                        <h3>{{ trans('dam.timesheet.timesheet') }}</h3>
                        {{ Form::open(['action' => 'TimesheetController@startTime',
                                       'method' => 'POST']) }}
                            <div class="field">
                                {{ Form::select('project_id', $projects) }}
                            </div>
                            {{ Form::button(trans('dam.timesheet.start_timer'), ['class' => 'button -go -right', 'type' => 'submit']) }}
                        {{ Form::close() }}
                    </div>
                @endif
                @if(count($invoices))
                    <div class="card">
                        <h3>{{ trans('dam.invoice.unpaid')}}</h3>
                        <div class="list -striped">
                            @foreach($invoices as $invoice)
                            <div class="list-item">
                                <div class="row -no-gutter-vert">
                                    <div class="col-8">
                                        <div class="key">{{ $invoice->customer->customerDetail->name }}</div>
                                        <div class="value">{{ $invoice->due_date->format('d-m-Y') }}</div>
                                    </div>
                                    <div class="col-4">
                                        <a href="{{ URL::action('InvoiceController@show', $invoice->id)}}" class="button -go -right">{{ trans('dam.general.more-information') }}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-6">
                @foreach($inProgress as $timesheet)
                <div class="card -flippable">
                    <div class="front">
                        <h3>{{ trans('dam.timesheet.currently_working_on') }}: {{$timesheet->project->name}}</h3>
                        <p class="timer" data-start="{{ $timesheet->start->format('Y/m/d H:i:s') }}">00:00:00</p>
                        <span class="button -secondary -go -center stop-timer flip" data-timesheet-id="{{ $timesheet->id }}">Stop timer</span>
                    </div>
                    <div class="back">
                        <h3>{{ trans('dam.timesheet.add') }}: {{$timesheet->project->name}}</h3>
                        {{ Form::open(['url' => URL::action('TimesheetController@endTime', $timesheet->id), 'method' => 'POST', 'id' => 'timesheet-'.$timesheet->id]) }}
                            <div class="field">
                                {{ Form::label('description', trans('dam.timesheet.description'))}}
                                {{ Form::textarea('description', old('description'), ['size' => '0x0', 'placeholder' => trans('dam.timesheet.description')]) }}
                            </div>
                            <div class="field">
                                <div class="row">
                                    <div class="col-6">
                                        {{ Form::label('start_date', trans('dam.timesheet.start.date'))}}
                                        {{ Form::text('start_date', (old('start_date') ? old('start_date') : $timesheet->start->format('d-m-Y')), ['placeholder' => trans('dam.timesheet.start.date'), 'class' => 'date start-date']) }}
                                    </div>
                                    <div class="col-6">
                                        {{ Form::label('start_time', trans('dam.timesheet.start.time'))}}
                                        {{ Form::text('start_time', (old('start_time') ? old('start_time') : $timesheet->start->format('H:i')), ['placeholder' => trans('dam.timesheet.start.time'), 'class' => 'time']) }}
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
                            {{ Form::button(trans('dam.timesheet.add'), ['class' => 'button -add -right', 'type' => 'submit']) }}
                        {{ Form::close() }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>


@stop
