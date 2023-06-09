<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractTypeController extends Controller
{
    public function index()
    {
        if (\Auth::user()->type == 'company') {
            $types = ContractType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('contractType.index', compact('types'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create(): View
    {
        return view('contractType.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (\Auth::user()->type == 'company') {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $types = new ContractType();
            $types->name = $request->name;
            $types->created_by = \Auth::user()->creatorId();
            $types->save();

            return redirect()->route('contractType.index')->with('success', __('Contract Type successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(ContractType $contractType)
    {
        //
    }

    public function edit(ContractType $contractType): View
    {
        return view('contractType.edit', compact('contractType'));
    }

    public function update(Request $request, ContractType $contractType): RedirectResponse
    {
        if (\Auth::user()->type == 'company') {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $contractType->name = $request->name;
            $contractType->created_by = \Auth::user()->creatorId();
            $contractType->save();

            return redirect()->route('contractType.index')->with('success', __('Contract Type successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(ContractType $contractType): RedirectResponse
    {
        if (\Auth::user()->type == 'company') {
            $data = Contract::where('type', $contractType->id)->first();
            if (! empty($data)) {
                return redirect()->back()->with('error', __('this type is already use so please transfer or delete this type related data.'));
            }

            $contractType->delete();

            return redirect()->route('contractType.index')->with('success', __('Contract Type successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
