@extends('layouts.app', ['pageTitle' => trans('dam.dashboard.financial_overview')])

@section('content')

    @include('dashboard.partials.submenu')

    <main class="container">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <h3>Jaaroverzichten</h3>
                    <div class="list -striped">
                        @foreach($dates as $year => $quarter)
                            <div class="list-item">
                                <div class="row -no-gutter-vert -align-vert-center">
                                    <div class="col-6 ">
                                        <p>{{ $year }}</p>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ URL::Action('FinancialOverviewController@yearOverview', $year) }}" class="button -go -right">{{ trans('dam.general.more-information') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <h3>Kwartaaloverzichten</h3>
                    @foreach($dates as $year => $quarter)
                        <h4>{{ $year }}</h4>
                        <div class="list -striped">
                            @foreach($quarter as $quarter => $month)
                                <div class="list-item">
                                    <div class="row -no-gutter-vert -align-vert-center">
                                        <div class="col-6 ">
                                            <p>{{ trans('dam.financial.quarter.'.$quarter) }}</p>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ URL::Action('FinancialOverviewController@quarterOverview', [$year, $quarter]) }}" class="button -go -right">{{ trans('dam.general.more-information') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <h3>Maandoverzichten</h3>
                    @foreach($dates as $year => $quarter)
                        <h4>{{ $year }}</h4>
                        <div class="list -striped">
                            @foreach($quarter as $quarter => $month)
                                @foreach($month as $monthNumber => $monthName)
                                    <div class="list-item">
                                        <div class="row -no-gutter-vert -align-vert-center">
                                            <div class="col-6 ">
                                                <p>{{ $monthName }}</p>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ URL::Action('FinancialOverviewController@monthOverview', [$year, $monthNumber]) }}" class="button -go -right">{{ trans('dam.general.more-information') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>


@stop
