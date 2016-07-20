@extends('layouts.app')

@section('content')

    @include('invoice.partials.submenu')

    <main class="container">
        {{ Form::open(['action' => 'IncomingInvoiceController@store', 'method' => 'POST']) }}
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.addressor') }}</h3>
                    <div class="field">
                        {{ Form::label('customer_id', trans('dam.customer.customer')) }}
                        {{ Form::select('customer_id', $customerList, null, ['placeholder' => trans('dam.customer.customer')]) }}
                    </div>
                    <div class="field">
                        {{ Form::label('customer[contact_person]', trans('dam.customer.contact_person')) }}
                        {{ Form::text('customer[contact_person]', null, ['placeholder' => trans('dam.customer.contact_person'), 'disabled' => 'disabled']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('customer[address]', trans('dam.customer.address')) }}
                        {{ Form::text('customer[address]', null, ['placeholder' => trans('dam.customer.address'), 'disabled' => 'disabled']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('customer[postal_city]', trans('dam.customer.postal_code').' & '.trans('dam.customer.city')) }}
                        {{ Form::text('customer[postal_city]', null, ['placeholder' => trans('dam.customer.postal_code').' & '.trans('dam.customer.city'), 'disabled' => 'disabled']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('customer[email_address]', trans('dam.customer.email_address')) }}
                        {{ Form::text('customer[email_address]', null, ['placeholder' => trans('dam.customer.email_address'), 'disabled' => 'disabled']) }}
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.details')}}</h3>
                    <div class="field">
                        {{ Form::label('invoice[date]', trans('dam.invoice.date')) }}
                        {{ Form::text('invoice[date]', date('d-m-Y'), ['placeholder' => trans('dam.invoice.date'), 'class' => 'date']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('invoice[due_date]', trans('dam.invoice.due_date')) }}
                        {{ Form::text('invoice[due_date]', date('d-m-Y'), ['placeholder' => trans('dam.invoice.due_date'), 'class' => 'date']) }}
                    </div>
                    <div class="field">
                        {{ Form::label('invoice[number]', trans('dam.invoice.number')) }}
                        {{ Form::text('invoice[number]', null, ['placeholder' => trans('dam.invoice.number')]) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <h3>{{ trans('dam.invoice.specification') }}</h3>
                    <div id="specification">
                        <div class="row -no-gutter-hor -align-vert-center specification">
                            <div class="col-4">{{ trans('dam.invoice.description') }}</div>
                            <div class="col-8 field">{{ Form::text('items[0][description]') }}</div>
                            <div class="col-4">{{ trans('dam.invoice.vat_percentage') }}</div>
                            <div class="col-8 field">{{ Form::select('items[0][vat_rate]', $vat, null, ['class' => 'vat_percentage']) }}</div>
                            <div class="col-4">{{ trans('dam.invoice.amount') }}</div>
                            <div class="col-8 field">
                                <div class="input-prepend">
                                    <span>&euro;</span>
                                    {{ Form::text('items[0][amount]', null, ['class' => '-align-right amount']) }}
                                </div>
                            </div>
                        </div>
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
                    {{ Form::button(trans('dam.invoice.generate'), ['class' => 'button -go -right -margin-top', 'type' => 'submit']) }}
                </div>

            </div>
        </div>

        </div>
        {{ Form::close() }}
    </main>
@stop

@section('scripts')
    <script>
        $('#customer_id').on('change', function() {
            var valueSelected = this.value;
            if(valueSelected > 0) {
                $.get("{{ URL::action('CustomerController@getCustomerJSON', 0)}}", {customer: valueSelected}, function(data) {
                    $('input[name="customer[contact_person]"]').val(data.customer_detail.contact_person);
                    $('input[name="customer[address]"]').val(data.customer_detail.address);
                    $('input[name="customer[postal_city]"]').val(data.customer_detail.postal_code + ' ' + data.customer_detail.city);
                    $('input[name="customer[email_address]"]').val(data.customer_detail.email_address);

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

        $('.amount, .vat_percentage').on('keyup change focusout', function() {
            var subtotal = 0;
            var total_vat = 0;
            var total_due = 0;
            $('.amount').each(function() {
                var amount = this.value.replace(/,/g,'.');
                var amount = parseFloat(amount);
                if(!isNaN(amount)) {
                    var index = $(this).index('.amount');
                    var vat_percentage = $("select[name='items["+index+"][vat_rate]']").val();

                    subtotal += amount;
                    total_vat += amount * (vat_percentage / 100);
                    total_due += amount + total_vat;
                }
            });

            $('#subtotal').val(number_format(subtotal, 2, ',', '.'));
            $('#total_vat').val(number_format(total_vat, 2, ',', '.'));
            $('#total_due').val(number_format(total_due, 2, ',', '.'));
        });

        $('.amount').on('focusout', function() {
            this.value = this.value.replace(/[^0-9\,-]/g,'');
            this.value = this.value.replace(/\./g,'');
            this.value = this.value.replace(/,/g,'.');
            this.value = number_format(this.value, 2, ',', '.');
        });

        $('.add_specification').on('click', function() {
            var specificationRule = $('#specification .specification')[0].outerHTML
            specificationRule = specificationRule.replace(/\[0\]/g, '['+Date.now()+']')
            $('#specification').append('<hr />'+specificationRule);
        });
    </script>
@stop
