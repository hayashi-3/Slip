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

    public function __construct(SlipRepositoryInterface $slipRepository)
    {
        $this->slipRepository = $slipRepository;
    }

    /**
     * 一覧表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dtMonth = new \Carbon\Carbon();
        $dtMonth = (int)$dtMonth->month;

        $dtYear = new \Carbon\Carbon();
        $dtYear = (int)$dtYear->year;

        // 1ヶ月分のデータを取得
        $slip = $this->slipRepository->monthlySlips($dtYear, $dtMonth);
        // 現金支出分
        $cashSlip = $this->slipRepository->monthlyCashTotal($dtYear, $dtMonth);
        // クレジットカード支出分
        $creditSlip = $this->slipRepository->mothlyCreditTotal($dtYear, $dtMonth);

        // 1ヶ月分の支出
        $gtotalSl = $this->slipRepository->monthlyGrandTotal($dtYear, $dtMonth);
        // セレクトボックスの科目
        $subject = Subject::all();
        // 円グラフの値
        $groupSlip = $this->slipRepository->pieChartValue($dtYear, $dtMonth);

        return view('slip.index', compact('slip', 'dtYear', 'dtMonth', 'subject', 'groupSlip', 'cashSlip', 'creditSlip', 'gtotalSl'));
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
