@extends('layouts.app', ['pageTitle' => trans('dam.settings.company')])

@section('content')

    <div class="submenu">
        <div class="container">
            <h2>{{ trans('dam.settings.company') }}</h2>
        </div>
    </div>

    <main class="container">
        {{ Form::model($company, ['action' => 'SettingsController@companyUpdate']) }}
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.location_data') }}</h3>
                    <div class="field">
                        {{ Form::label('name', trans('dam.settings.company_name')) }}
                        {{ Form::text('name', old('name'), ['placeholder' => trans('dam.settings.company_name')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('address', trans('dam.settings.company_address')) }}
                        {{ Form::text('address', old('address'), ['placeholder' => trans('dam.settings.company_address')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('postal_code', trans('dam.settings.company_postal_code')) }}
                        {{ Form::text('postal_code', old('postal_code'), ['placeholder' => trans('dam.settings.company_postal_code')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('city', trans('dam.settings.company_city')) }}
                        {{ Form::text('city', old('city'), ['placeholder' => trans('dam.settings.company_city')])}}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <h3>{{ trans('dam.settings.other_data') }}</h3>
                    <div class="field">
                        {{ Form::label('phone_number', trans('dam.settings.company_phone_number')) }}
                        {{ Form::text('phone_number', old('phone_number'), ['placeholder' => trans('dam.settings.company_phone_number')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('email_address', trans('dam.settings.company_email_address')) }}
                        {{ Form::text('email_address', old('email_address'), ['placeholder' => trans('dam.settings.company_email_address')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('website', trans('dam.settings.company_website')) }}
                        {{ Form::text('website', old('website'), ['placeholder' => trans('dam.settings.company_website')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('chamber_of_commerce', trans('dam.settings.company_chamber_of_commerce')) }}
                        {{ Form::text('chamber_of_commerce', old('chamber_of_commerce'), ['placeholder' => trans('dam.settings.company_chamber_of_commerce')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('vat_number', trans('dam.settings.company_vat_number')) }}
                        {{ Form::text('vat_number', old('vat_number'), ['placeholder' => trans('dam.settings.company_vat_number')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('bank_account_number', trans('dam.settings.company_bank_account_number')) }}
                        {{ Form::text('bank_account_number', old('bank_account_number'), ['placeholder' => trans('dam.settings.company_bank_account_number')])}}
                    </div>
                </div>

                <div class="card">
                    <h3>{{ trans('dam.general.other') }}</h3>
                    <div class="field">
                        {{ Form::label('invoice_template', trans('dam.settings.company_invoice_template')) }}
                        {{ Form::select('invoice_template', $invoice_templates, old('invoice_template'), ['placeholder' => trans('dam.settings.company_invoice_template')])}}
                    </div>
                    <div class="field">
                        {{ Form::label('effective_date', trans('dam.settings.company_effective_date')) }}
                        {{ Form::text('effective_date', date('d-m-Y H:i'), ['placeholder' => trans('dam.settings.company_effective_date')])}}
                    </div>
                </div>

                <div class="-align-right">
                    {{ Form::button(trans('dam.general.save'), ['class' => 'button -go', 'type' => 'submit']) }}
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </main>

@stop
