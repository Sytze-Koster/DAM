<div class="submenu">
    <div class="container">
        @if(Active::isControllerAction('InvoiceController', 'edit'))
            <h2>{{ trans('dam.invoice.edit') }}</h2>
        @elseif(Active::isControllerAction('IncomingInvoiceController', 'create'))
            <h2>{{ trans('dam.invoice.new_incoming') }}</h2>
        @elseif(Active::isControllerAction('InvoiceController', 'create'))
            <h2>{{ trans('dam.invoice.new') }}</h2>
        @elseif(Active::isControllerAction('InvoiceController', 'show'))
            @if($invoice->is_incoming)
                <h2>{{ trans('dam.invoice.incoming.invoice') }}</h2>
            @else
                <h2>{{ trans('dam.invoice.outgoing') }}</h2>
            @endif
        @else
            <h2>{{ trans('dam.invoice.invoices') }}</h2>
        @endif
        <ul class="menu">
            <li><a href="{{ URL::action('InvoiceController@index') }}" class="{{ Active::isControllerAction('InvoiceController', 'index')}}">{{ trans('dam.general.overview') }}</a></li>
            <li><a href="{{ URL::action('InvoiceController@all') }}" class=" {{ Active::isControllerAction('InvoiceController', 'all') }} ">{{ trans('dam.invoice.all') }}</a></li>
        </ul>
        @if(Active::isControllerAction('InvoiceController', 'index'))
        <ul class="right">
            <li><a href="{{ URL::action('InvoiceController@create') }}" class="button -add">{{ trans('dam.invoice.new') }}</a></li>
            <li><a href="{{ URL::action('IncomingInvoiceController@create') }}" class="button -add">{{ trans('dam.invoice.new_incoming') }}</a></li>
        </ul>
        @endif
        @if(Active::isControllerAction('InvoiceController', 'show'))
        <ul class="right">
            @if(!$invoice->is_incoming)
            <li><a href="{{ URL::action('InvoiceController@generatePDF', $invoice->id) }}" class="button" data-turbolinks="false" target="_blank">{{ trans('dam.invoice.get-pdf') }}</a></li>
            @endif
            @if(!$invoice->paid_date)
            <li><a href="#mark-as-paid" class="button" data-turbolinks="false">{{ trans('dam.invoice.mark_as_paid') }}</a></li>
            <li><a href="{{ URL::action('InvoiceController@edit', $invoice->id)}}" class="button -edit">{{ trans('dam.invoice.edit') }}</a></li>
            @endif
        </ul>
        @endif
    </div>
</div>
