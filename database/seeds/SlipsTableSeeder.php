<?php

use Illuminate\Database\Seeder;

class SlipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slips')->insert([
            [
                'subject_id' => 1,
                'accrual_year' => 2021,
                'accrual_month' => 7,
                'accrual_date' => 1,
                'price' => 20000,
                'subtotal' => 20000,
                'sales_tax_rate' => 10,
                'sales_tax' => 2000,
                'grand_total' => 22000,
                'remarks' => '7/14カフェ'
            ],
            [
                'subject_id' => 1,
                'accrual_year' => 2021,
                'accrual_month' => 1,
                'accrual_date' => 1,
                'price' => 1000,
                'subtotal' => 1000,
                'sales_tax_rate' => 10,
                'sales_tax' => 1100,
                'grand_total' => 11000,
                'remarks' => '2021カフェ'
            ],
            [
                'subject_id' => 1,
                'accrual_year' => 2022,
                'accrual_month' => 1,
                'accrual_date' => 1,
                'price' => 1000,
                'subtotal' => 1000,
                'sales_tax_rate' => 10,
                'sales_tax' => 1100,
                'grand_total' => 11000,
                'remarks' => '2022カフェ'
            ],
            [
                'subject_id' => 2,
                'accrual_year' => 2021,
                'accrual_month' => 7,
                'accrual_date' => 2,
                'price' => 20000,
                'subtotal' => 20000,
                'sales_tax_rate' => 10,
                'sales_tax' => 2000,
                'grand_total' => 22000,
                'remarks' => '7/14家賃'
            ],
        ]);
    }
}