<?php

namespace App\Http\Controllers\Slip;

use App\Model\Month_summary;
use App\Model\Slip;
use App\Model\Subject;
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

        return view('month_summary.index', compact('m_summary', 'y_month'));
    }

    public function show($year, $month, $subject_name) {
        $m_summary_slip = DB::table('subjects')
                            ->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
                            ->where('slips.accrual_year', $year)
                            ->where('slips.accrual_month', $month)
                            ->where('subjects.subject_name', $subject_name)
                            ->orderBy('slips.accrual_date', 'asc')
                            ->paginate(30);
        
        // セレクトボックスの科目
        $subject = Subject::all();

        return view('month_summary.show', compact('m_summary_slip', 'subject'));
    }

    public function update(Request $request) {
        
        $inputs = $request->all();

        $subject = Subject::find($inputs['subject_id']);
        $subject_name = $subject->subject_name;
       
        $accrual_year = $inputs['accrual_year'];
        list($year, $month, $date) = explode('/', $accrual_year);
        
        \DB::beginTransaction();
        try {
            $slip = Slip::find($inputs['id']);
            $slip->fill([
            'subject_id' => $inputs['subject_id'],
            'is_cash' => $inputs['is_cash'],
            'accrual_year' => $year,
            'accrual_month' => $month,
            'accrual_date' => $date,
            'price' => $inputs['price'],
            'subtotal' => $inputs['subtotal'],
            'sales_tax_rate' => $inputs['sales_tax_rate'],
            'sales_tax' => $inputs['sales_tax'],
            'grand_total' => $inputs['grand_total'],
            'remarks' => $inputs['remarks'],
            ]);
        $slip->save();
        \DB::commit();

        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        return redirect(route('m_summary.show', ['year' => $year, 'month' => $month, 'subject_name' => $subject_name]))->with('flash_message', '更新しました');
    }
}