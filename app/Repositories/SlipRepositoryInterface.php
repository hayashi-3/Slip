<?php

namespace App\Repositories;

interface SlipRepositoryInterface
{
  public function monthlySlips();
  public function monthlyCashTotal();
  public function mothlyCreditTotal();
  public function monthlyGrandTotal();
  public function pieChartValue();
}
