@extends('layouts.app', ['pageTitle' => $customer->customerDetail->name ])

@section('content')

    @include('customer.partials.submenu')

    <div id="delete-customer" class="overlay">
        <div class="popup card">
            <h3>{{ trans('dam.customer.delete') }}</h3>
            <a class="close" href="#" data-turbolinks="false">&times;</a>
            <div class="content">
                @if(count($customer->invoices) || count($customer->projects))
                    <p>{{ trans('dam.customer.cannot_destroy') }}</p>
                @else
                {{ Form::open(['action' => ['CustomerController@destroy', $customer->id], 'method' => 'DELETE']) }}
                    <p>{{ trans('dam.customer.destory_explained') }}</p>
                    {{ Form::button(trans('dam.customer.delete'), ['type' => 'submit', 'class' => 'button -go']) }}
                {{ Form::close() }}
                @endif
            </div>
        </div>
    </div>

    <main class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.general.overview') }}</h3>
                    <div class="list -striped">
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.company_name') }}</span>
                            <span class="value">{{ $customer->customerDetail->name }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.address') }}</span>
                            <span class="value">{{ $customer->customerDetail->address }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.postal_code') }} & {{ trans('dam.customer.city') }}</span>
                            <span class="value">{{ $customer->customerDetail->postal_code }} {{ $customer->customerDetail->city }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.chamber_of_commerce') }}</span>
                            <span class="value">{{ $customer->customerDetail->chamber_of_commerce }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.vat_number') }}</span>
                            <span class="value">{{ $customer->customerDetail->vat_number }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.general.contact_information') }}</h3>
                    <div class="list -striped">
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.contact_person') }}</span>
                            <span class="value">{{ $customer->customerDetail->contact_person }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.email_address') }}</span>
                            <span class="value">{{ $customer->customerDetail->email_address }}</span>
                        </div>
                        <div class="list-item">
                            <span class="key">{{ trans('dam.customer.phone_number') }}</span>
                            <span class="value">{{ $customer->customerDetail->phone_number }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.invoices') }}</h3>
                    @if(count($customer->invoices))
                        <div class="list -striped">
                            @foreach($customer->invoices as $invoice)
                            <div class="list-item">
                                <div class="row -align-vert-center -no-gutter">
                                    <div class="col-6">
                                        <p class="key">{{ $invoice->invoice_number }}</p>
                                        <p class="value">@if($invoice->is_incoming) {{ trans('dam.invoice.incoming.invoice') }} @else {{ trans('dam.invoice.outgoing') }} @endif</p>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ URL::action('InvoiceController@show', $invoice->id)}}" class="button -go -right -margin-top">{{ trans('dam.general.more-information') }}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p>{{ trans('dam.general.no_data') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </main>

@stop
