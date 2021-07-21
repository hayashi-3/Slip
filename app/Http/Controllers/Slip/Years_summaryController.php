<?php

namespace App\Http\Controllers\Slip;

use App\Model\Years_summary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Years_summaryController extends Controller
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
        return view('years_summary.index');
    }
}
