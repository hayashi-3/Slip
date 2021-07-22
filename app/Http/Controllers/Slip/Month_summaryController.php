<?php

namespace App\Http\Controllers\Slip;

use App\Model\Month_summary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $dt_from = new \Carbon\Carbon();
		$dt_from->startOfMonth();
		$dt_to = new \Carbon\Carbon();
		$dt_to->endOfMonth();
        // 1ヶ月分のデータを取得
		$m_summary = Month_summary::whereBetween('period_end', [$dt_from, $dt_to])->get();
        return view('month_summary.index', compact('m_summary'));
    }
}
