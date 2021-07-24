<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MonthSummaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('month_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('month');
            $table->integer('monthly_subtotal');
            $table->double('monthly_sales_tax');
            $table->integer('monthly_grand_total');
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
        Schema::dropIfExists('month_summaries');
    }
}
