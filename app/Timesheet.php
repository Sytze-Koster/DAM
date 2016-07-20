<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable = ['description', 'start', 'end', 'in_progress'];
    protected $dates = ['start', 'end'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function timeSpent($readable = false)
    {
        $seconds = 0;
        if(!$this->in_progress) {
            $seconds = $this->start->diffInSeconds($this->end);
        }

        if ($readable) {
            $h = floor($seconds / 3600);
            $i = ($seconds / 60) % 60;
            return sprintf("%02d:%02d", $h, $i);
        }

        return $seconds;
    }

}
