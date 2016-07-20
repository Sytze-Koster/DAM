<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{

    protected $fillable = ['name', 'address', 'postal_code', 'city', 'chamber_of_commerce', 'vat_number', 'contact_person', 'email_address', 'effective_date', 'phone_number'];
    protected $dates = ['effective_date'];

    function getEffectiveDateAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y');
    }

    function setEffectiveDateAttribute($value)
    {
        $this->attributes['effective_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
