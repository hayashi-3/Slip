<?php

namespace App\Http\Controllers\Ajax;

use App\Model\Slip;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SlipController extends Controller
{
    public function index(Request $request) {
        $dt_from = new \Carbon\Carbon();
		$dt_from->startOfMonth();
		$dt_to = new \Carbon\Carbon();
		$dt_to->endOfMonth();

        return Slip::whereBetween('accrual_date', [$dt_from, $dt_to])->get();
    }
}
