<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'sub_type',
        'is_enabled',
        'description',
        'created_by',
        'currency',
        'opening_balance',
    ];

    public function types()
    {
        return $this->hasOne(\App\Models\ChartOfAccountType::class, 'id', 'type');
    }

    public function types_account($id = null)
    {
        return ChartOfAccount::select('name')->where('id', $id)->first();
    }

    public function accounts()
    {
        return $this->hasOne(\App\Models\JournalItem::class, 'account', 'id');
    }

    public function balance()
    {
        $journalItem = JournalItem::select(\DB::raw('sum(credit) as totalCredit'), \DB::raw('sum(debit) as totalDebit'), \DB::raw('sum(credit) - sum(debit) as netAmount'))->where('account', $this->id);
        $journalItem = $journalItem->first();
        $data['totalCredit'] = $journalItem->totalCredit;
        $data['totalDebit'] = $journalItem->totalDebit;
        $data['netAmount'] = $journalItem->netAmount;

        return $data;
    }

    public function subType()
    {
        return $this->hasOne(\App\Models\ChartOfAccountSubType::class, 'id', 'sub_type');
    }

    public function transaction()
    {
        return $this->hasOne(\App\Models\Transaction::class, 'account', 'id');
    }

    public function incomeCategoryRevenueAmount()
    {
        $year = date('Y');

        $revenue = $this->hasMany(\App\Models\Revenue::class, 'account_id', 'id')->where('created_by', \Auth::user()->creatorId())->whereRAW('YEAR(date) =?', [$year])->sum('amount');
        $invoices = $this->hasMany(\App\Models\Invoice::class, 'category_id', 'id')->where('created_by', \Auth::user()->creatorId())->whereRAW('YEAR(send_date) =?', [$year])->get();
        $invoiceArray = [];
        foreach ($invoices as $invoice) {
            $invoiceArray[] = $invoice->getTotal();
        }
        $totalIncome = (! empty($revenue) ? $revenue : 0) + (! empty($invoiceArray) ? array_sum($invoiceArray) : 0);

        return $totalIncome;
    }

    public function expenseCategoryAmount()
    {
        $year = date('Y');
        $payment = $this->hasMany(\App\Models\Payment::class, 'account_id', 'id')->where('created_by', \Auth::user()->creatorId())->whereRAW('YEAR(date) =?', [$year])->sum('amount');

        $bills = $this->hasMany(\App\Models\Bill::class, 'category_id', 'id')->where('created_by', \Auth::user()->creatorId())->whereRAW('YEAR(send_date) =?', [$year])->get();
        $billArray = [];
        foreach ($bills as $bill) {
            $billArray[] = $bill->getTotal();
        }

        $totalExpense = (! empty($payment) ? $payment : 0) + (! empty($billArray) ? array_sum($billArray) : 0);

        return $totalExpense;
    }
}
