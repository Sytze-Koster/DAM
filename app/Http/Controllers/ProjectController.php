<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests;
use App\Http\Requests\ProjectRequest;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;
use Session;

class ProjectController extends Controller
{

    public function __construct()
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
        $projects = Project::where('ongoing', 1)->get();
        return view('project.index', compact('projects'));
    }

    public function archivedProjects()
    {
        $projects = Project::where('ongoing', 0)->get();
        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $customers = Customer::effectivedate(Carbon::now())->get()->pluck('customerDetail.name', 'id');
      return view('project.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->all());
        return Redirect::action('ProjectController@show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $project->load(['timesheets' => function($query) {
            $query->where('in_progress', 0);
        }, 'invoices']);

        // Get Customer Data
        $customer = Customer::effectivedate($project->ongoing ? Carbon::now() : $project->archived_at)->find($project->customer_id);

        $stats = [];
        if(count($project->timesheets)) {

            // Generate all weeks. Starting at the first timesheet notation untill the last.
            for($date = $project->timesheets->first()->start->startOfWeek(); $date->lte($project->timesheets->last()->end->startOfWeek()); $date->addWeek()) {
                $stats[$date->startOfWeek()->format('d-m')] = 0;
            }

            // Add the worked hours to the weeks.
            foreach($project->timesheets as $sheet) {
                if(!$sheet->in_progress) {
                    $stats[$sheet->start->startOfWeek()->format('d-m')] += $sheet->start->diffInSeconds($sheet->end) / 3600;
                }
            }

            // 😒 We need this to convert decimals (,) to (.) if locale is set to nl_NL
            foreach($stats as $key => $value) {
                $stats[$key] = (string) number_format($value, 2);
            }

        }

        return view('project.show', compact('project', 'timeSum', 'stats', 'customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $customers = Customer::effectivedate(Carbon::now())->get()->pluck('customerDetail.name', 'id');
        return view('project.edit', compact('project', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->all());
        $project->save();

        Session::flash('success', trans('dam.project.updated'));
        return Redirect::action('ProjectController@show', $project->id);
    }

    /**
     * Archive or reopen a project
     *
     * @param     Project $project
     * @return    \Illuminate\Http\Response
     */
    public function archive(Project $project)
    {

        if($project->ongoing) {
            $project->archive();
            Session::Flash('success', trans('dam.project.archived'));
        } else {
            $project->reopen();
            Session::Flash('success', trans('dam.project.reopened'));
        }

        return Redirect::action('ProjectController@show', $project->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        $project->destroy();

        Session::Flash('success', trans('dam.project.destroyed'));

        return Redirect::action('ProjectController@index');

    }

}
