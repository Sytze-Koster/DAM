<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests;
use App\Http\Requests\SettingsCompanyRequest;
use App\Http\Requests\SettingsVatRequest;
use App\User;
use App\VatRate;
use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Redirect;
use Session;

class SettingsController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Display Company settings form
     *
     * @return    \Illuminate\Http\Response
     */
    public function company()
    {
        $company = Company::effectiveDate(Carbon::now())->first();

        $invoice_templates = $this->getAvailableInvoiceTemplates();

        return view('settings.company', compact('company', 'invoice_templates'));
    }

    /**
     * Add a row to the 'company' table
     *
     * @param     \App\Http\Requests\SettingsCompanyRequest $request
     * @return    \Illuminate\Http\Response
     */
    public function companyUpdate(SettingsCompanyRequest $request)
    {

        $company = Company::create($request->all());

        // Clear cache
        Cache::forget('company');

        Session::flash('success', trans('dam.settings.company_saved'));
        return Redirect::action('SettingsController@company');

    }

    /**
     * Display Account settings form
     *
     * @return    \Illuminate\Http\Response
     */
    public function account()
    {
        $user = User::find(Auth::User()->id);
        return view('settings.account', compact('user'));
    }

    /**
     * Update password or username
     *
     * @param     \App\Http\Request $request
     * @return    \Illuminate\Http\Response
     */
    public function accountUpdate(Request $request)
    {

        $user = User::find(Auth::User()->id);

        // User wants to change password
        if($request->has('change_password')) {

            // Validate input
            $this->validate($request, [
               'password' => 'required',
               'new_password' => 'required|confirmed',
           ]);

           // Check if current password is correct
           if(Auth::validate(['email' => $user->email, 'password' => $request->password])) {
               $user->password = $request->new_password;
               Session::flash('success', trans('dam.settings.updated_password'));
           } else {
               Session::flash('error', trans('dam.settings.password_not_the_same'));
           }

        }

        // User wants to change username (email)
        if($request->has('change_username')) {

            // Validate input
            $this->validate($request, [
                'email' => 'required|email',
            ]);

            $user->email = $request->email;
            Session::flash('success', trans('dam.settings.updated_username'));

        }

        // Save changes to the user model
        $user->save();

        return Redirect::action('SettingsController@account');

    }

    /**
     * Toggle Two Factor Authentication
     *
     * @return    \Illuminate\Http\Response
     */
    public function toggleTwoFactorAuthentication()
    {

        $user = User::find(Auth::User()->id);

        // If token is present, turn 2FA off
        if($user->gauth_token) {
            $user->gauth_token = '';
            $user->save();

            Session::flash('success', trans('dam.settings.two_factor_authentication.turned_off'));
            return Redirect::action('SettingsController@account');
        }

        // Token isn't present, turn 2FA on
        else {
            $google2fa = new Google2FA();

            // Set secret key and save it.
            $user->gauth_token = $google2fa->generateSecretKey();
            $user->save();

            // Generate Image
            $google2fa_url = $google2fa->getQRCodeGoogleUrl(
                config('company')['name'],
                $user->email,
                $user->gauth_token
            );

            Session::flash('success', trans('dam.settings.two_factor_authentication.turned_on'));
            return view('settings.two_factor_authentication', compact('google2fa_url'));
        }

    }

    public function vat()
    {
        $vat_percentages = VatRate::all();

        return view('settings.vat', compact('vat_percentages'));
    }

    public function vatStore(SettingsVatRequest $request)
    {
        VatRate::create($request->all());

        Session::flash('success', trans('dam.settings.vat.added'));
        return Redirect::action('SettingsController@vat');
    }

    public function vatDestroy($id)
    {
        VatRate::findOrFail($id)->delete();

        Session::flash('success', trans('dam.settings.vat.destroyed'));
        return Redirect::action('SettingsController@vat');
    }

    /**
     * List all files in /resources/views/pdf/invoice directory
     *
     * @return    Array $invoice_templates
     */
    public function getAvailableInvoiceTemplates()
    {

        // Get all files
        $pdf_files = scandir(base_path().'/resources/views/pdf/invoice');

        $invoice_templates = [];

        foreach($pdf_files as $key => $value) {

            if(ends_with($value, '.blade.php')) {

                // Remove '.blade.php' from filename
                $value = preg_replace('/.blade.php/', '', $value);
                $invoice_templates[$value] = $value;

            }

        }

        return $invoice_templates;
    }

}
