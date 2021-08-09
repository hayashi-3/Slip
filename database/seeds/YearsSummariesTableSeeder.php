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
                'subject_id' => 1,
                'accountin_year' => 2021,
                'year_subtotal' => 300000,
                'year_sales_tax' => 30000,
                'year_grand_total' => 330000
            ]
        ]);
    }
}
