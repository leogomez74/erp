<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'issue_date',
        'due_date',
        'ref_number',
        'status',
        'category_id',
        'created_by',
    ];

    public static $statues = [
        'Draft',
        'Sent',
        'Unpaid',
        'Partialy Paid',
        'Paid',
        'Expired',
    ];

    public function tax()
    {
        return $this->hasOne(\App\Models\Tax::class, 'id', 'tax_id');
    }

    public function items()
    {
        return $this->hasMany(\App\Models\InvoiceProduct::class, 'invoice_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(\App\Models\InvoicePayment::class, 'invoice_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne(\App\Models\Customer::class, 'id', 'customer_id');
    }

    public function getSubTotal()
    {
        $subTotal = 0;
        foreach ($this->items as $product) {
            $subTotal += ($product->price * $product->quantity);
        }

        return $subTotal;
    }

    public function getTotalTax()
    {
        $totalTax = 0;
        foreach ($this->items as $product) {
            $taxes = Utility::totalTaxRate($product->tax);

            $totalTax += ($taxes / 100) * ($product->price * $product->quantity);
        }

        return $totalTax;
    }

    public function getTotalDiscount()
    {
        $totalDiscount = 0;
        foreach ($this->items as $product) {
            $totalDiscount += $product->discount;
        }

        return $totalDiscount;
    }

    public function getTotal()
    {
        return ($this->getSubTotal() + $this->getTotalTax()) - $this->getTotalDiscount();
    }

    public function getDue()
    {
        $due = 0;
        foreach ($this->payments as $payment) {
            $due += $payment->amount;
        }

        return ($this->getTotal() - $due) - $this->invoiceTotalCreditNote();
    }

    public static function change_status($invoice_id, $status)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice->status = $status;
        $invoice->update();
    }

    public function category()
    {
        return $this->hasOne(\App\Models\ProductServiceCategory::class, 'id', 'category_id');
    }

    public function creditNote()
    {
        return $this->hasMany(\App\Models\CreditNote::class, 'invoice', 'id');
    }

    public function invoiceTotalCreditNote()
    {
        return $this->hasMany(\App\Models\CreditNote::class, 'invoice', 'id')->sum('amount');
    }

    public function lastPayments()
    {
        return $this->hasOne(\App\Models\InvoicePayment::class, 'id', 'invoice_id');
    }

    public function taxes()
    {
        return $this->hasOne(\App\Models\Tax::class, 'id', 'tax');
    }
}
