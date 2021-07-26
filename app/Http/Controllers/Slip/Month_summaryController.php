<?php

namespace App\Http\Controllers\Slip;

use App\Model\Month_summary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
		$m_summary = Month_summary::orderBy('month', 'desc')->get();

        $dt_from = new \Carbon\Carbon();
		$dt_from->startOfMonth();
		$dt_to = new \Carbon\Carbon();
		$dt_to->endOfMonth();

        $group_slip = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')->whereBetween('slips.accrual_date', [$dt_from, $dt_to])->select('subjects.subject_name', DB::raw("sum(slips.grand_total) as sum"))->groupBy('subjects.subject_name')->get();

        return view('month_summary.index', compact('m_summary', 'group_slip'));
    }
}