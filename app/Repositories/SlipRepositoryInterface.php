<?php

namespace App\Repositories;

interface SlipRepositoryInterface {
  // 1ヶ月の伝票を取得
  public function monthlyGrandTotal();
}