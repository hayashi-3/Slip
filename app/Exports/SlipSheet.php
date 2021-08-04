<?php

namespace App\Exports;

use App\Model\Slip;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class SlipSheet implements FromQuery, WithStrictNullComparison, WithTitle, WithHeadings
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
      return $this->month. '月分';
  }

  public function headings():array
  {
      return [
          '支払区分',
          '科目名',
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
}