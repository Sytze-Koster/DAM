@extends('layouts.app', ['pageTitle' => trans('dam.invoice.edit') ])

@section('content')

    @include('invoice.partials.submenu')

    <main class="container">
        {{ Form::model($invoice, ['action' => ['InvoiceController@update', $invoice->id], 'method' => 'PATCH']) }}
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.addressor') }}</h3>
                    <div class="field">
                        {{ Form::label('customer_id', trans('dam.customer.customer')) }}
                        {{ Form::text('customer_id', $invoice->customer->customerDetail->name, ['placeholder' => trans('dam.customer.customer'), 'disabled' => 'disabled']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('customer[contact_person]', trans('dam.customer.contact_person')) }}
                        {{ Form::text('customer[contact_person]', $invoice->customer->customerDetail->contact_person, ['placeholder' => trans('dam.customer.contact_person'), 'disabled' => 'disabled']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('customer[address]', trans('dam.customer.address')) }}
                        {{ Form::text('customer[address]', $invoice->customer->customerDetail->address, ['placeholder' => trans('dam.customer.address'), 'disabled' => 'disabled']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('customer[postal_city]', trans('dam.customer.postal_code').' & '.trans('dam.customer.city')) }}
                        {{ Form::text('customer[postal_city]', $invoice->customer->customerDetail->postal_code.' '.$invoice->customer->customerDetail->city, ['placeholder' => trans('dam.customer.postal_code').' & '.trans('dam.customer.city'), 'disabled' => 'disabled']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('customer[email_address]', trans('dam.customer.email_address')) }}
                        {{ Form::text('customer[email_address]', $invoice->customer->customerDetail->email_address, ['placeholder' => trans('dam.customer.email_address'), 'disabled' => 'disabled']) }}
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.details')}}</h3>
                    <div class="field">
                        {{ Form::label('invoice[date]', trans('dam.invoice.date')) }}
                        {{ Form::text('invoice[date]', $invoice->invoice_date->format('d-m-Y'), ['placeholder' => trans('dam.invoice.date'), 'class' => 'date']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('invoice[due_date]', trans('dam.invoice.due_date')) }}
                        {{ Form::text('invoice[due_date]', $invoice->due_date->format('d-m-Y'), ['placeholder' => trans('dam.invoice.due_date'), 'class' => 'date']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('invoice[number]', trans('dam.invoice.number')) }}
                        {{ Form::text('invoice[number]', $invoice->invoice_number, ['placeholder' => trans('dam.invoice.number'), 'disabled' => 'disabled']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.specification') }}</h3>
                    <div id="specification">
                        @foreach($invoice->items as $item)
                            <hr />
                        <div class="row -no-gutter-hor -align-vert-center specification">
                            <div class="col-4">{{ trans('dam.project.project') }}</div>
                            <div class="col-8 field">{{ Form::select('items['.$item->id.'][project_id]', $projects, $item->project_id, ['class' => 'projects']) }}</div>
                            <div class="col-4">{{ trans('dam.invoice.description') }}</div>
                            <div class="col-8 field">{{ Form::text('items['.$item->id.'][description]', $item->description) }}</div>
                            <div class="col-4">{{ trans('dam.invoice.vat_percentage') }}</div>
                            <div class="col-8 field">{{ Form::select('items['.$item->id.'][vat_rate]', $vat, $item->vat_rate, ['class' => 'vat_percentage']) }}</div>
                            <div class="col-4">{{ trans('dam.invoice.amount') }}</div>
                            <div class="col-8 field">
                                <div class="input-prepend">
                                    <span>&euro;</span>
                                    {{ Form::text('items['.$item->id.'][amount]', $item->amount, ['class' => '-align-right amount', 'data-index' => $item->id]) }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <span class="button -add -margin-top -right add_specification">{{ trans('dam.invoice.add_details') }}</span>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.totals') }}</h3>
                    <div class="row -no-gutter-hor -align-vert-center">
                        <div class="col-6">{{ trans('dam.invoice.subtotal') }}</div>
                        <div class="col-6 field">
                            <div class="input-prepend">
                                <span>&euro;</span>
                                <input id="subtotal" type="text" class="-align-right" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-6">{{ trans('dam.invoice.vat_percentage') }}</div>
                        <div class="col-6 field">
                            <div class="input-prepend">
                                <span>&euro;</span>
                                <input id="total_vat" type="text" class="-align-right" disabled="disabled">
                            </div>
                        </div>
                        <div class="col-6">{{ trans('dam.invoice.total_due') }}</div>
                        <div class="col-6 field">
                            <div class="input-prepend">
                                <span>&euro;</span>
                                <input id="total_due" type="text" class="-align-right" disabled="disabled">
                            </div>
                        </div>
                    </div>
                    {{ Form::button(trans('dam.invoice.edit'), ['class' => 'button -go -right -margin-top', 'type' => 'submit']) }}
                </div>

            </div>
        </div>

        </div>
        {{ Form::close() }}
    </main>
@stop

@section('scripts')
    <script>
        $('#customer').on('change', function() {
            var valueSelected = this.value;
            if(valueSelected > 0) {
                $.get("{{ URL::action('CustomerController@getCustomerJSON', 0)}}", {customer: valueSelected}, function(data) {
                    $('input[name="customer[contact_person]"]').val(data.customer_detail.contact_person);
                    $('input[name="customer[address]"]').val(data.customer_detail.address);
                    $('input[name="customer[postal_city]"]').val(data.customer_detail.postal_code + ' ' + data.customer_detail.city);
                    $('input[name="customer[email_address]"]').val(data.customer_detail.email_address);
                    $('input[name="invoice[number]"]').val(data.nextInvoiceNumber);

                    var projects = [];
                    $(data.ongoing_projects).each(function() {
                        projects.push(this.id);
                    });

                    $('.projects option').show();
                    $('.projects option').each(function() {
                        if(projects.indexOf(parseInt($(this).val())) < 0 && $(this).val() != 0) {
                            $('.projects option[value='+$(this).val()+']').hide();
                        }
                    });
                });
            }
        });

        function calculateAmounts() {
            console.log('loaded');
            var subtotal = 0;
            var total_vat = 0;
            var total_due = 0;
            $('.amount').each(function() {
                var amount = this.value.replace(/,/g,'.');
                var amount = parseFloat(amount);
                if(!isNaN(amount)) {
                    var index = $(this).data('index');
                    var vat_percentage = $("select[name='items["+index+"][vat_rate]']").val();

                    subtotal += amount;
                    total_vat += amount * (vat_percentage / 100);
                    total_due += amount + total_vat;

                }
            });

            $('#subtotal').val(number_format(subtotal, 2, ',', '.'));
            $('#total_vat').val(number_format(total_vat, 2, ',', '.'));
            $('#total_due').val(number_format(total_due, 2, ',', '.'));
        }

        $('.amount, .vat_percentage, .add_specification').on('keyup change focusout click', calculateAmounts);

        $(document).on('ready turbolinks:render', function() {
            $('.amount').change();
        });

        function amountToReadable() {
            this.value = this.value.replace(/[^0-9\,-]/g,'');
            this.value = this.value.replace(/\./g,'');
            this.value = this.value.replace(/,/g,'.');
            this.value = number_format(this.value, 2, ',', '.');
        }

        $('.amount').on('focusout', amountToReadable);

        $('.add_specification').on('click', function() {
            var specificationRule = $('#specification .specification')[0].outerHTML;
            specificationRule = specificationRule.replace(/\[\d+\]/g, '['+Date.now()+']');
            specificationRule = specificationRule.replace(/type="text" value=".*"/g, 'type="text" value=""');
            specificationRule = specificationRule.replace(/selected="selected"/g, '');
            $('#specification').append('<hr />'+specificationRule);
            $('.amount, .vat_percentage, .add_specification').on('keyup change focusout click', calculateAmounts);
            $('.amount').on('focusout', amountToReadable);
        });
    </script>
@stop
