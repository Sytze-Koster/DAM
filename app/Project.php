<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = ['name', 'description', 'customer_id'];
    protected $dates = ['created_at', 'updated_at', 'archived_at'];

    public function timesheets()
    {
        return $this->hasMany('App\Timesheet');
    }

    public function addTimesheet(Timesheet $timesheet)
    {
        return $this->timesheets()->save($timesheet);
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function invoices()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    public function timeSpent($readable = false)
    {
        $seconds = 0;
        foreach($this->timesheets as $sheet) {
            if(!$sheet->in_progress) {
                $seconds += $sheet->start->diffInSeconds($sheet->end);
            }
        }

        if ($readable) {
            $h = floor($seconds / 3600);
            $i = ($seconds / 60) % 60;
            return sprintf("%02d:%02d", $h, $i);
        }

        return $seconds;

    }

    public function archive()
    {
        $this->archived_at = \Carbon\Carbon::now();
        $this->ongoing = false;
        return $this->update();
    }

    public function reopen()
    {
        $this->archived_at = NULL;
        $this->ongoing = true;
        return $this->update();
    }

}
