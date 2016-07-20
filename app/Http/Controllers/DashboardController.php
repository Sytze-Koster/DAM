<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Invoice;
use App\Project;
use App\Timesheet;
use Illuminate\Http\Request;
use PDF;

class DashboardController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return    Illuminate\Http\Request
     */
    public function index()
    {

        $projects = Project::where('ongoing', 1)->get()->lists('name', 'id');
        $inProgress = Timesheet::where('end', '0000-00-00 00:00:00')->with('project')->get();
        $invoices = Invoice::unpaid()->with('customer.customerDetail')->orderBy('due_date')->get();

        return view('dashboard.index', compact('projects', 'inProgress', 'invoices'));

    }

}
