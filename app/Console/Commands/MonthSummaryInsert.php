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
        $month_from = new \Carbon\Carbon();
        $last_month_from = $month_from->firstOfMonth();
        
        $month_to = new \Carbon\Carbon();
		$last_month_to = $month_to->endOfMonth();
        
        $subtotal = Slip::whereBetween('accrual_date', [$last_month_from, $last_month_to])->sum('subtotal');
        $sales_tax = Slip::whereBetween('accrual_date', [$last_month_from, $last_month_to])->sum('sales_tax');
        $grand_total = Slip::whereBetween('accrual_date', [$last_month_from, $last_month_to])->sum('grand_total');

        \DB::beginTransaction();
        try{
            Month_summary::create([
                'month'=> $last_month_from,
                'monthly_subtotal'=> $subtotal,
                'monthly_sales_tax' => $sales_tax,
                'monthly_grand_total' => $grand_total,
            ]);
            \DB::commit();
        } catch(\Throwable $e) { 
            \DB::rollback(); 
        }
    }
}