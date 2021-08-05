<?php

namespace App\Exports;

use App\Model\Slip;
// 複数シート作成
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SlipExport implements WithMultipleSheets
{
    use Exportable;

    protected $year;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

     /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new SlipSheet($this->year, $month);
        }
        return $sheets;
    }

}