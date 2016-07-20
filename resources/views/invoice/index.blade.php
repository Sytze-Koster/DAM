@extends('layouts.app', ['pageTitle' => trans('dam.invoice.invoices')])

@section('content')

    @include('invoice.partials.submenu')

    <main class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.general.overview') }}</h3>
                    <canvas id="stats"></canvas>
                </div>

                @if(count($owedInvoices))
                    <div class="card">
                        <h3>{{ trans('dam.invoice.incoming.unpaid') }}</h3>
                        <div class="list -striped">
                            @foreach($owedInvoices as $invoice)
                            <div class="list-item">
                                <div class="row -no-gutter-vert">
                                    <div class="col-8">
                                        <div class="key">{{ $invoice->customer->customerDetail->name }}</div>
                                        <div class="value">
                                            @if($invoice->due_date->lte(\Carbon\Carbon::now()))
                                                <i class="icon icon-attention-circled red"></i>
                                            @endif
                                            {{ $invoice->due_date->format('d-m-Y') }}
                                        </div>
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
                @if(count($unpaidInvoices))
                    <div class="card">
                        <h3>{{ trans('dam.invoice.unpaid') }}</h3>
                        <div class="list -striped">
                            @foreach($unpaidInvoices as $invoice)
                            <div class="list-item">
                                <div class="row -no-gutter-vert">
                                    <div class="col-8">
                                        <div class="key">{{ $invoice->customer->customerDetail->name }}</div>
                                        <div class="value">
                                            @if($invoice->due_date->lte(\Carbon\Carbon::now()))
                                                <i class="icon icon-attention-circled red"></i>
                                            @endif
                                            {{ $invoice->due_date->format('d-m-Y') }}
                                        </div>
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
        </div>

    </main>

@stop

@section('scripts')
    <script>
        var ctx = $("#stats");
        setTimeout(function() {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['{!! implode("', '", array_keys($stats)) !!}'],
                    datasets: [{
                        label: '{{ trans('dam.invoice.incoming.invoice') }}',
                        data: [
                            @foreach($stats as $key => $value)
                                {{ $value['incoming'] }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(75, 132, 0, .6)',
                        borderColor: '#4b8400',
                        borderWidth: 2
                    },
                    {
                        label: '{{ trans('dam.invoice.outgoing') }}',
                        data: [
                            @foreach($stats as $key => $value)
                                {{ $value['outgoing'] }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(251, 134, 164, .6)',
                        borderColor: '#ff2e63',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
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
        },1);
    </script>
@stop
