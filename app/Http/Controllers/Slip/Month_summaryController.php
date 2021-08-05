<?php

namespace App\Http\Controllers\Slip;

use App\Model\Month_summary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Month_summaryController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $m_summary = DB::table('subjects')
                        ->leftJoin('month_summaries', 'subjects.id', '=', 'month_summaries.subject_id')
                        ->select('month_summaries.year', 'month_summaries.month', 'subjects.subject_name', DB::raw("sum(month_summaries.monthly_grand_total) as sum"))
                        ->groupBy('month_summaries.year', 'month_summaries.month', 'subjects.subject_name')
                        ->orderBy('month_summaries.month', 'desc')
                        ->get();

        $y_month = array();
        for ($month = 1; $month <= 12; $month++) {
            array_push($y_month, $month);
        }

        $dt_from = new \Carbon\Carbon();
        $dt_from->startOfMonth();
        $dt_to = new \Carbon\Carbon();
        $dt_to->endOfMonth();

        $group_slip = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
                        ->whereBetween('slips.accrual_date', [$dt_from, $dt_to])
                        ->select('subjects.subject_name', DB::raw("sum(slips.grand_total) as sum"))
                        ->groupBy('subjects.subject_name')
                        ->get();

        return view('month_summary.index', compact('m_summary', 'y_month', 'group_slip'));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        \DB::beginTransaction();
        try {
            Month_summary::create($m_summaries);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        return redirect(route('m_summary.index'))->with('flash_message', '月間サマリーを登録しました');
    }
}