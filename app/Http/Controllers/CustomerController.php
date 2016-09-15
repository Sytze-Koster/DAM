<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerDetail;
use App\Http\Requests;
use App\Http\Requests\CustomerRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;
use Session;

class CustomerController extends Controller
{

    /**
     * Constructor
     *
     **/
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
        $customers = Customer::effectivedate(Carbon::now())->get();
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {

        // Create customer
        $customer = new Customer;
        $customer->customer_number = $this->generateUniqueCustomerNumber();
        $customer->save();

        // Add details to cusotmer
        $customer->addDetail(
            new CustomerDetail($request->customerDetail)
        );

        Session::flash('success', trans('dam.customer.stored'));
        return Redirect::action('CustomerController@show', $customer->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::effectiveDate(Carbon::now())->with('invoices')->findOrFail($id);
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::effectivedate(Carbon::now())->findOrFail($id);

        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->addDetail(
            new CustomerDetail($request->customerDetail)
        );

        $customer->update($request->all());

        Session::flash('success', trans('dam.customer.updated'));
        return Redirect::action('CustomerController@show', $customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {

        // Only delete customers when there's not a linked project or invoice
        if(count($customer->invoice) == 0 && count($customer->projects) == 0) {
            $customer->delete();

            // Notify the user
            Session::flash('success', trans('dam.customer.destroyed'));
            return Redirect::action('CustomerController@index');
        }

        // Notify the user
        Session::flash('error', trans('dam.customer.cannot_destroy'));
        return Reidrect::action('CustomerController@show', $customer->id);

    }

    /**
     *  Generate unique customer number.
     *
     * @return  int  $customerNumber
     */
    private function generateUniqueCustomerNumber()
    {

        $customerNumber = rand(1000, 9999);

        while(Customer::where('customer_number', $customerNumber)->exists()) {
            $customerNumber = rand(1000, 9999);
        }

        return $customerNumber;

    }

    /**
     *  Return customer JSON based on ID
     *
     * @return  string  $customer
     */
    public function getCustomerJSON(Request $request, $id)
    {

        // Get customer data
        $customer = Customer::effectivedate(Carbon::now())
                            ->with('ongoingProjects')
                            ->findOrFail($request->customer);

        $nextInvoiceNumber = InvoiceController::generateInvoiceNumber($customer->id);

        return array_add($customer, 'nextInvoiceNumber', $nextInvoiceNumber);

    }

}
