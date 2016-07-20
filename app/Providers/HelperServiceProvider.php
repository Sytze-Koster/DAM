<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ActiveStateHelper', function()
        {
            return new \App\Helpers\ActiveStateHelper;
            //return true;
        });
        /*foreach (glob(app_path().'/Helpers/*.php') as $filename){
            require_once($filename);
        }*/

    }
}
