<?php

namespace App\Repositories;

use App\Model\Slip;
use App\Model\Subject;
use Illuminate\Support\Facades\DB;

class SlipRepository implements SlipRepositoryInterface
{

  protected $slip;

  public function __construct(Slip $slip)
  {
    $this->slip = $slip;
  }

  // 1ヶ月分のデータを取得
  public function monthlySlips()
  {
    $dt_month = new \Carbon\Carbon();
    $dt_month = (int)$dt_month->month;

    $dt_year = new \Carbon\Carbon();
    $dt_year = (int)$dt_year->year;

    return Slip::where('accrual_year', $dt_year)->where('accrual_month', $dt_month)->orderBy('accrual_date', 'asc')->get();
  }

  // 現金支出分
  public function monthlyCashTotal()
  {
    $dt_month = new \Carbon\Carbon();
    $dt_month = (int)$dt_month->month;

    $dt_year = new \Carbon\Carbon();
    $dt_year = (int)$dt_year->year;

    return Slip::where('accrual_year', $dt_year)->where('accrual_month', $dt_month)->where('is_cash', 0)->orderBy('accrual_date', 'asc')->get();
  }

  // クレジットカード支出分
  public function mothlyCreditTotal()
  {
    $dt_month = new \Carbon\Carbon();
    $dt_month = (int)$dt_month->month;

    $dt_year = new \Carbon\Carbon();
    $dt_year = (int)$dt_year->year;

    return Slip::where('accrual_year', $dt_year)->where('accrual_month', $dt_month)->where('is_cash', 1)->orderBy('accrual_date', 'asc')->get();
  }

  // 1ヶ月分の支出
  public function monthlyGrandTotal()
  {
    $dt_month = new \Carbon\Carbon();
    $dt_month = (int)$dt_month->month;

    $dt_year = new \Carbon\Carbon();
    $dt_year = (int)$dt_year->year;

    return $this->slip->where('accrual_year', $dt_year)->where('accrual_month', $dt_month)->sum('grand_total');
  }

  // 円グラフの値
  public function pieChartValue()
  {
    $dt_month = new \Carbon\Carbon();
    $dt_month = (int)$dt_month->month;

    $dt_year = new \Carbon\Carbon();
    $dt_year = (int)$dt_year->year;

    return Subject::leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
      ->where('accrual_year', $dt_year)
      ->where('slips.accrual_month', $dt_month)
      ->select('subjects.subject_name', DB::raw("sum(slips.grand_total) as sum"))
      ->groupBy('subjects.subject_name')
      ->get();
  }
}
