<?php

namespace App\Http\Controllers\Slip;

use App\Model\Month_summary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Month_summaryController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('month_summary.index');
    }
}
