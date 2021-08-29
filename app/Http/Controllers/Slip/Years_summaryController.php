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
                        ->select('years_summaries.id', 'years_summaries.accountin_year', 'years_summaries.year_subtotal', 'years_summaries.year_sales_tax', 'years_summaries.year_grand_total', 'years_summaries.confirm', 'subjects.id as subject_id', 'subjects.subject_name')
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

        $y_subtotal = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')->select('subjects.id', DB::raw('sum(slips.subtotal) as subtotal, sum(slips.sales_tax) as sales_tax, sum(slips.grand_total) as grand_total'))->where('slips.accrual_year', $year)->where('slips.annual_confirmation', '0')->groupBy('subjects.id')->get();

        \DB::beginTransaction();
        try{
            foreach($y_subtotal as $key => $ys) {
                Years_summary::create(
                    ['subject_id' => $ys->id,
                     'accountin_year' => $year,
                     'year_subtotal'=> $ys->subtotal,
                     'year_sales_tax' => $ys->sales_tax,
                     'year_grand_total' => $ys->grand_total,
                     'confirm' => '1'
                    ]
                );
            }
            \DB::commit();
        } catch(\Throwable $e) { 
            \DB::rollback();
            abort(500);
        }
        return redirect(route('y_summary.index'))->with('flash_message', '年次決算を仮確定しました');
    }

    public function update(Request $request)
    {
        $inputs = $request->all();

        if($request->has('edit')){

            

        }elseif($request->has('confirm')){

            \DB::beginTransaction();
            try {
                $y_summary = Years_summary::find($inputs['id']);
                $y_summary->fill([
                    'subject_id' => $inputs['subject_id'],
                    'accountin_year' => $inputs['accountin_year'],
                    'year_subtotal' => $inputs['year_subtotal'],
                    'year_sales_tax' => $inputs['year_sales_tax'],
                    'year_grand_total' => $inputs['year_grand_total'],
                    'confirm' => '2',
                ]);
                $y_summary->save();
                \DB::commit();

            } catch(\Throwable $e) {
                \DB::rollback();
                abort(500);
            }
        }
        return redirect(route('y_summary.index'))->with('flash_message', '年次決算を確定しました');
    }

    /**
     * エクセル出力
     *
     */
    public function export(Request $request)
    {
        $inputs = $request->all();
        $year = $inputs['display_year'];

        return Excel::download(new SlipExport($year), '経費'.date('Ymd').'.xlsx');
    }
}