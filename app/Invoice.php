<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $dates = ['invoice_date', 'due_date', 'paid_date', 'created_at', 'updated_at'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function items()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    public function addItem(InvoiceItem $invoiceitem)
    {

        // Archive project if item is linked to project.
        if($invoiceitem['project_id'] > 0) {
            Project::findOrFail($invoiceitem['project_id'])->archive();
        }

        return $this->items()->save($invoiceitem);

    }

    public static function unpaid()
    {
        return static::whereNull('paid_date')->where('is_incoming', 0);
    }

    public static function owed()
    {
        return static::whereNull('paid_date')->where('is_incoming', 1);
    }

    public static function onlyIncoming()
    {
        return static::where('is_incoming', 1);
    }

    public static function withoutIncoming()
    {
        return static::where('is_incoming', 0);
    }

    public function totals($kind)
    {
        // Create empty variables
        $vat = [];
        $totalSub = 0;
        $totalDue = 0;

        // Foreach items in invoice
        foreach($this->items as $item) {

            // If this VAT-rate doesn't exist, create it.
            if(!isset($vat[$item->vat_rate])) {
                $vat[$item->vat_rate]['AmountOfVat'] = 0;
                $vat[$item->vat_rate]['CalculatedOver'] = 0;
            }

            // Add Amount of VAT to array
            $vat[$item->vat_rate]['AmountOfVat'] += $item->AmountOfVAT();
            $vat[$item->vat_rate]['CalculatedOver'] += $item->amount;

            // Add amounts to Total Amounts
            $totalSub += $item->amount;
            $totalDue += $item->AmountIncVAT();

        }

        if($kind == 'vat') {
            return $vat;
        } elseif($kind == 'sub') {
            return $totalSub;
        } elseif($kind == 'due') {
            return $totalDue;
        }

    }

    public function numberOfVATRates()
    {

        $rates = [];

        foreach($this->items as $item) {
            $rates[$item->vat_rate] = 0;
        }

        return count($rates);

    }

}
