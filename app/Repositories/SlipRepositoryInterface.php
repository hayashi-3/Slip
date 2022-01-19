<?php

namespace App\Repositories;

interface SlipRepositoryInterface
{
  public function monthlySlips(int $dtYear, int $dtMonth);
  public function monthlyCashTotal(int $dtYear, int $dtMonth);
  public function mothlyCreditTotal(int $dtYear, int $dtMonth);
  public function monthlyGrandTotal(int $dtYear, int $dtMonth);
  public function pieChartValue(int $dtYear, int $dtMonth);
}
