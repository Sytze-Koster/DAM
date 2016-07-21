<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $invoice->invoice_number }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ url('css/invoice/bever/style.css') }}">

</head>

<body>

    <div class="line"></div>

    <table id="header" width="100%">
        <tr>
            <td width="32%" rowspan="3" class="-align-vert-middle"><img src="{{ url('i/invoice/bever/logo.png') }}" height="45" width="199"></td>
            <td width="20%">{{ $company->name }}</td>
            <td width="20%"><span>T</span> {{ $company->phone_number }}</td>
            <td width="28%"><span class="large">KVK</span> {{ $company->chamber_of_commerce }}</td>
        </tr>
        <tr >
            <td>{{ $company->address }}</td>
            <td><span>E</span> {{ $company->email_address }}</td>
            <td><span class="large">VAT</span> {{ $company->vat_number }}</td>
        </tr>
        <tr>
            <td>{{ $company->postal_code }} {{ $company->city }}</td>
            <td><span>W</span> {{ $company->website }}</td>
            <td><span class="large">IBAN</span> {{ $company->bank_account_number }}</td>
        </tr>
    </table>

    <div id="addresser">
        <h2>Geadresseerde</h2>
        <table width="100%">
            <tr>
                <td><strong>{{ $invoice->customer->customerDetail->name }}</strong></td>
            </tr>
            <tr>
                <td>{{ $invoice->customer->customerDetail->contact_person}}</td>
            </tr>
            <tr>
                <td>{{ $invoice->customer->customerDetail->address }}</td>
            </tr>
            <tr>
                <td>{{ $invoice->customer->customerDetail->postal_code }} {{ $invoice->customer->customerDetail->city }}</td>
            </tr>
        </table>
    </div>

    <div id="invoice_details">
        <h2>Factuur</h2>
        <table width="100%">
            <tr>
                <td width="17%">Factuurdatum</td>
                <td width="15px" class="-align-right">:</td>
                <td>&nbsp;{{ $invoice->invoice_date->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td>Vervaldatum</td>
                <td width="15px" class="-align-right">:</td>
                <td>&nbsp;{{ $invoice->due_date->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td>Factuurnummer</td>
                <td width="15px" class="-align-right">:</td>
                <td>&nbsp;{{ $invoice->invoice_number }}</td>
            </tr>
        </table>
    </div>

    <div id="invoice_items">
        <h2>Specificatie</h2>
        <table width="100%">
            <thead>
                <tr>
                    <td width="75%"><strong>Omschrijving</strong></td>
                    <td width="9%"><strong>BTW</strong></td>
                    <td width="3%"></td>
                    <td width="13%" class="-align-right"><strong>Bedrag</strong></td>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td><span>{{ $item->description }}</span></td>
                    <td><span>{{ $item->vat_rate }}%</span></td>
                    <td class="-align-right"><span>&euro;</span></td>
                    <td class="-align-right"><span>{{ $item->amount }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="height:{{ (40 * 10) - (40 * count($invoice->items)) - (40 * $invoice->numberOfVATRates()) }}px"></div>

    <div id="totals">
        <table width="100%">
            <tbody>
                <tr>
                    <td width="84%"><strong>{{ trans('dam.invoice.subtotal')}}</strong></td>
                    <td width="3%" class="-align-right">&euro;</td>
                    <td width="13%" class="-align-right">{{ money_format('%!n', $invoice->totals('sub')) }}</td>
                </tr>
                @foreach($invoice->totals('vat') as $vatRate => $vatRule)
                    <tr>
                        <td width="84%"><strong>BTW ({{ $vatRate }}%) {{ trans('dam.invoice.over')}} &euro; {{ money_format('%!n', $vatRule['CalculatedOver']) }}</strong></td>
                        <td width="3%" class="-align-right">&euro;</td>
                        <td width="13%" class="-align-right">{{ money_format('%!n', $vatRule['AmountOfVat']) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td width="84%"><strong>{{ trans('dam.invoice.total_due')}}</strong></td>
                    <td width="3%" class="-align-right"><strong>&euro;</strong></td>
                    <td width="13%" class="-align-right"><strong>{{ money_format('%!n', $invoice->totals('due')) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <footer>
        <p>Gelieve voor de uiterste vervaldatum te betalen o.v.v.<br />het bovenstaande factuurnummer op {{ $company->bank_account_number }}.</p>
    </footer>

</body>
