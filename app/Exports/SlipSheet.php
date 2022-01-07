<?php

namespace App\Exports;

use App\Model\Slip;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;

class SlipSheet implements FromQuery, WithTitle, WithHeadings, WithStrictNullComparison, WithMapping
{
    private $month;
    private $year;

    public function __construct(int $year, int $month)
    {
        $this->year  = $year;
        $this->month = $month;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return Slip::query()
            ->where('accrual_year', $this->year)
            ->where('accrual_month', $this->month);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->month . '月分';
    }

    public function headings(): array
    {
        return [
            '支払区分',
            '科目名',
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

    public function map($row): array
    {
        return [
            $row->is_cash,
            $row->subject->subject_name,
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
