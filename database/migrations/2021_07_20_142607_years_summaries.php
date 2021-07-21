<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class YearsSummaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('accountin_period_start');
            $table->date('accountin_period_end');
            $table->integer('year_subtotal');
            $table->double('year_sales_tax');
            $table->integer('year_grand_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('years_summaries');
    }
}
