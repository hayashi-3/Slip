<?php

namespace App\Http\Controllers\Slip;

use App\Model\Slip;
use App\Model\Subject;
use App\Http\Requests\StoreSlipPost;
use App\Http\Controllers\Controller;
use App\Repositories\SlipRepositoryInterface;

class SlipController extends Controller
{

    /**
     * ログインチェック
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function __construct(SlipRepositoryInterface $slip_repository)
    {
        $this->slip_repository = $slip_repository;
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
        $slip = $this->slip_repository->monthlySlips();
        // 現金支出分
        $cash_slip = $this->slip_repository->monthlyCashTotal();
        // クレジットカード支出分
        $credit_slip = $this->slip_repository->mothlyCreditTotal();

        // 1ヶ月分の支出
        $gtotal_sl = $this->slip_repository->monthlyGrandTotal();
        // セレクトボックスの科目
        $subject = Subject::all();
        // 円グラフの値
        $group_slip = $this->slip_repository->pieChartValue();

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
        // $before_url = $_SERVER['HTTP_REFERER'];
        $current_url = url()->current();

        if (preg_match("/m_summary/", $current_url)) {
            if (empty($id)) {
                return redirect(route('m_summary.index'))->with('flash_message', 'データがありません');
            }
            Slip::destroy($id);
            return redirect(route('m_summary.index'))->with('flash_message', '削除しました');
        } elseif (preg_match("/slip/", $current_url)) {
            if (empty($id)) {
                return redirect(route('slip.index'))->with('flash_message', 'データがありません');
            }
            Slip::destroy($id);
            return redirect(route('slip.index'))->with('flash_message', '削除しました');
        }
    }
}
