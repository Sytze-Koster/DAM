<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $table = 'company';
    protected $fillable = ['name', 'address', 'postal_code', 'city', 'phone_number', 'email_address', 'website', 'chamber_of_commerce', 'vat_number', 'bank_account_number', 'invoice_template', 'effective_date'];
    protected $dates = ['effective_date'];

    public function setEffectiveDateAttribute($value)
    {
        $this->attributes['effective_date'] = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $value);
    }

    public function scopeEffectiveDate($query, \Carbon\Carbon $date) {
        return $query->where('effective_date', '<=', $date)->orderBy('id', 'DESC');
    }

}
