<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        setlocale(LC_ALL, config('app.localePHP'));
        setlocale(LC_MONETARY, config('app.localePHP'));

        // Put the executed queries to the console
        \DB::listen(function ($query) {
            // Log::info('QUERY EXECUTED: '.$query->sql."\n".'With Parameters: '.implode(', ', $query->bindings));
            // $query->time
        });

        // Remember cache for 30 days
        $company = \Cache::remember('company', 1440 * 30, function() {

            if(\Schema::hasTable('company')) {
                $companyData = \App\Company::effectiveDate(\Carbon\Carbon::now())->select('name')->first();

                if($companyData) {
                    return $companyData->toArray();
                }
            }

            return ['name' => 'DAM'];

        });

        config()->set('company', $company);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
