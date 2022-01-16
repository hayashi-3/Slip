<?php

namespace App\Repositories;

use App\Model\Slip;
use App\Model\Years_summary;
use App\Model\Subject;
use Illuminate\Support\Facades\DB;

class YearsSummaryRepository implements YearsSummaryRepositoryInterface
{
  protected $ySummary;

  public function __construct(Years_summary $ySummary)
  {
    $this->ySummary = $ySummary;
  }

  // 1年間の伝票を取得
  public function thisYearSlips()
  {
    return Subject::leftJoin('years_summaries', 'subjects.id', '=', 'years_summaries.subject_id')
      ->select('years_summaries.id', 'years_summaries.accountin_year', 'years_summaries.year_subtotal', 'years_summaries.year_sales_tax', 'years_summaries.year_grand_total', 'years_summaries.confirm', 'subjects.id as subject_id', 'subjects.subject_name')
      ->orderBy('years_summaries.accountin_year', 'desc')
      ->get();
  }

  // 年度の取得
  public function accountionYear()
  {
    return Years_summary::select('accountin_year')->get();
  }
}
