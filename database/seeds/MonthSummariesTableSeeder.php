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
                'subject_id' => '1',
                'year' => '2021',
                'month' => '6',
                'monthly_subtotal' => 20000,
                'monthly_sales_tax' => 2000,
                'monthly_grand_total' => 22000
            ],
            [
                'subject_id' => '2',
                'year' => '2021',
                'month' => '7',
                'monthly_subtotal' => 50000,
                'monthly_sales_tax' => 5000,
                'monthly_grand_total' => 55000
            ],
            [
                'subject_id' => '2',
                'year' => '2021',
                'month' => '7',
                'monthly_subtotal' => 50000,
                'monthly_sales_tax' => 5000,
                'monthly_grand_total' => 55000
            ],
        ]);
    }
}
