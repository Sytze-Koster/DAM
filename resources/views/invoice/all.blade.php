@extends('layouts.app', ['pageTitle' => trans('dam.invoice.invoices') ])

@section('content')

    @include('invoice.partials.submenu')

    <main class="container">
        <div class="row -align-hor-center">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.invoices') }}</h3>
                    <div class="list -striped">
                        @foreach($invoicesWithData as $invoice)
                        <div class="list-item">
                            <div class="row -no-gutter-vert">
                                <div class="col-8">
                                    <div class="key">{{ $invoice['customer']->customerDetail->name }}</div>
                                    <div class="value">{{ $invoice['invoice_number'] }}</div>
                                </div>
                                <div class="col-4">
                                    <a href="{{ URL::action('InvoiceController@show', $invoice['id']) }}" class="button -go">{{ trans('dam.general.more-information') }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {!! $invoices->render() !!}
                </div>
            </div>

            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.incoming.invoices') }}</h3>
                    <div class="list -striped">
                        @foreach($incomingInvoicesWithData as $invoice)
                        <div class="list-item">
                            <div class="row -no-gutter-vert">
                                <div class="col-8">
                                    <div class="key">{{ $invoice['customer']->customerDetail->name }}</div>
                                    <div class="value">{{ $invoice['invoice_number'] }}</div>
                                </div>
                                <div class="col-4">
                                    <a href="{{ URL::action('InvoiceController@show', $invoice['id']) }}" class="button -go">{{ trans('dam.general.more-information') }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {!! $incomingInvoices->render() !!}
                </div>
            </div>
        </div>
    </main>

@stop
