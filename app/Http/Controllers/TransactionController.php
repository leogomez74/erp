<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\ChartOfAccount;
use App\Models\Customer;
use App\Models\ProductServiceCategory;
use App\Models\Transaction;
use App\Models\Vender;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(Request $request)
    {

        if(\Auth::user()->can('manage transaction'))
        {

            $filter['account']  = __('All');
            $filter['customer']  = __('All');
            $filter['vender']  = __('All');
            $filter['category'] = __('All');

            $account = ChartOfAccount::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $account->prepend('All Accounts', '');
            $accounts = Transaction::select('chart_of_accounts.id', 'chart_of_accounts.name','chart_of_accounts.opening_balance')
                                   ->leftjoin('chart_of_accounts', 'transactions.account', '=', 'chart_of_accounts.id')
                                   ->groupBy('transactions.account')->selectRaw('sum(amount) as total');

            $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->whereIn(
                'type', [
                          1,
                          2,
                      ]
            )->get()->pluck('name', 'name');

            $category->prepend('Invoice', 'Invoice');
            $category->prepend('Bill', 'Bill');
            $category->prepend('Select Category', '');

            $transactions = Transaction::orderBy('id', 'desc')->with('accounts');

            $customer= Customer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $customer->prepend('All Customers', '');

            $vender= Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $vender->prepend('All Venders', '');

            if(!empty($request->start_month) && !empty($request->end_month))
            {
                $start = strtotime($request->start_month);
                $end   = strtotime($request->end_month);
            }
            else
            {
                $start = strtotime(date('Y-m-d'));
                $end   = strtotime(date('Y-m-d', strtotime("+1 month")));
            }
            $currentdate = $start;


                $data['starting_date'] = date('Y-m-d', $start);
                $data['ending_date'] = date('Y-m-d', $end);

            if(!empty($request->start_month) && !empty($request->end_month)) {
                $transactions->where('date', '>=', $data['starting_date'])->where('date', '<=', $data['ending_date']);
            }
//                $currentdate = strtotime('+1 month', $currentdate);


            $filter['startDateRange'] = date('d-m-Y', $start);
            $filter['endDateRange']   = date('d-m-Y', $end);

            if(!empty($request->account))
            {
                $transactions->where('account', $request->account);

                if($request->account == 'strip-paypal')
                {
                    $accounts->where('account', 0);
                    $filter['account'] = __('Stripe / Paypal');
                }
                else
                {
                    $accounts->where('account', $request->account);
                    $bankAccount       = BankAccount::find($request->account);
                    $filter['account'] = !empty($bankAccount) ? $bankAccount->holder_name . ' - ' . $bankAccount->bank_name : '';
//                    if($bankAccount->holder_name == 'Cash')
//                    {
//                        $filter['account'] = 'Cash';
//                    }
                }

            }
            if(!empty($request->category))
            {
                $transactions->where('category', $request->category);
                $accounts->where('category', $request->category);

                $filter['category'] = $request->category;
            }
            if(!empty($request->customer))
            {

                $transactions->where('user_id', $request->customer)->Where('user_type','Customer');
                $filter['customer'] = $request->customer;
            }
            if(!empty($request->vender))
            {
                $transactions->where('user_id', $request->vender)->Where('user_type','Vender');
                $filter['vender'] = $request->vender;
            }

            $transactions->where('created_by', '=', \Auth::user()->creatorId());
            $accounts->where('transactions.created_by', '=', \Auth::user()->creatorId());
            $transactions = $transactions->get();
            $accounts     = $accounts->get();
            $trc=array();
            foreach ($accounts as $key => $accountx){
                $debit = 0;
                $credit = 0;

                foreach ($transactions as $trans){

                    if ($trans->account == $accountx['id']){
                        $trc[$accountx['name']]['transactions'][]=$trans;
                        if ($trans->type=='Revenue'||$trans->type=='Partial'){
                            $credit+=$trans->amount;
                        }
                        if ($trans->type=='Payment'){
                            $debit+=$trans->amount;
                        }
                        $trc[$accountx['name']]['debit']=$debit;
                        $trc[$accountx['name']]['credit']=$credit;
                        $trc[$accountx['name']]['opening_balance']=$accountx->opening_balance;

                    }
                }
//                $transactions[$key]['debit'] += $debit;
//                $transactions[$key]['credit'] += $credit;
            }

            $transactions = $trc;

            return view('transaction.index', compact('transactions', 'account', 'category', 'filter', 'accounts','customer','vender'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


}
