<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;
use App\Http\Requests;
use App\Http\Requests\InvoiceRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Invoice;
use App\InvoiceItem;
use App\Project;
use App\VatRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Redirect;
use Session;

class InvoiceController extends Controller
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

        $today = Carbon::now();
        $aYearAgo = Carbon::now()->subYear()->firstOfQuarter();

        // Get Invoices where the invoice_date is between a year ago and today
        $invoices = Invoice::with('items')->whereBetween('invoice_date', [$aYearAgo, $today])->get();

        // Initialize all the quarters
        $stats = [];
        for($i = $aYearAgo; $i <= $today; $i->addMonths(3)) {
            $stats[$i->quarter.'-'.$i->format('Y')]['incoming'] = 0;
            $stats[$i->quarter.'-'.$i->format('Y')]['outgoing'] = 0;
        }

        // Add amount of all invoices to the right quarter in the right group ('incoming' or 'outgoing')
        foreach($invoices as $invoice) {
            foreach($invoice->items as $item) {
                if($invoice->is_incoming) {
                    $stats[$invoice->invoice_date->quarter.'-'.$invoice->invoice_date->format('Y')]['incoming'] += $item->amount;
                } else {
                    $stats[$invoice->invoice_date->quarter.'-'.$invoice->invoice_date->format('Y')]['outgoing'] += $item->amount;
                }
            }
        };

        // Get all unpaid and owed invoices
        $unpaidInvoices = Invoice::unpaid()->with('customer.customerDetail')->orderBy('due_date')->get();
        $owedInvoices = Invoice::owed()->with('customer.customerDetail')->orderBy('due_date')->get();

        return view('invoice.index', compact('unpaidInvoices', 'owedInvoices', 'stats'));

    }

    /**
     * Display all the invoices (incoming and outgoing)
     *
     * @return    \Illuminate\Http\Response
     */
    public function all()
    {

        // Get invoices based on paginate
        $invoices = Invoice::withoutIncoming()->orderBy('id', 'DESC')->paginate(10, ['*'], 'invoices');
        $incomingInvoices = Invoice::onlyIncoming()->orderBy('id', 'DESC')->paginate(10, ['*'], 'incoming_invoices');

        // Create an array of all 'outgoing' invoices
        $invoicesWithData = [];
        foreach($invoices as $invoice) {
            $invoicesWithData[] = ['id' => $invoice->id,
                                   'invoice_number' => $invoice->invoice_number,
                                   'customer' => Customer::effectiveDate($invoice->invoice_date)->find($invoice->customer_id)];
        }

        // Create an array of all 'incoming' invoices
        $incomingInvoicesWithData = [];
        foreach($incomingInvoices as $invoice) {
            $incomingInvoicesWithData[] = ['id' => $invoice->id,
                                           'invoice_number' => $invoice->invoice_number,
                                           'customer' => Customer::effectiveDate($invoice->invoice_date)->find($invoice->customer_id)];
        }

        return view('invoice.all', compact('invoices', 'invoicesWithData', 'incomingInvoices', 'incomingInvoicesWithData'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Get all customers and ongoing projects
        $customers = Customer::effectivedate(Carbon::now())->withoutIncoming()->get()->lists('customerDetail.name', 'id');
        $projects = Project::where('ongoing', 1)->lists('name', 'id')->toArray();
        $vat_rates = VatRate::lists('percentage', 'percentage')->toArray();

        // Add a % sign to every VAT-rate
        foreach($vat_rates as $key => $value) {
            $vat_rates[$key] = $value.'%';
        }

        $projects = array_add($projects, 0, trans('dam.invoice.no_project'));
        ksort($projects);

        return view('invoice.create', compact('customers', 'projects', 'vat_rates'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {

        // Create new invoice
        $invoice = new Invoice;
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_number = $this->generateInvoiceNumber($request->customer_id);
        $invoice->invoice_date = Carbon::createFromFormat('d-m-Y', $request->invoice['date'])->format('Y-m-d');
        $invoice->due_date = Carbon::createFromFormat('d-m-Y', $request->invoice['due_date'])->format('Y-m-d');
        $invoice->save();

        // Foreach items
        foreach($request->items as $item) {

            // Add item to invoice
            $invoice->addItem(
                new InvoiceItem($item)
            );

        }

        // Notify user and redirect to 'show'
        Session::flash('success', trans('dam.invoice.created'));
        return Redirect::action('InvoiceController@show', $invoice->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {

        $invoice->load(['items', 'customer' => function($query) use($invoice) {
            $query->effectiveDate($invoice->invoice_date);
        }]);

        return view('invoice.show', compact('invoice'));

    }

    /**
     * Generate a PDF-document
     *
     * @param     Invoice $invoice
     * @return    PDF
     */
    public function generatePDF(Invoice $invoice)
    {

        $invoice->load(['items', 'customer' => function($query) use($invoice) {
            $query->effectiveDate($invoice->invoice_date);
        }]);

        $company = Company::effectiveDate($invoice->invoice_date)->first();

        // Path to invoice template
        $pdfTemplate = 'pdf.invoice.'.$company->invoice_template;

        // Check if view exists.
        if(!view()->exists($pdfTemplate)) {
            return 'Invoice template not found.';
        }

        // return view($pdfTemplate, compact('invoice', 'company'));

        $pdf = PDF::loadView($pdfTemplate, compact('invoice', 'company'));
        return $pdf->stream($invoice->invoice_number.'.pdf');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {

        // If invoice is already paid, then the user can't edit.
        if($invoice->paid_date) {
            Session::flash('error', trans('dam.invoice.error.edit_already_paid'));
            return Redirect::action('InvoiceController@show', $invoice->id);
        }

        $invoice->load(['items', 'customer' => function($query) use ($invoice) {
            $query->effectiveDate($invoice->invoice_date);
        }]);

        $projects = Project::lists('name', 'id')->toArray();
        $vat = ['21' => '21%', '6' => '6%', '0' => '0%'];

        $projects = array_add($projects, 0, trans('dam.invoice.no_project'));
        ksort($projects);

        return view('invoice.edit', compact('invoice', 'customers', 'projects', 'vat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoiceUpdateRequest $request, Invoice $invoice)
    {

        $invoice->invoice_date = Carbon::createFromFormat('d-m-Y', $request->invoice['date'])->format('Y-m-d');
        $invoice->due_date = Carbon::createFromFormat('d-m-Y', $request->invoice['due_date'])->format('Y-m-d');
        $invoice->save();

        foreach($request->items as $id => $item) {

            $invoiceItem = InvoiceItem::find($id);

            // If no description is given, delete item and continue.
            if($invoiceItem && !strlen($item['description'])) {
                $invoiceItem->delete();
                continue;
            }

            // If item is found, update with new data
            if($invoiceItem) {
                $invoiceItem->update($item);
            }

            // Else, create it as a new item
            else {
                $invoice->addItem(
                    new InvoiceItem($item)
                );
            }

        }

        Session::flash('success', trans('dam.invoice.updated'));
        return Redirect::action('InvoiceController@show', $invoice->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Mark an invoice as paid.
     *
     * @param     Request $request
     * @param     Invoice $invoice
     * @return    \Illuminate\Http\Response
     */
    public function paid(Request $request, Invoice $invoice)
    {

        // Invoice must not already be paid
        if(!$invoice->paid_date) {

            // Set invoice as paid
            $invoice->paid_date = Carbon::createFromFormat('d-m-Y', $request->paid_date)->format('Y-m-d');
            $invoice->save();

            // Notify the user
            Session::flash('success', trans('dam.invoice.successfully_paid'));

        }

        // When invoice is already marked as paid
        else {

            // Notify the user
            Session::flash('error', trans('dam.invoice.error.already_paid'));

        }

        return Redirect::back();

    }

    /**
     * Generate an unique invoice number
     * Format: CurrentYear-CustomerNumber-IncrementInteger
     *
     * @param     int  $customer
     * @return    string
     */
    public static function generateInvoiceNumber($customer)
    {

        // Get current Year
        $currentYear = Carbon::now()->format('Y');

        // Get customer, with last invoice
        $customer = Customer::with(['invoices' => function($query) use ($currentYear) {
                                $query->whereYear('invoice_date', '=', $currentYear)
                                      ->orderBy('invoice_date', 'DESC')
                                      ->first();
                            }])
                            ->orderBy('id', 'DESC')
                            ->find($customer);

        // The invoice number starts
        $newInvoiceNumber[] = $currentYear;
        $newInvoiceNumber[] = $customer->customer_number;

        // Increment number if there's a invoice, otherwise start at 1
        if(count($customer->invoices)) {
            $lastInvoiceNumber = substr($customer->invoices[0]->invoice_number, -4);
            $newInvoiceNumber[] = sprintf('%04d', $lastInvoiceNumber + 1);
        } else {
            $newInvoiceNumber[] = sprintf('%04d', 1);
        }

        return join('-', $newInvoiceNumber);

    }

}
