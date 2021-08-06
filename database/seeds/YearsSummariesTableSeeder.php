<?php

use Illuminate\Database\Seeder;

class YearsSummariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('years_summaries')->insert([
            [
                'accountin_period_start' => '2021-01-01',
                'accountin_period_end' => '2021-12-31',
                'year_subtotal' => 300000,
                'year_sales_tax' => 30000,
                'year_grand_total' => 330000
            ]
        ]);
    }
}
