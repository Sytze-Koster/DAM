@extends('layouts.app', ['pageTitle' => $invoice->invoice_number])

@section('content')

    @include('invoice.partials.submenu')

    <div id="mark-as-paid" class="overlay">
        <div class="popup card">
            <h3>{{ trans('dam.invoice.mark_as_paid') }}</h3>
            <a class="close" href="#" data-turbolinks="false">&times;</a>
            <div class="content">
                {{ Form::open(['action' => ['InvoiceController@paid', $invoice->id]]) }}
                    <div class="field">
                        {{ Form::label('paid_date', trans('dam.invoice.paid_at')) }}
                        {{ Form::text('paid_date', date('d-m-Y'), ['placeholder' => trans('dam.invoice.paid_at')]) }}
                    </div>
                    <div class="-align-right">
                        {{ Form::button(trans('dam.invoice.mark_as_paid'), ['type' => 'submit', 'class' => 'button -go']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <main class="container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.invoice') }}</h3>
                    <div class="list -striped">
                        <div class="list-item">
                            <span class="key">{{ trans('dam.invoice.number') }}</span>
                            <span class="value">{{ $invoice->invoice_number }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.invoice.date') }}</span>
                            <span class="value">{{ $invoice->invoice_date->format('d-m-Y') }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.invoice.due_date') }}</span>
                            <span class="value">{{ $invoice->due_date->format('d-m-Y') }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.invoice.paid_at') }}</span>
                            <span class="value">{{ ($invoice->paid_date ? $invoice->paid_date->format('d-m-Y') : trans('dam.invoice.not_paid')) }}</span>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <h3>{{ trans('dam.customer.customer') }}</h3>
                    <div class="list -striped">
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.company_name')}}</span>
                            <span class="value">{{ $invoice->customer->customerDetail->name }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.address')}}</span>
                            <span class="value">{{ $invoice->customer->customerDetail->address }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.postal_code')}} & {{ trans('dam.customer.city') }}</span>
                            <span class="value">{{ $invoice->customer->customerDetail->postal_code }} {{ $invoice->customer->customerDetail->city }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.email_address')}}</span>
                            <span class="value">{{ $invoice->customer->customerDetail->email_address }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.phone_number')}}</span>
                            <span class="value">{{ $invoice->customer->customerDetail->phone_number }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.specification') }}</h3>
                    <div class="list -striped">
                        @foreach($invoice->items as $item)
                        <div class="list-item">
                            <span class="key">{{ $item->description }}</span>
                            <div class="row">
                                <div class="col-4">{{ trans('dam.invoice.vat_percentage') }}</div>
                                <div class="col-8 -align-right">{{ $item->vat_rate }}%</div>
                            </div>
                            <div class="row -no-gutter-vert">
                                <div class="col-4">{{ trans('dam.invoice.amount')}}</div>
                                <div class="col-8 -align-right">€ {{ $item->amount }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr />
                    <h3>{{ trans('dam.invoice.totals') }}</h3>
                    <div class="list -striped">
                        <div class="list-item">
                            <div class="row -no-gutter">
                                <div class="col-5">{{ trans('dam.invoice.subtotal')}}</div>
                                <div class="col-7 -align-right">&euro; {{ money_format('%!n', $invoice->totals('sub')) }}</div>
                            </div>
                        </div>
                        @foreach($invoice->totals('vat') as $vatRate => $vatRule)
                        <div class="list-item">
                            <div class="row -no-gutter">
                                <div class="col-5">{{ $vatRate }}% {{ trans('dam.invoice.over')}} &euro; {{ money_format('%!n', $vatRule['CalculatedOver']) }}</div>
                                <div class="col-7 -align-right">&euro; {{ money_format('%!n', $vatRule['AmountOfVat']) }}</div>
                            </div>
                        </div>
                        @endforeach
                        <div class="list-item">
                            <div class="row -no-gutter">
                                <div class="col-5"><strong>{{ trans('dam.invoice.total_due')}}</strong></div>
                                <div class="col-7 -align-right"><strong>&euro; {{ money_format('%!n', $invoice->totals('due')) }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop
