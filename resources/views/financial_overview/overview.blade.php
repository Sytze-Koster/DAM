@extends('layouts.app')

@section('content')

    @include('dashboard.partials.submenu')

    <main class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <h3>Uitgaand</h3>
                    @if(count($outgoingInvoices))
                        <div class="list -striped">
                            @foreach($outgoingInvoices as $invoice)
                                <div class="list-item">
                                    <div class="row -no-gutter-vert">
                                        <div class="col-8">
                                            <div class="key">{{ $invoice->customer->customerDetail->name }}</div>
                                            <div class="value">{{ $invoice->invoice_date->format('d-m-Y') }}</div>
                                        </div>
                                        <div class="col-4">
                                            <a href="{{ URL::action('InvoiceController@show', $invoice->id)}}" class="button -go -right">{{ trans('dam.general.more-information') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="list-item">
                                <div class="row -no-gutter">
                                    <div class="col-5">{{ trans('dam.invoice.subtotal')}}</div>
                                    <div class="col-7 -align-right">&euro; {{ number_format($outgoingTotals['sub'], 2, ',', '.') }}</div>
                                </div>
                            </div>
                            @foreach($outgoingTotals['vat'] as $vatRate => $vatRule)
                            <div class="list-item">
                                <div class="row -no-gutter">
                                    <div class="col-5">{{ $vatRate }}% {{ trans('dam.invoice.over')}} &euro; {{ number_format($vatRule['CalculatedOver'], 2, ',', '.') }}</div>
                                    <div class="col-7 -align-right">&euro; {{ number_format($vatRule['AmountOfVat'], 2, ',', '.') }}</div>
                                </div>
                            </div>
                            @endforeach
                            <div class="list-item">
                                <div class="row -no-gutter">
                                    <div class="col-5"><strong>{{ trans('dam.invoice.total_due')}}</strong></div>
                                    <div class="col-7 -align-right"><strong>&euro; {{ number_format($outgoingTotals['due'], 2, ',', '.') }}</strong></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p>{{ trans('dam.general.no_data') }}</p>
                    @endif
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <h3>Inkomend</h3>
                    @if(count($incomingInvoices))
                        <div class="list -striped">
                            @foreach($incomingInvoices as $invoice)
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
                            <div class="list-item">
                                <div class="row -no-gutter">
                                    <div class="col-5">{{ trans('dam.invoice.subtotal')}}</div>
                                    <div class="col-7 -align-right">&euro; {{ number_format($incomingTotals['sub'], 2, ',', '.') }}</div>
                                </div>
                            </div>
                            @foreach($incomingTotals['vat'] as $vatRate => $vatRule)
                            <div class="list-item">
                                <div class="row -no-gutter">
                                    <div class="col-5">{{ $vatRate }}% {{ trans('dam.invoice.over')}} &euro; {{ number_format($vatRule['CalculatedOver'], 2, ',', '.') }}</div>
                                    <div class="col-7 -align-right">&euro; {{ number_format($vatRule['AmountOfVat'], 2, ',', '.') }}</div>
                                </div>
                            </div>
                            @endforeach
                            <div class="list-item">
                                <div class="row -no-gutter">
                                    <div class="col-5"><strong>{{ trans('dam.invoice.total_due')}}</strong></div>
                                    <div class="col-7 -align-right"><strong>&euro; {{ number_format($incomingTotals['due'], 2, ',', '.') }}</strong></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p>{{ trans('dam.general.no_data') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </main>


@stop
