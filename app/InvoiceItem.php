<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = ['project_id', 'description', 'vat_rate', 'amount'];

    function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    function project()
    {
        return $this->belongsTo('App\Project');
    }

    function AmountIncVAT()
    {
        return $this->amount + $this->AmountOfVAT();
    }

    function AmountOfVAT()
    {
        return $this->amount * ($this->vat_rate / 100);
    }



}
