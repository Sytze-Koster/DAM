<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = ['customer_number', 'only_incoming'];
    protected $dates = ['effective_date'];

    function customerDetail()
    {
        return $this->hasOne('App\CustomerDetail');
    }

    function customerDetails()
    {
        return $this->hasMany('App\CustomerDetail');
    }

    function projects()
    {
        return $this->hasMany('App\Project');
    }

    function ongoingProjects()
    {
        return $this->hasMany('App\Project')->where('ongoing', 1);
    }

    function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    public static function scopeEffectiveDate($query, \Carbon\Carbon $date)
    {
        return $query->with(['customerDetail' => function($query2) use($date) {
            $query2->where('effective_date', '<=', $date)->orderBy('id', 'DESC');
        }]);
    }

    public function addDetail(CustomerDetail $customerDetail)
    {
        return $this->customerDetail()->save($customerDetail);
    }

    public function scopeWithoutIncoming($query)
    {
        return $query->where('only_incoming', 0);
    }

}
