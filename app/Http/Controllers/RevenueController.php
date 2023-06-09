<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountType;
//use App\Models\Mail\InvoicePaymentCreate;
use App\Models\Customer;
use App\Models\InvoicePayment;
use App\Models\ProductServiceCategory;
use App\Models\Revenue;
use App\Models\Transaction;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        if (\Auth::user()->can('manage revenue')) {
            $customer = Customer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $customer->prepend('Select Customer', '');

            //$account = BankAccount::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('holder_name', 'id');
            //$account   = \DB::table("chart_of_accounts as c")->select("c.*")->join("chart_of_account_types as ct","c.type","=","ct.id")->where("ct.name","Assets")->where('c.created_by', '=', \Auth::user()->creatorId())->get()->pluck("name","id");
            $types = ChartOfAccountType::where('created_by', '=', \Auth::user()->creatorId())->get();
            foreach ($types as $type) {
                if ($type->name == 'Income') {
                    $income = ChartOfAccount::where('type', $type->id)->where('created_by', '=', \Auth::user()->creatorId())->get();
                }
                if ($type->name == 'Liabilities') {
                    $liability = ChartOfAccount::where('type', $type->id)->where('created_by', '=', \Auth::user()->creatorId())->get();
                }
            }
            $account = $income->merge($liability)->pluck('name', 'id');
            $category = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 1)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');

            $query = Revenue::where('created_by', '=', \Auth::user()->creatorId());

            if (! empty($request->date)) {
                $date_range = explode(' to ', $request->date);
                $query->whereBetween('date', $date_range);
            }

            if (! empty($request->customer)) {
                $query->where('id', '=', $request->customer);
            }
            if (! empty($request->account)) {
                $query->where('account_id', '=', $request->account);
            }
            if (! empty($request->category)) {
                $query->where('category_id', '=', $request->category);
            }

            if (! empty($request->payment)) {
                $query->where('payment_method', '=', $request->payment);
            }

            $revenues = $query->get();

            return view('revenue.index', compact('revenues', 'customer', 'account', 'category'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create revenue')) {
            $customers = Customer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $customers->prepend('--', 0);
            $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 1)->get()->pluck('name', 'id');
            //$accounts   = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' ',holder_name) AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            //$accounts   = \DB::table("chart_of_accounts as c")->select("c.*")->join("chart_of_account_types as ct","c.type","=","ct.id")->where("ct.name","Assets")->where('c.created_by', '=', \Auth::user()->creatorId())->get()->pluck("name","id");
            $types = ChartOfAccountType::where('created_by', '=', \Auth::user()->creatorId())->get();
            foreach ($types as $type) {
                if ($type->name == 'Income') {
                    $income = ChartOfAccount::where('type', $type->id)->where('created_by', '=', \Auth::user()->creatorId())->get();
                }
                if ($type->name == 'Liabilities') {
                    $liability = ChartOfAccount::where('type', $type->id)->where('created_by', '=', \Auth::user()->creatorId())->get();
                }
            }
            $accounts = $income->merge($liability)->pluck('name', 'id');

            // $accounts=array_merge($income, $liability);

            return view('revenue.create', compact('customers', 'categories', 'accounts'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create revenue')) {
            $validator = \Validator::make(
                $request->all(), [
                    'date' => 'required',
                    'amount' => 'required',
                    'account_id' => 'required',
                    //'category_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $revenue = new Revenue();
            $revenue->date = $request->date;
            $revenue->amount = $request->amount;
            $revenue->account_id = $request->account_id;
            $revenue->customer_id = $request->customer_id;
            //$revenue->category_id    = $request->category_id;
            $revenue->payment_method = 0;
            $revenue->reference = $request->reference;
            $revenue->description = $request->description;
            if (! empty($request->add_receipt)) {
                $fileName = time().'_'.$request->add_receipt->getClientOriginalName();
                $request->add_receipt->storeAs('uploads/revenue', $fileName);
                $revenue->add_receipt = $fileName;
            }
            $revenue->created_by = \Auth::user()->creatorId();
            $revenue->save();

            //$category            = ProductServiceCategory::where('id', $request->category_id)->first();
            $revenue->payment_id = $revenue->id;
            $revenue->type = 'Revenue';
            //$revenue->category   = $category->name;
            $revenue->user_id = $revenue->customer_id;
            $revenue->user_type = 'Customer';
            $revenue->account = $request->account_id;
            Transaction::addTransaction($revenue);

            $customer = Customer::where('id', $request->customer_id)->first();
            $payment = new InvoicePayment();
            $payment->name = ! empty($customer) ? $customer['name'] : '';
            $payment->date = \Auth::user()->dateFormat($request->date);
            $payment->amount = \Auth::user()->priceFormat($request->amount);
            $payment->invoice = '';

            if (! empty($customer)) {
                Utility::userBalance('customer', $customer->id, $revenue->amount, 'credit');
            }

            Utility::bankAccountBalance($request->account_id, $revenue->amount, 'credit');

            try {
                //Mail::to($customer['email'])->send(new InvoicePaymentCreate($payment));
            } catch(\Exception $e) {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            //Slack Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['revenue_notification']) && $setting['revenue_notification'] == 1) {
                $msg = __('New Revenue of').' '.\Auth::user()->priceFormat($request->amount).' '.__('created for').' '.$customer->name.' '.__('by').' '.\Auth::user()->name.'.';
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            if (isset($setting['telegram_revenue_notification']) && $setting['telegram_revenue_notification'] == 1) {
                $msg = __('New Revenue of').' '.\Auth::user()->priceFormat($request->amount).' '.__('created for').' '.$customer->name.' '.__('by').' '.\Auth::user()->name.'.';
                Utility::send_telegram_msg($msg);
            }

            //Twilio Notification
            $setting = Utility::settings(\Auth::user()->creatorId());
            $customer = Customer::find($request->customer_id);
            if (isset($setting['twilio_revenue_notification']) && $setting['twilio_revenue_notification'] == 1) {
                $msg = __('New Revenue of').' '.\Auth::user()->priceFormat($request->amount).' '.__('created for').' '.$customer->name.' '.__('by').' '.\Auth::user()->name.'.';

                Utility::send_twilio_msg($customer->contact, $msg);
            }
            $account_balance = ChartOfAccount::where('id', $request->account_id)->first();
            $balance = $account_balance->balance + $request->amount;
            ChartOfAccount::where('id', $request->account_id)->update(['balance' => $balance]);

            return redirect()->route('revenue.index')->with('success', __('Revenue successfully created.').((isset($smtp_error)) ? '<br> <span class="text-danger">'.$smtp_error.'</span>' : ''));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(Revenue $revenue)
    {
        if (\Auth::user()->can('edit revenue')) {
            $customers = Customer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $customers->prepend('--', 0);
            $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 1)->get()->pluck('name', 'id');
            //$accounts   = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' ',holder_name) AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $types = ChartOfAccountType::where('created_by', '=', \Auth::user()->creatorId())->get();
            foreach ($types as $type) {
                if ($type->name == 'Income') {
                    $accounts = ChartOfAccount::where('type', $type->id)->where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                }
            }

            return view('revenue.edit', compact('customers', 'categories', 'accounts', 'revenue'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Revenue $revenue)
    {
        if (\Auth::user()->can('edit revenue')) {
            $validator = \Validator::make(
                $request->all(), [
                    'date' => 'required',
                    'amount' => 'required',
                    'account_id' => 'required',
                    'category_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $customer = Customer::where('id', $request->customer_id)->first();
            if (! empty($customer)) {
                Utility::userBalance('customer', $customer->id, $revenue->amount, 'debit');
            }

            Utility::bankAccountBalance($revenue->account_id, $revenue->amount, 'debit');

            $revenue->date = $request->date;
            $revenue->amount = $request->amount;
            $revenue->account_id = $request->account_id;
            $revenue->customer_id = $request->customer_id;
            $revenue->category_id = $request->category_id;
            $revenue->payment_method = 0;
            $revenue->reference = $request->reference;
            $revenue->description = $request->description;
            if (! empty($request->add_receipt)) {
                $fileName = time().'_'.$request->add_receipt->getClientOriginalName();
                $request->add_receipt->storeAs('uploads/revenue', $fileName);
                $revenue->add_receipt = $fileName;
            }

            $revenue->save();

            $category = ProductServiceCategory::where('id', $request->category_id)->first();
            $revenue->category = $category->name;
            $revenue->payment_id = $revenue->id;
            $revenue->type = 'Revenue';
            $revenue->account = $request->account_id;
            Transaction::editTransaction($revenue);

            if (! empty($customer)) {
                Utility::userBalance('customer', $customer->id, $request->amount, 'credit');
            }

            Utility::bankAccountBalance($request->account_id, $request->amount, 'credit');

            return redirect()->route('revenue.index')->with('success', __('Revenue successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Revenue $revenue)
    {
        if (\Auth::user()->can('delete revenue')) {
            if ($revenue->created_by == \Auth::user()->creatorId()) {
                $revenue->delete();
                $type = 'Revenue';
                $user = 'Customer';
                Transaction::destroyTransaction($revenue->id, $type, $user);

                if ($revenue->customer_id != 0) {
                    Utility::userBalance('customer', $revenue->customer_id, $revenue->amount, 'debit');
                }

                Utility::bankAccountBalance($revenue->account_id, $revenue->amount, 'debit');

                return redirect()->route('revenue.index')->with('success', __('Revenue successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
