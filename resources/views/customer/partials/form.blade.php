<div class="row">
    <div class="col-6">
        <div class="card">
            <h3>{{ trans('dam.general.overview') }}</h3>
            <div class="field">
                {{ Form::label('customerDetail[name]', trans('dam.customer.company_name'))}}
                {{ Form::text('customerDetail[name]', null, ['placeholder' => trans('dam.customer.company_name')]) }}
            </div>
            <div class="field">
                {{ Form::label('customerDetail[address]', trans('dam.customer.address'))}}
                {{ Form::text('customerDetail[address]', null, ['placeholder' => trans('dam.customer.address')]) }}
            </div>
            <div class="field">
                {{ Form::label('customerDetail[postal_code]', trans('dam.customer.postal_code'))}}
                {{ Form::text('customerDetail[postal_code]', null, ['placeholder' => trans('dam.customer.postal_code')]) }}
            </div>
            <div class="field">
                {{ Form::label('customerDetail[city]', trans('dam.customer.city'))}}
                {{ Form::text('customerDetail[city]', null, ['placeholder' => trans('dam.customer.city')]) }}
            </div>
            <div class="field">
                {{ Form::label('customerDetail[chamber_of_commerce]', trans('dam.customer.chamber_of_commerce'))}}
                {{ Form::text('customerDetail[chamber_of_commerce]', null, ['placeholder' => trans('dam.customer.chamber_of_commerce')]) }}
            </div>
            <div class="field">
                {{ Form::label('customerDetail[vat_number]', trans('dam.customer.vat_number'))}}
                {{ Form::text('customerDetail[vat_number]', null, ['placeholder' => trans('dam.customer.vat_number')]) }}
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="card">
            <h3>{{ trans('dam.customer.contact_information') }}</h3>
            <div class="field">
                {{ Form::label('customerDetail[contact_person]', trans('dam.customer.contact_person'))}}
                {{ Form::text('customerDetail[contact_person]', null, ['placeholder' => trans('dam.customer.contact_person')]) }}
            </div>
            <div class="field">
                {{ Form::label('customerDetail[email_address]', trans('dam.customer.email_address'))}}
                {{ Form::text('customerDetail[email_address]', null, ['placeholder' => trans('dam.customer.email_address')]) }}
            </div>
            <div class="field">
                {{ Form::label('customerDetail[phone_number]', trans('dam.customer.phone_number'))}}
                {{ Form::text('customerDetail[phone_number]', null, ['placeholder' => trans('dam.customer.phone_number')]) }}
            </div>
        </div>
        <div class="card">
            <h3>{{ trans('dam.general.misc')}}</h3>
            <div class="field">
                {{ Form::hidden('only_incoming', '0') }}
                {{ Form::checkbox('only_incoming', '1', null , ['id' => 'only_incoming']) }}
                {{ Form::label('only_incoming', trans('dam.customer.only_incoming'))}}
            </div>
            <div class="field">
                {{ Form::label('customerDetail[effective_date]', trans('dam.customer.effective_date'))}}
                {{ Form::text('customerDetail[effective_date]', date('d-m-Y'), ['placeholder' => trans('dam.customer.effective_date'), 'class' => 'date']) }}
            </div>
        </div>
    </div>
    <div class="col-12 -align-right">
        {{ Form::button($buttonText, ['type' => 'submit', 'class' => 'button '.$buttonClass]) }}
    </div>
</div>
