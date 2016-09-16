<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\TimesheetRequest;
use App\Project;
use App\Timesheet;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;
use Session;

class TimesheetController extends Controller
{

    /**
     * Constructor
     *
     **/
    function __construct()
    {
        return $this->middleware('auth', ['except' => 'showForCustomer']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $project->load('timesheets');
        return view('timesheet.index', compact('project'));
    }

    /**
     * undocumented function
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     **/
    public function showForCustomer($id)
    {
        $project = Project::where('share_id', $id)->with('timesheets')->firstOrFail();

        if(!$project) {
            abort(404);
        }

        return view('timesheet.showForCustomer', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimesheetRequest $request, Project $project)
    {

        // Convert dates to Carbon-datestamps
        $startdate = Carbon::createFromFormat('d-m-Y H:i', $request->start_date.' '.$request->start_time);
        $enddate = Carbon::createFromFormat('d-m-Y H:i', $request->end_date.' '.$request->end_time);

        // Add dates to array, then remove individual dates and times
        $timesheet = array_collapse([$request->all(), ['start' => $startdate, 'end' => $enddate]]);
        array_forget($timesheet, ['start_date', 'start_time', 'end_date', 'end_time']);

        if(Carbon::now()->lt($startdate)) {
            $timesheet['created_at'] = $startdate;
        }

        // Add Timesheet to project
        $project->addTimesheet(
            new Timesheet($timesheet)
        );

        // Maybe we've to notify the user.
        $this->checkForNotify($project);

        // Notify user and redirect back
        Session::flash('success', trans('dam.timesheet.stored'));
        return back();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Timesheet  $timesheet
     * @return \Illuminate\Http\Response
     **/
    public function edit(Timesheet $timesheet)
    {

        if($timesheet->in_progress) {
            Session::flash('error', trans('dam.timesheet.cannot_edit'));
            return Redirect::action('TimesheetController@index', $timesheet->project_id);
        }

        // Get projects
        $projects = Project::where('ongoing', 1)->pluck('name', 'id');

        return view('timesheet.edit', compact('timesheet', 'projects'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Timesheet $timesheet)
    {

        // Convert single fields to 1 datetime string
        $startdate = Carbon::createFromFormat('d-m-Y H:i', $request->start_date.' '.$request->start_time);
        $enddate = Carbon::createFromFormat('d-m-Y H:i', $request->end_date.' '.$request->end_time);

        $timesheet->update(array_collapse([$request->all(), ['start' => $startdate, 'end' => $enddate]]));

        // Notify the user
        Session::flash('success', trans('dam.timesheet.updated'));

        // Redirect to timesheets
        return Redirect::action('TimesheetController@index', $timesheet->project_id);

    }

    public function startTime(Request $request)
    {

        // Start time to nearest 5, 10, 15, 20, ..
        $now = Carbon::now()->second(0);
        while($now->format('i') % 5) {
            $now = $now->subMinute(1);
        }

        // Create timesheet
        $timesheet = new Timesheet;
        $timesheet->start = $now;
        $timesheet->project_id = $request->project_id;
        $timesheet->in_progress = 1;
        $timesheet->save();

        // Notify user and redirect back
        Session::flash('success', trans('dam.timesheet.started'));
        return back();

    }

    public function endTime(TimesheetRequest $request, Timesheet $timesheet)
    {

        // Set and save fields
        $timesheet->description = $request->description;
        $timesheet->start = Carbon::createFromFormat('d-m-Y H:i', $request->start_date.' '.$request->start_time);
        $timesheet->end = Carbon::createFromFormat('d-m-Y H:i', $request->end_date.' '.$request->end_time);
        $timesheet->in_progress = 0;

        $timesheet->save();

        // Maybe we've to notify the user.
        $this->checkForNotify($timesheet->project);

        // Notify user and redirect back
        Session::flash('success', trans('dam.timesheet.stored'));
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Timesheet  $timesheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timesheet $timesheet)
    {

        // Delete timesheet
        $timesheet->delete();

        // Notify the user
        Session::flash('success', trans('dam.timesheet.destroyed'));

        // Redirect back
        return Redirect::action('TimesheetController@index', $timesheet->project_id);

    }

    /**
     * Check if the user needs to receive a notification
     * if so, send a notification.
     *
     * @param  Project  $project
     * @return bool
     */
    private function checkForNotify(Project $project)
    {

        // If notify_after is NOT 0 and 'time spent' is equal or greater then 'notify_after'...
        if($project->notify_after != 0 && (($project->timeSpent() / 60) / 60) >= $project->notify_after) {
            Auth::user()->notify(new \App\Notifications\TimesheetNotification($project));
            return true;
        }

        return false;

    }

}
