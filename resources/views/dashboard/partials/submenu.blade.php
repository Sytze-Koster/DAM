<div class="submenu">
    <div class="container">
        <h2>{{ trans('dam.dashboard.dashboard') }}</h2>
        <ul class="menu">
            <li><a href="{{ URL::action('DashboardController@index') }}" class="{{ Active::isControllerAction('DashboardController', 'index') }}">{{ trans('dam.dashboard.overview') }}</a></li>
            <li><a href="{{ URL::action('FinancialOverviewController@index') }}" class="{{ Active::isControllerAction('FinancialOverviewController', 'index') }}">{{ trans('dam.dashboard.financial_overview') }}</a></li>
        </ul>
    </div>
</div>
