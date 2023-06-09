<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use App\Models\ProductServiceCategory;
use App\Models\Proposal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProposalExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        $data = Proposal::get();

        foreach ($data as $k => $proposal) {
            unset($proposal->created_by,$proposal->converted_invoice_id,$proposal->is_convert);
            $data[$k]['proposal_id'] = \Auth::user()->proposalNumberFormat($proposal->proposal_id);
            $data[$k]['customer_id'] = \Auth::user()->customerNumberFormat($proposal->customer_id);
            $data[$k]['category_id'] = ProductServiceCategory::where('type', 1)->first()->name;
            $data[$k]['status'] = Proposal::$statues[$proposal->status];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Proposal No',
            'Customer No',
            'Issue Date',
            'Send Date',
            'Category',
            'Status',
            'Discount Apply	',
            'created_at',
            'updated_at',

        ];
    }
}
