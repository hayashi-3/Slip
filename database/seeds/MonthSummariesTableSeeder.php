<?php

use Illuminate\Database\Seeder;

class MonthSummariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('month_summaries')->insert([
            [
                'slip_id' => '1',
                'period_start' => '2021-07-01',
                'period_end' => '2021-07-31',
                'monthly_subtotal' => 20000,
                'monthly_sales_tax' => 2000,
                'monthly_grand_total' => 22000
            ],
            [
                'slip_id' => '1',
                'period_start' => '2021-07-01',
                'period_end' => '2021-07-31',
                'monthly_subtotal' => 50000,
                'monthly_sales_tax' => 5000,
                'monthly_grand_total' => 55000
            ],
        ]);
    }
}
