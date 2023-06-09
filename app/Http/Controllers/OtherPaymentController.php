<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\OtherPayment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OtherPaymentController extends Controller
{
    public function otherpaymentCreate($id): View
    {
        $employee = Employee::find($id);
        $otherpaytype = OtherPayment::$otherPaymenttype;

        return view('otherpayment.create', compact('employee', 'otherpaytype'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (\Auth::user()->can('create other payment')) {
            $validator = \Validator::make(
                $request->all(), [
                    'employee_id' => 'required',
                    'title' => 'required',
                    'amount' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $otherpayment = new OtherPayment();
            $otherpayment->employee_id = $request->employee_id;
            $otherpayment->title = $request->title;
            $otherpayment->type = $request->type;
            $otherpayment->amount = $request->amount;
            $otherpayment->created_by = \Auth::user()->creatorId();
            $otherpayment->save();

            return redirect()->back()->with('success', __('OtherPayment  successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(OtherPayment $otherpayment): RedirectResponse
    {
        return redirect()->route('commision.index');
    }

    public function edit($otherpayment)
    {
        $otherpayment = OtherPayment::find($otherpayment);
        if (\Auth::user()->can('edit other payment')) {
            if ($otherpayment->created_by == \Auth::user()->creatorId()) {
                $otherpaytypes = OtherPayment::$otherPaymenttype;

                return view('otherpayment.edit', compact('otherpayment', 'otherpaytypes'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, OtherPayment $otherpayment): RedirectResponse
    {
        if (\Auth::user()->can('edit other payment')) {
            if ($otherpayment->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(), [

                        'title' => 'required',
                        'amount' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $otherpayment->title = $request->title;
                $otherpayment->type = $request->type;
                $otherpayment->amount = $request->amount;
                $otherpayment->save();

                return redirect()->back()->with('success', __('OtherPayment successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(OtherPayment $otherpayment): RedirectResponse
    {
        if (\Auth::user()->can('delete other payment')) {
            if ($otherpayment->created_by == \Auth::user()->creatorId()) {
                $otherpayment->delete();

                return redirect()->back()->with('success', __('OtherPayment successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
