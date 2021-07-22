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
                'subject_id' => '1',
                'accrual_date' => '2021-07-01',
                'price' => 20000,
                'subtotal' => 20000,
                'sales_tax_rate' => 10,
                'sales_tax' => 2000,
                'grand_total' => 22000,
                'remarks' => '7/14カフェ'
            ],
        ]);
    }
}