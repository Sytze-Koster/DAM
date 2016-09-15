@extends('layouts.app', ['pageTitle' => $project->name])

@section('content')

    @include('project.partials.submenu')

    <div id="archive" class="overlay">
        <div class="popup card">
            <h3>{{ trans('dam.project.archive') }}</h3>
            <a class="close" href="#" data-turbolinks="false">&times;</a>
            <div class="content">
                {{ trans('dam.project.archive_confirm') }}

                {{ Form::open(['action' => ['ProjectController@archive', $project->id]]) }}
                    <div class="-align-right">
                        {{ Form::button(trans('dam.project.archive'), ['type' => 'submit', 'class' => 'button -go']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div id="destroy" class="overlay">
        <div class="popup card">
            <h3>{{ trans('dam.project.destroy') }}</h3>
            <a class="close" href="#" data-turbolinks="false">&times;</a>
            <div class="content">
                {{ trans('dam.project.destroy_confirm') }}

                {{ Form::open(['action' => ['ProjectController@destroy', $project->id], 'method' => 'DELETE']) }}
                    <div class="-align-right">
                        {{ Form::button(trans('dam.project.destroy'), ['type' => 'submit', 'class' => 'button -go']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <main class="container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ $project->name }}</h3>
                    <p>{{ $project->description }}</p>
                    <hr />
                    <h3>{{ trans('dam.project.shareability.shareable_link') }}</h3>
                    @if($project->share_id)
                        <div class="field">
                            <input type="text" value="{{ URL::action('TimesheetController@showForCustomer', $project->share_id) }}">
                        </div>
                        <a href="{{ URL::action('ProjectController@toggleShareability', $project->id) }}" class="button" data-turbolinks="false">{{ trans('dam.project.shareability.disable') }}</a>
                    @else
                        <a href="{{ URL::action('ProjectController@toggleShareability', $project->id) }}" class="button" data-turbolinks="false">{{ trans('dam.project.shareability.enable') }}</a>
                    @endif
                </div>

                <div class="card">
                    <h3>Klant</h3>
                    <div class="list -striped">
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.company_name')}}</span>
                            <span class="value">{{ $customer->customerDetail->name }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.address')}}</span>
                            <span class="value">{{ $customer->customerDetail->address }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.postal_code')}} & {{ trans('dam.customer.city') }}</span>
                            <span class="value">{{ $customer->customerDetail->postal_code }} {{ $customer->customerDetail->city }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.email_address')}}</span>
                            <span class="value">{{ $customer->customerDetail->email_address }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.phone_number')}}</span>
                            <span class="value">{{ $customer->customerDetail->phone_number }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>Statistieken</h3>
                    <canvas id="stats"></canvas>
                </div>

                @if(count($invoices))
                <div class="card">
                    <h3>{{ trans('dam.invoice.invoices') }}</h3>
                    <div class="list -striped">
                        @foreach($invoices as $invoice)
                        <div class="list-item">
                            <div class="row -align-vert-center -no-gutter">
                                <div class="col-6">
                                    <p class="key">{{ $invoice->invoice_number }}</p>
                                    <p class="value">{{ $invoice->invoice_date->format('d-m-Y') }}</p>
                                </div>
                                <div class="col-6">
                                    <a href="{{ URL::action('InvoiceController@show', $invoice->id)}}" class="button -go -right -margin-top">{{ trans('dam.general.more-information') }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>
@stop

@section('scripts')
    <script>
        var ctx = $("#stats");
        setTimeout(function() {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['{!! implode("', '", array_keys($stats)) !!}'],
                    datasets: [{
                        label: '{{ trans('dam.project.worked_hours') }}',
                        data: [{!! implode(', ', $stats) !!}],
                        backgroundColor: '#fb86a4',
                        borderColor: '#ff2e63',
                        borderWidth: 2
                    }]
                },
                options: {
                    //responsiveAnimationDuration: 1,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                suggestedMax:40
                            }
                        }]
                    }
                }
            });
        }, 1)
    </script>
@stop
