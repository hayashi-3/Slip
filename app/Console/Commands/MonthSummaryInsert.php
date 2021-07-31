<?php

namespace App\Console\Commands;

use App\Model\Slip;
use App\Model\Month_summary;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonthSummaryInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'month_summary:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '1ヶ月ごとに伝票の集計をする';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $month_from = new \Carbon\Carbon();
        // $last_month_from = $month_from->firstOfMonth();
        
        // $month_to = new \Carbon\Carbon();
		// $last_month_to = $month_to->endOfMonth();

        $dt_from = new \Carbon\Carbon();
        $dt_from->startOfMonth();
        $dt_to = new \Carbon\Carbon();
        $dt_to->endOfMonth();
        
        // ここは配列ではない
        $year = new \Carbon\Carbon();
		$year->year;

        // ここも配列ではない
        $month = new \Carbon\Carbon();
        $month->month;

        // これは配列exit
        $m_subject_id = Slip::groupBy('subject_id')->get(['subject_id']);
        
        $m_subtotal = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
        ->whereBetween('slips.accrual_date', [$dt_from, $dt_to])->select('subjects.id', DB::raw("sum(slips.subtotal) as monthly_subtotal"))->groupBy('subjects.id')->get();
        
        $m_sales_tax = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
        ->whereBetween('slips.accrual_date', [$dt_from, $dt_to])->select('subjects.id', DB::raw("sum(slips.sales_tax) as monthly_monthly_sales_tax"))->groupBy('subjects.id')->get();

        $m_grand_total = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')
        ->whereBetween('slips.accrual_date', [$dt_from, $dt_to])->select('subjects.id', DB::raw("sum(slips.grand_total) as monthly_grand_total"))->groupBy('subjects.id')->get();

        // \DB::beginTransaction();
        // try{
            Month_summary::updateOrCreate([
                ['subject_id' => $m_subject_id],
                'year' => $year,
                'month'=> $month,
                ['monthly_subtotal'=> $m_subtotal],
                ['monthly_sales_tax' => $m_sales_tax],
                ['monthly_grand_total' => $m_grand_total],
            ]);
        //     \DB::commit();
        // } catch(\Throwable $e) { 
        //     \DB::rollback();
        //     echo('エラーが発生しました');
        // }
    }
}