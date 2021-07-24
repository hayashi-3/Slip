<?php

namespace App\Http\Controllers\Slip;

use App\Model\Slip;
use App\Model\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
        // 1ヶ月分の支出
        $gtotal_sl = Slip::whereBetween('accrual_date', [$dt_from, $dt_to])->sum('grand_total');
        // セレクトボックスの科目
        $subject = Subject::all();

        $subject_names = Subject::get(['subject_name'])->toArray();
        
        return view('slip.index', compact('slip', 'subject', 'subject_names', 'gtotal_sl'));
    }

    /**
     * 新規登録
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

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
    public function update(Request $request)
    {
      $inputs = $request->all();

        \DB::beginTransaction();
        try {
            $slip = Slip::find($inputs['id']);
            $slip->fill([
            'subject_id' => $inputs['subject_id'],
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
