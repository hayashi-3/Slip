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
        $m_subtotal = DB::table('subjects')->leftJoin('slips', 'subjects.id', '=', 'slips.subject_id')->select('subjects.id', 'slips.accrual_year', 'slips.accrual_month', DB::raw('sum(slips.subtotal) as monthly_subtotal, sum(slips.sales_tax) as monthly_sales_tax, sum(slips.grand_total) as monthly_grand_total'))->groupBy('subjects.id', 'slips.accrual_year', 'slips.accrual_month')->get();

        \DB::beginTransaction();
        try {
            foreach ($m_subtotal as $key => $mb) {
                Month_summary::updateOrCreate(
                    ['subject_id' => $mb->id],
                    [
                        'subject_id' => $mb->id,
                        'year' => $mb->accrual_year,
                        'month' => (int)$mb->accrual_month,
                        'monthly_subtotal' => $mb->monthly_subtotal,
                        'monthly_sales_tax' => $mb->monthly_sales_tax,
                        'monthly_grand_total' => $mb->monthly_grand_total
                    ]
                );
            }
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            echo ('エラーが発生しました');
        }
    }
}
