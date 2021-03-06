<?php

namespace App\Http\Controllers\Slip;

use App\Model\Years_summary;
use App\Model\Slip;
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

        foreach ($y_subtotal as $key => $ys) {
            Years_summary::updateOrCreate(
                ['accountin_year' => $year],
                [
                    'subject_id' => $ys->id,
                    'accountin_year' => $year,
                    'year_subtotal' => $ys->subtotal,
                    'year_sales_tax' => $ys->sales_tax,
                    'year_grand_total' => $ys->grand_total,
                    'confirm' => '1'
                ]
            );
        }

        return redirect(route('y_summary.index'))->with('flash_message', '?????????????????????????????????');
    }

    public function update(Request $request)
    {
        $inputs = $request->all();

        // ??????????????????????????? update???submit????????????
        if ($request->has('update')) {

            $y_summary = Years_summary::find($inputs['u_id']);
            $y_summary->fill([
                'subject_id' => $inputs['u_subject_id'],
                'accountin_year' => $inputs['u_accountin_year'],
                'year_subtotal' => $inputs['u_year_subtotal'],
                'year_sales_tax' => $inputs['u_year_sales_tax'],
                'year_grand_total' => $inputs['u_year_grand_total'],
                'confirm' => '1',
            ]);
            $y_summary->save();

            return redirect(route('y_summary.index'))->with('flash_message', '??????????????????');

            // ????????????????????? confirm???submit????????????
        } elseif ($request->has('confirm')) {

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

                $y_slip = Slip::where('accrual_year', $inputs['accountin_year'])->get();
                foreach ($y_slip as $key => $yslip) {
                    $u_yslip = Slip::find($yslip->id);
                    $u_yslip->fill([
                        'annual_confirmation' => '1',
                    ]);
                    $u_yslip->save();
                }

                \DB::commit();
            } catch (\Throwable $e) {
                \DB::rollback();
                abort(500);
            }
        }

        return redirect(route('y_summary.index'))->with('flash_message', '?????????????????????????????????');
    }

    /**
     * ??????????????????
     *
     */
    public function export(Request $request)
    {
        $inputs = $request->all();
        $year = $inputs['display_year'];

        return Excel::download(new SlipExport($year), '??????' . date('Ymd') . '.xlsx');
    }
}
