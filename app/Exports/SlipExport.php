<?php

namespace App\Exports;

use App\Model\Slip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class SlipExport implements FromCollection, WithHeadings, WithStrictNullComparison , WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Slip::all()->makeHidden(['id', 'created_at', 'updated_at']);
    }

    public function headings():array
    {
        return [
            '科目名',
            '支払区分',
            '年',
            '月',
            '日',
            '金額',
            '小計',
            '消費税率(%)',
            '消費税額',
            '総計',
            '備考'
        ];
    }

    public function map($row) :array
    {
        return [
            $row->subject_id,
            $row->is_cash,
            $row->accrual_year,
            $row->accrual_month,
            $row->accrual_date,
            $row->price,
            $row->subtotal,
            $row->sales_tax_rate,
            $row->sales_tax,
            $row->grand_total,
            $row->remarks
        ];
    }

}
