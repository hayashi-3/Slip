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
        $dt_month = new \Carbon\Carbon();
        $dt_month = (int)$dt_month->month;

        $dt_year = new \Carbon\Carbon();
        $dt_year = (int)$dt_year->year;
       
        // 1ヶ月分のデータを取得
		$slip = DB::table('slips')->where('accrual_month', $dt_month)->orderBy('accrual_date', 'asc')->get();
        // 現金支出分
        $cash_slip = Slip::where('accrual_month', $dt_month)->where('is_cash', 0)->orderBy('accrual_date', 'asc')->get();
        // クレジットカード支出分
        $credit_slip = Slip::where('accrual_month', $dt_month)->where('is_cash', 1)->orderBy('accrual_date', 'asc')->get();

        // 1ヶ月分の支出
        $gtotal_sl = Slip::where('accrual_month', $dt_month)->sum('grand_total');
        // セレクトボックスの科目
        $subject = Subject::all();

        $group_slip = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
                        ->where('slips.accrual_month', $dt_month)
                        ->select('subjects.subject_name', DB::raw("sum(slips.grand_total) as sum"))
                        ->groupBy('subjects.subject_name')
                        ->get();
        
        return view('slip.index', compact('slip', 'dt_year', 'dt_month', 'subject', 'group_slip', 'cash_slip', 'credit_slip', 'gtotal_sl'));
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
      
        // 日付チェックのために結合したものを分解する
        list($accual_year, $accual_month, $accual_date) = preg_split('/[-: ]/', $inputs['accrual_year_validation']);

        Slip::create([
            'subject_id' => $inputs['subject_id'],
            'is_cash' => $inputs['is_cash'],
            'accrual_year' => $accual_year,
            'accrual_month' => $accual_month,
            'accrual_date' => $accual_date,
            'price' => $inputs['price'],
            'subtotal' => $inputs['subtotal'],
            'sales_tax_rate' => $inputs['sales_tax_rate'],
            'sales_tax' => $inputs['sales_tax'],
            'grand_total' => $inputs['grand_total'],
            'remarks' => $inputs['remarks'],
        ]);

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
        $inputs = $request->all();
        
        $slip = Slip::find($inputs['id']);
        $slip->fill([
            'subject_id' => $inputs['subject_id'],
            'is_cash' => $inputs['is_cash'],
            'accrual_year' => $inputs['accrual_year'],
            'accrual_month' => $inputs['accrual_month'],
            'accrual_date' => $inputs['accrual_date'],
            'price' => $inputs['price'],
            'subtotal' => $inputs['subtotal'],
            'sales_tax_rate' => $inputs['sales_tax_rate'],
            'sales_tax' => $inputs['sales_tax'],
            'grand_total' => $inputs['grand_total'],
            'remarks' => $inputs['remarks'],
        ]);
        $slip->save();

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
        // 遷移元URLで振り分ける(仕訳入力画面と月間仕訳のdeleteはこちらで処理される)
        $before_url = $_SERVER['HTTP_REFERER'];
        
        if(preg_match("/m_summary/", $before_url)) {

            if(empty($id)) {
                return redirect(route('m_summary.index'))->with('flash_message', 'データがありません');
            }
            $slip = Slip::destroy($id);
            return redirect(route('m_summary.index'))->with('flash_message', '削除しました');
        
        }elseif(preg_match("/slip/", $before_url)){ 

            if (empty($id)) {
                return redirect(route('slip.index'))->with('flash_message', 'データがありません');
            }
            $slip = Slip::destroy($id);
            return redirect(route('slip.index'))->with('flash_message', '削除しました');
        }
    }
}
