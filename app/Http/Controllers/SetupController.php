<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\SetupRequest;
use App\User;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Redirect;

class SetupController extends Controller
{

    function __construct()
    {
        if(Cache::get('userCount')) {
            return Redirect::action('DashboardController@index');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SettingsController $settings)
    {
        $invoice_templates = $settings->getAvailableInvoiceTemplates();

        return view('setup.index', compact('invoice_templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SetupRequest $request)
    {

        // Add effective date to input
        $request->merge(['effective_date' => date('d-m-Y H:i')]);

        Company::create($request->all());
        User::create($request->only('email', 'password'));

        // Reset caches
        Cache::forget('userCount');
        Cache::forget('company');

        // Return to dashboard, but actually to 'login'. User is redirected to the Dashboard after login.
        return Redirect::action('DashboardController@index');

    }

}
