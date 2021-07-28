<?php

namespace App\Http\Controllers\Slip;

use App\Model\Slip;
use App\Model\Subject;
use App\Http\Requests\StoreSlipPost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use App\Exports\SlipExport;
use Maatwebsite\Excel\Facades\Excel;

class SlipController extends Controller
{

    /**
     * ログインチェック
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 一覧表示
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
		$slip = Slip::whereBetween('accrual_date', [$dt_from, $dt_to])->get();
        // 現金支出分
        $cash_slip = Slip::whereBetween('accrual_date', [$dt_from, $dt_to])->where('is_cash', 0)->get();
        // クレジットカード支出分
        $credit_slip = Slip::whereBetween('accrual_date', [$dt_from, $dt_to])->where('is_cash', 1)->get();

        // 1ヶ月分の支出
        $gtotal_sl = Slip::whereBetween('accrual_date', [$dt_from, $dt_to])->sum('grand_total');
        // セレクトボックスの科目
        $subject = Subject::all();

        $group_slip = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
                        ->whereBetween('slips.accrual_date', [$dt_from, $dt_to])
                        ->select('subjects.subject_name', DB::raw("sum(slips.grand_total) as sum"))
                        ->groupBy('subjects.subject_name')
                        ->get();
        
        return view('slip.index', compact('slip', 'subject', 'group_slip', 'cash_slip', 'credit_slip', 'gtotal_sl'));
    }

    /**
     * エクセル出力
     *
     */
    public function export(){
        return Excel::download(new SlipExport, '経費.xlsx');
    }

    /**
     * 新規登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSlipPost $request)
    {
        // バリデーション済みデータの取得
        $inputs = $request->validated();

        \DB::beginTransaction();
        try {
            Slip::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        return redirect(route('slip.index'))->with('flash_message', '登録しました');
    }

    /**
     * 更新処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSlipPost $request)
    {
        // バリデーション済みデータの取得
        $inputs = $request->validated();

        \DB::beginTransaction();
        try {
            $slip = Slip::find($inputs['id']);
            $slip->fill([
            'subject_id' => $inputs['subject_id'],
            'is_cash' => $inputs['is_cash'],
            'accrual_date' => $inputs['accrual_date'],
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
        return redirect(route('slip.index'))->with('flash_message', '登録しました');
    }

    /**
     * 削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($id)) {
            return redirect(route('slip.index'))->with('flash_message', 'データがありません');
        }
        try{
        $slip = Slip::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        }
        return redirect(route('slip.index'))->with('flash_message', '削除しました');
    }
}
