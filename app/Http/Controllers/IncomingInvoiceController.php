<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests;
use App\Invoice;
use App\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;
use Session;

class IncomingInvoiceController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $customers = Customer::effectivedate(Carbon::now())->get();
        $vat = ['21' => '21%', '6' => '6%', '0' => '0%'];

        $customerList = [];
        foreach($customers as $customer) {
            $key = trans('dam.general.other');

            if($customer->only_incoming == 1) {
                $key = trans('dam.invoice.incoming.only_incoming');
            }

            $customerList[$key][$customer->id] = $customer->customerDetail->name;
        }

        return view('invoice.incoming.create', compact('customerList', 'vat'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $invoice = new Invoice;
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_number = $request->invoice['number'];
        $invoice->invoice_date = Carbon::createFromFormat('d-m-Y', $request->invoice['date'])->format('Y-m-d');
        $invoice->due_date = Carbon::createFromFormat('d-m-Y', $request->invoice['due_date'])->format('Y-m-d');
        $invoice->is_incoming = 1;
        $invoice->save();

        // Foreach items
        foreach($request->items as $item) {

            // Add item to invoice
            $invoice->addItem(
                new InvoiceItem($item)
            );

        }

        Session::flash('success', trans('dam.invoice.incoming.added'));
        return Redirect::action('InvoiceController@index');
    }

}
