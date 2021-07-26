<?php

namespace App\Exports;

use App\Model\Slip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SlipExport implements FromCollection, WithHeadings, WithStrictNullComparison ,WithColumnFormatting, WithMapping
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
            '支払区分',
            '科目名',
            '発生日',
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
            Date::stringToExcel($row->accrual_date),
            $row->price,
            $row->subtotal,
            $row->sales_tax_rate,
            $row->sales_tax,
            $row->grand_total,
            $row->remarks
        ];
    }

    public function columnFormats() :array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDDSLASH,
        ];
    }

}
