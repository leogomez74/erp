<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        $data = Customer::get();

        foreach ($data as $k => $customer) {
            unset($customer->password, $customer->lang, $customer->created_by, $customer->email_verified_at, $customer->remember_token);
            $data[$k]['customer_id'] = \Auth::user()->customerNumberFormat($customer->customer_id);
            $data[$k]['balance'] = \Auth::user()->priceFormat($customer->balance);
            $data[$k]['avatar'] = ! empty($customer->avatar) ? asset(\Storage::url('uploads/avatar')).'/'.$customer->avatar : '-';
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer No',
            'Name',
            'Email',
            'Contact',
            'Avatar',
            'Active Status',
            'Billing Name',
            'Billing Country',
            'Billing State',
            'Billing City',
            'Billing Phone',
            'Billing Zip',
            'Billing Address',
            'Shipping Name',
            'Shipping Country',
            'Shipping State',
            'Shipping City',
            'Shipping Phone',
            'Shipping Zip',
            'Shipping Address',
            'Balance',
            'created_at',
            'updated_at',
        ];
    }
}
