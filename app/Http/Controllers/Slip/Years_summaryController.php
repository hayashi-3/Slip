<?php

namespace App\Http\Controllers\Slip;

use App\Model\Years_summary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\SlipExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

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
        $y_summary = DB::table('subjects')
                        ->leftJoin('years_summaries', 'subjects.id', '=', 'years_summaries.subject_id')
                        ->select('years_summaries.id', 'years_summaries.accountin_year', 'years_summaries.year_subtotal', 'years_summaries.year_sales_tax', 'years_summaries.year_grand_total', 'subjects.subject_name')
                        ->orderBy('years_summaries.accountin_year', 'desc')
                        ->get();

        $years = Years_summary::select('accountin_year')->get();

        return view('years_summary.index', compact('y_summary', 'years'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $year = $inputs['year'];

        $y_subtotal = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')->where('slips.accrual_year', $year) ->select('month_summaries.year', 'month_summaries.month', 'subjects.subject_name', DB::raw("sum(month_summaries.monthly_grand_total) as sum"))->groupBy('month_summaries.year', 'month_summaries.month', 'subjects.subject_name')->get();

        // \DB::beginTransaction();
        // try{
            foreach($y_subtotal as $key => $ys) {
                Years_summary::create(
                    ['subject_id' => $ys->id,
                     'accountin_year' => $ys->accrual_year,
                     'year_subtotal'=> $ys->year_subtotal,
                     'year_sales_tax' => $ys->year_sales_tax,
                     'year_grand_total' => $ys->year_grand_total,
                     'confirm' => 1
                    ]
                );
            }
        //     \DB::commit();
        // } catch(\Throwable $e) { 
        //     \DB::rollback();
        //     abort(500);
        // }
        return redirect(route('y_summary.index'))->with('flash_message', '年次決算を仮確定しました');
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