<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            [
                'subject_name' => '会議費',
                'calculation' => 1
            ],
            [
                'subject_name' => '家賃',
                'calculation' => 0.25
            ],
        ]);
    }
}
