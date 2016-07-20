<div class="submenu">
    <div class="container">
        @if(Active::isControllerAction('CustomerController', 'show'))
            <h2>{{ $customer->customerDetail->name }}</h2>
        @else
            <h2>{{ trans('dam.customer.customers') }}</h2>
        @endif
        <ul class="menu">
            @if(Active::isControllerAction('CustomerController', 'show'))
            @else
                <li><a href="{{ URL::action('CustomerController@index') }}" class="{{ Active::isControllerAction('CustomerController', 'index') }}">{{ trans('dam.general.overview') }}</a></li>
            @endif
        </ul>
        @if(Active::isControllerAction('CustomerController', 'index'))
        <ul class="right">
            <li><a href="{{ URL::action('CustomerController@create') }}" class="button -add">{{ trans('dam.customer.new') }}</a></li>
        </ul>
        @elseif(Active::isControllerAction('CustomerController', 'show'))
        <ul class="right">
            <li><a href="{{ URL::action('CustomerController@edit', $customer->id) }}" class="button -edit">{{ trans('dam.customer.edit') }}</a></li>
            <li><a href="#delete-customer" class="button -delete"  data-turbolinks="false">{{ trans('dam.customer.delete') }}</a></li>
        </ul>
        @endif
    </div>
</div>
