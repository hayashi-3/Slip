<?php

namespace App\Repositories;

use App\Model\Slip;

class SlipRepository implements SlipRepositoryInterface
{

  protected $slip;

  public function __construct(Slip $slip)
  {
    $this->slip = $slip;
  }

  public function monthlyGrandTotal()
  {
    $dt_month = new \Carbon\Carbon();
    $dt_month = (int)$dt_month->month;
    return $this->slip->where('accrual_month', $dt_month)->sum('grand_total');
  }
}
