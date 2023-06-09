<?php

namespace App\Http\Livewire\Components;

use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountType;
use App\Models\JournalEntry;
use Livewire\Component;

class Accountbalances extends Component
{
    protected $queryString = ['start_date', 'end_date'];

    public $start_date;

    public $end_date;

    public $accounts = [
        [
            'name' => 'Assets',
            'accounts' => [
                [
                    'name' => 'Cuenta',
                    'opening_balance' => 1000,
                    'debit' => 1000,
                    'credit' => 1000,
                    'net' => 1000,
                    'ending' => 1000,
                ],
                [
                    'name' => 'Cuenta 2',
                    'opening_balance' => 2000,
                    'debit' => 1000,
                    'credit' => 1000,
                    'net' => 1000,
                    'ending' => 1000,
                ],
            ],
        ],
        [
            'name' => 'Liabilities',
            'accounts' => [
                [
                    'name' => 'Cuenta 3',
                    'opening_balance' => 3000,
                    'debit' => 1000,
                    'credit' => 1000,
                    'net' => 1000,
                    'ending' => 1000,
                ],
                [
                    'name' => 'Cuenta 4',
                    'opening_balance' => 4000,
                    'debit' => 1000,
                    'credit' => 1000,
                    'net' => 1000,
                    'ending' => 1000,
                ],
            ],
        ],
    ];

    public function mount()
    {
        $this->start_date = now()->year.'-'.'01-01';
        $this->end_date = now()->year.'-'.'12-31';

        $this->search();
    }

    public function render()
    {
        return view('livewire.components.accountbalances')->extends('layouts.admin');
    }

    public function search()
    {
        //journal_items
        $accounts = ChartOfAccount::select('chart_of_accounts.id', 'chart_of_accounts.name', 'chart_of_accounts.type', 'chart_of_accounts.currency', 'chart_of_accounts.opening_balance', \DB::raw('(ifnull((select sum(amount) from revenues where created_by='.\Auth::user()->creatorId()." and account_id=chart_of_accounts.id and created_at between '$this->start_date' and '$this->end_date'),0)+ifnull((select sum(ip.amount) from invoice_payments as ip left join invoices as i on i.id=ip.invoice_id where i.created_by=".\Auth::user()->creatorId()." and ip.account_id=chart_of_accounts.id and ip.created_at between '$this->start_date' and '$this->end_date'),0)) as credit"), \DB::raw('(ifnull((select sum(amount) from payments where created_by='.\Auth::user()->creatorId()." and account_id=chart_of_accounts.id and created_at between '$this->start_date' and '$this->end_date'),0)+ifnull((select sum(bp.amount) from bill_payments as bp left join bills as b on b.id=bp.bill_id where b.created_by=".\Auth::user()->creatorId()." and bp.account_id=chart_of_accounts.id and bp.created_at between '$this->start_date' and '$this->end_date'),0)) as debit"))

        ->where('chart_of_accounts.created_by', \Auth::user()->creatorId())

        ->get()
        ->toArray();

        $types = ChartOfAccountType::whereCreatedBy(\Auth::user()->creatorId())->get(['id', 'name'])->toArray();

        $journals = JournalEntry::whereBetween('created_at', [$this->start_date, $this->end_date])->whereCreatedBy(\Auth::user()->creatorId())->get();

        foreach ($accounts as $key => $ac) {
            $debit = 0;
            $credit = 0;
            foreach ($journals as $jj) {
                foreach ($jj->accounts as $j) {
                    if ($j->account == $ac['id']) {
                        $debit += $j->debit;
                        $credit += $j->credit;
                    }
                }
            }
            $accounts[$key]['debit'] += $debit;
            $accounts[$key]['credit'] += $credit;
        }

        foreach ($types as $key => $tt) {
            $types[$key]['accounts'] = array_filter($accounts, function ($val) use ($tt) {
                return $val['type'] == $tt['id'];
            });

            $types[$key]['totalopening'] = 0;
            $types[$key]['totalcredit'] = 0;
            $types[$key]['totaldebit'] = 0;
            $types[$key]['totalnet'] = 0;
            $types[$key]['totalfinal'] = 0;

            switch ($tt['name']) {
                case 'Assets':
                    foreach ($types[$key]['accounts'] as $keyx => $accs) {
                        $types[$key]['accounts'][$keyx]['net'] = $accs['debit'] - $accs['credit'];
                        $types[$key]['accounts'][$keyx]['final'] = $types[$key]['accounts'][$keyx]['net'] + $types[$key]['accounts'][$keyx]['opening_balance'];

                        $types[$key]['totalopening'] += $types[$key]['accounts'][$keyx]['opening_balance'];
                        $types[$key]['totalcredit'] += $types[$key]['accounts'][$keyx]['credit'];
                        $types[$key]['totaldebit'] += $types[$key]['accounts'][$keyx]['debit'];
                        $types[$key]['totalnet'] += $types[$key]['accounts'][$keyx]['net'];
                        $types[$key]['totalfinal'] += $types[$key]['accounts'][$keyx]['final'];
                    }
                    break;
                case 'Liabilities':
                    foreach ($types[$key]['accounts'] as $keyx => $accs) {
                        $types[$key]['accounts'][$keyx]['net'] = $accs['credit'] - $accs['debit'];
                        $types[$key]['accounts'][$keyx]['final'] = $types[$key]['accounts'][$keyx]['net'] + $types[$key]['accounts'][$keyx]['opening_balance'];

                        $types[$key]['totalopening'] += $types[$key]['accounts'][$keyx]['opening_balance'];
                        $types[$key]['totalcredit'] += $types[$key]['accounts'][$keyx]['credit'];
                        $types[$key]['totaldebit'] += $types[$key]['accounts'][$keyx]['debit'];
                        $types[$key]['totalnet'] += $types[$key]['accounts'][$keyx]['net'];
                        $types[$key]['totalfinal'] += $types[$key]['accounts'][$keyx]['final'];
                    }
                    break;
                case 'Income':
                    foreach ($types[$key]['accounts'] as $keyx => $accs) {
                        $types[$key]['accounts'][$keyx]['net'] = $accs['credit'] - $accs['debit'];
                        $types[$key]['accounts'][$keyx]['final'] = $types[$key]['accounts'][$keyx]['net'] + $types[$key]['accounts'][$keyx]['opening_balance'];

                        $types[$key]['totalopening'] += $types[$key]['accounts'][$keyx]['opening_balance'];
                        $types[$key]['totalcredit'] += $types[$key]['accounts'][$keyx]['credit'];
                        $types[$key]['totaldebit'] += $types[$key]['accounts'][$keyx]['debit'];
                        $types[$key]['totalnet'] += $types[$key]['accounts'][$keyx]['net'];
                        $types[$key]['totalfinal'] += $types[$key]['accounts'][$keyx]['final'];
                    }
                    break;
                case 'Expenses':
                    foreach ($types[$key]['accounts'] as $keyx => $accs) {
                        $types[$key]['accounts'][$keyx]['net'] = $accs['debit'] - $accs['credit'];
                        $types[$key]['accounts'][$keyx]['final'] = $types[$key]['accounts'][$keyx]['net'] + $types[$key]['accounts'][$keyx]['opening_balance'];

                        $types[$key]['totalopening'] += $types[$key]['accounts'][$keyx]['opening_balance'];
                        $types[$key]['totalcredit'] += $types[$key]['accounts'][$keyx]['credit'];
                        $types[$key]['totaldebit'] += $types[$key]['accounts'][$keyx]['debit'];
                        $types[$key]['totalnet'] += $types[$key]['accounts'][$keyx]['net'];
                        $types[$key]['totalfinal'] += $types[$key]['accounts'][$keyx]['final'];
                    }
                    break;
                case 'Equity':
                    foreach ($types[$key]['accounts'] as $keyx => $accs) {
                        $types[$key]['accounts'][$keyx]['net'] = $accs['credit'] - $accs['debit'];
                        $types[$key]['accounts'][$keyx]['final'] = $types[$key]['accounts'][$keyx]['net'] + $types[$key]['accounts'][$keyx]['opening_balance'];

                        $types[$key]['totalopening'] += $types[$key]['accounts'][$keyx]['opening_balance'];
                        $types[$key]['totalcredit'] += $types[$key]['accounts'][$keyx]['credit'];
                        $types[$key]['totaldebit'] += $types[$key]['accounts'][$keyx]['debit'];
                        $types[$key]['totalnet'] += $types[$key]['accounts'][$keyx]['net'];
                        $types[$key]['totalfinal'] += $types[$key]['accounts'][$keyx]['final'];
                    }
                    break;
            }
        }

        //dd($types);

        $this->accounts = $types;
    }
}
