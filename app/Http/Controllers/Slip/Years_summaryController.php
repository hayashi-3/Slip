<?php

namespace App\Http\Controllers\Slip;

use App\Model\Years_summary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\SlipExport;
use Maatwebsite\Excel\Facades\Excel;

class Years_summaryController extends Controller
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
        $y_summary = Years_summary::all();
        return view('years_summary.index', compact('y_summary'));
    }

    /**
     * エクセル出力
     *
     */
    public function export(){
        $dt_year = new \Carbon\Carbon();
        $year = (int)$dt_year->year;
        return Excel::download(new SlipExport($year), '経費'.date('Ymd').'.xlsx');
    }
}