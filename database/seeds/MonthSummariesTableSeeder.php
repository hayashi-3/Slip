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
                'month' => '2021-06-01',
                'monthly_subtotal' => 20000,
                'monthly_sales_tax' => 2000,
                'monthly_grand_total' => 22000
            ],
            [
                'month' => '2021-07-01',
                'monthly_subtotal' => 50000,
                'monthly_sales_tax' => 5000,
                'monthly_grand_total' => 55000
            ],
        ]);
    }
}
