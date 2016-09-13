<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\TimesheetRequest;
use App\Project;
use App\Timesheet;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class TimesheetController extends Controller
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
    public function index(Project $project)
    {
        $project->load('timesheets');
        return view('timesheet.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
     * Check if the user needs to receive a notification
     * if so, send a notification.
     *
     * @param  Project  $project
     * @return bool
     */
    private function checkForNotify(Project $project)
    {

        // If notify_after is NOT 0 and
        if($project->notify_after != 0 && $project->timeSpent() >= $project->notify_after) {
            Auth::user()->notify(new \App\Notifications\TimesheetNotification($project));
            return true;
        }

        return false;

    }

}
