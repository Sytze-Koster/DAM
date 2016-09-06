<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ (isset($pageTitle) ? $pageTitle : 'No Title') }} - {{ (isset(config('company')['name']) ? config('company')['name'] : '') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Maven+Pro:100,300,400,700">

    <!-- Styles -->
    <!--<link rel="stylesheet" href="{{ elixir('css/app.css') }}">-->
    <link rel="stylesheet" href="{{ url('css/app.css') }}">

    <script>
        document.addEventListener("turbolinks:click", function() { NProgress.start(); });
        document.addEventListener("turbolinks:before-visit", function() { NProgress.inc(); });
        document.addEventListener("turbolinks:request-start", function() { NProgress.inc(); });
        document.addEventListener("turbolinks:visit", function() { NProgress.inc(); });
        document.addEventListener("turbolinks:request-end", function() { NProgress.inc(); });
        document.addEventListener("turbolinks:before-cache", function() { NProgress.inc(); });
        document.addEventListener("turbolinks:before-render", function() { NProgress.inc(); });
        document.addEventListener("turbolinks:render", function() { NProgress.done(); });
        document.addEventListener("turbolinks:load", function() { NProgress.done(); setTimeout(NProgress.remove(), 2000);  });
    </script>
</head>
<body>
    <header>
        <div class="container">
            <h1>{{ (isset(config('company')['name']) ? config('company')['name'] : 'DAM') }}</h1>
            <nav>
                @if(Auth::User())
                <ul class="menu">
                    <li><a href="{{ URL::action('DashboardController@index')}}" class="{{ Active::isController('DashboardController') }}">{{ trans('dam.menu.home') }}</a></li>
                    <li><a href="{{ URL::action('InvoiceController@index')}}" class="{{ Active::isController('InvoiceController') }} {{ Active::isController('IncomingInvoiceController') }}">{{ trans('dam.menu.invoices') }}</a></li>
                    <li><a href="{{ URL::action('ProjectController@index') }}" class="{{ Active::isController('ProjectController') }}">{{ trans('dam.menu.projects') }}</a></li>
                    <li><a href="{{ URL::action('CustomerController@index') }}" class="{{ Active::isController('CustomerController') }}">{{ trans('dam.menu.customer') }}</a></li>
                    <li><a href="{{ URL::action('SettingsController@index') }}" class="{{ Active::isController('SettingsController') }}">{{ trans('dam.menu.settings') }}</a></li>
                </ul>
                @endif
            </nav>
            @if(Auth::User())
            <ul class="user-info">
                <li>{{ Auth::User()->email }}</li>
                <li><a href="{{ URL::action('Auth\AuthController@lock') }}" class="button -secondary">{{ trans('dam.menu.lock') }}</a></li>
            </ul>
            @endif
        </div>
    </header>

    @yield('content')

    @if(Session::has('success'))
        <div class="notification -success">
            <div class="container">
                <i class="icon icon-ok"></i> {{ Session::get('success') }}
            </div>
        </div>
    @endif

    @if(Session::has('error'))
        <div class="notification -error">
            <div class="container">
                <i class="icon icon-cancel"></i> {{ Session::get('error') }}
            </div>
        </div>
    @endif

    @if(count($errors) > 0)
        <div class="notification -error">
            <div class="container">
                <i class="icon icon-cancel"></i> {{ trans('dam.general.error.validation') }}
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <script src="{{ url('js/main.js') }}" data-turbolinks-eval="false"></script>
    @yield('scripts')
</body>
</html>
