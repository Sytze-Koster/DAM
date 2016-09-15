<?php

namespace App\Http\Controllers;

use \Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancialOverviewController extends Controller
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

        $firstInvoice = Invoice::orderBy('invoice_date', 'ASC')->first();

        $dates = [];

        // Calculate of the're invoices
        if($firstInvoice) {
            for($i = $firstInvoice->invoice_date; $i < Carbon::now(); $i->addMonth()) {
                $dates[$i->year][$i->quarter][$i->month] = $i->formatLocalized('%B');
                krsort($dates[$i->year][$i->quarter]);
                krsort($dates[$i->year]);
            }
            krsort($dates);
        }

        return view('financial_overview.index', compact('dates'));

    }

    /**
     * Show all invoices in a given year.
     *
     * @param     Int $year
     * @return    @return \Illuminate\Http\Response
     */
    public function yearOverview(Int $year)
    {

        $outgoingInvoices = Invoice::withoutIncoming()->whereYear('invoice_date', '=', $year)->get();
        $outgoingTotals = $this->calculateSuperTotals($outgoingInvoices);

        $incomingInvoices = Invoice::onlyIncoming()->whereYear('invoice_date', '=', $year)->get();
        $incomingTotals = $this->calculateSuperTotals($incomingInvoices);

        return view('financial_overview.overview', compact('outgoingInvoices', 'outgoingTotals', 'incomingInvoices', 'incomingTotals'));

    }

    /**
     * Show all invoices in a given quarter.
     *
     * @param     Int $year
     * @param     Int $quarter
     * @return    @return \Illuminate\Http\Response
     */
    public function quarterOverview(Int $year, Int $quarter)
    {

        $firstDayOfQuarter = Carbon::createFromDate($year, ($quarter * 3) - 2, 1)->startOfDay();
        $lastDayOfQuarter = Carbon::createFromDate($year, ($quarter * 3) - 2, 1)->lastOfQuarter()->endOfDay();

        $outgoingInvoices = Invoice::withoutIncoming()
                                    ->whereDate('invoice_date', '>=', $firstDayOfQuarter)
                                    ->whereDate('invoice_date', '<=', $lastDayOfQuarter)
                                    ->get();
        $outgoingTotals = $this->calculateSuperTotals($outgoingInvoices);

        $incomingInvoices = Invoice::onlyIncoming()
                                    ->whereDate('invoice_date', '>=', $firstDayOfQuarter)
                                    ->whereDate('invoice_date', '<=', $lastDayOfQuarter)
                                    ->get();
        $incomingTotals = $this->calculateSuperTotals($incomingInvoices);

        return view('financial_overview.overview', compact('outgoingInvoices', 'outgoingTotals', 'incomingInvoices', 'incomingTotals'));
    }

    /**
     * Show all invoices in a given month.
     *
     * @param     Int $year
     * @param     Int $month
     * @return    @return \Illuminate\Http\Response
     */
    public function monthOverview($year, $month)
    {

        $firstDayOfMonth = Carbon::createFromDate($year, $month, 1)->startOfDay();
        $lastDayOfMonth = Carbon::createFromDate($year, $month, 1)->lastOfMonth()->endOfDay();

        $outgoingInvoices = Invoice::withoutIncoming()
                                    ->whereDate('invoice_date', '>=', $firstDayOfMonth)
                                    ->whereDate('invoice_date', '<=', $lastDayOfMonth)
                                    ->get();
        $outgoingTotals = $this->calculateSuperTotals($outgoingInvoices);

        $incomingInvoices = Invoice::onlyIncoming()
                                    ->whereDate('invoice_date', '>=', $firstDayOfMonth)
                                    ->whereDate('invoice_date', '<=', $lastDayOfMonth)
                                    ->get();
        $incomingTotals = $this->calculateSuperTotals($incomingInvoices);

        return view('financial_overview.overview', compact('outgoingInvoices', 'outgoingTotals', 'incomingInvoices', 'incomingTotals'));

    }

    /**
     * Calculate the totals of multiple invoices.
     *
     * @param     \Eloquent\Collection $invoices
     * @return    Array
     */
    private function calculateSuperTotals(Collection $invoices) {

        $totals = ['sub' => 0,
                   'due' => 0,
                   'vat' => []];

        // Foreach all invoices to calculate totals
        foreach($invoices as $invoice) {

            // Add subtotal and duetotal to totals
            $totals['sub'] += $invoice->totals('sub');
            $totals['due'] += $invoice->totals('due');

            // Foreach VAT-array
            foreach($invoice->totals('vat') as $vatPercentage => $calculated) {

                // If variable doesn't exist at this moment, create them.
                if(!isset($totals['vat'][$vatPercentage]['AmountOfVat'])) {
                    $totals['vat'][$vatPercentage]['AmountOfVat'] = 0;
                    $totals['vat'][$vatPercentage]['CalculatedOver'] = 0;
                }

                // Add VAT-values to totals.
                $totals['vat'][$vatPercentage]['AmountOfVat'] += $calculated['AmountOfVat'];
                $totals['vat'][$vatPercentage]['CalculatedOver'] += $calculated['CalculatedOver'];

            }

        }

        return $totals;

    }

}
