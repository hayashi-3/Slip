<?php

namespace App\Repositories;

use App\Model\Slip;
use App\Model\Subject;
use Illuminate\Support\Facades\DB;

class SlipRepository implements SlipRepositoryInterface
{

    protected $slip;

    public function __construct(Slip $slip, Subject $subject)
    {
        $this->slip = $slip;
        $this->subject = $subject;
    }

    // 1ヶ月分のデータを取得
    public function monthlySlips(int $dtYear, int $dtMonth)
    {
        return $this->slip
            ->where('accrual_year', $dtYear)
            ->where('accrual_month', $dtMonth)
            ->orderBy('accrual_date', 'asc')
            ->get();
        
    }

    // 現金支出分
    public function monthlyCashTotal(int $dtYear, int $dtMonth)
    {
        return $this->slip
            ->where('accrual_year', $dtYear)
            ->where('accrual_month', $dtMonth)
            ->where('is_cash', 0)
            ->orderBy('accrual_date', 'asc')
            ->get();
    }

    // クレジットカード支出分
    public function mothlyCreditTotal(int $dtYear, int $dtMonth)
    {
        return $this->slip
            ->where('accrual_year', $dtYear)
            ->where('accrual_month', $dtMonth)
            ->where('is_cash', 1)
            ->orderBy('accrual_date', 'asc')
            ->get();
    }

    // 1ヶ月分の支出
    public function monthlyGrandTotal(int $dtYear, int $dtMonth)
    {
        return $this->slip
            ->where('accrual_year', $dtYear)
            ->where('accrual_month', $dtMonth)
            ->sum('grand_total');
    }

    // 円グラフの値
    public function pieChartValue(int $dtYear, int $dtMonth)
    {
        return $this->subject
            ->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
            ->where('accrual_year', $dtYear)
            ->where('slips.accrual_month', $dtMonth)
            ->select('subjects.subject_name', DB::raw("sum(slips.grand_total) as sum"))
            ->groupBy('subjects.subject_name')
            ->get();
    }
}
