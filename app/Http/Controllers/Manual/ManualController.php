<?php

namespace App\Http\Controllers\Manual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManualController extends Controller
{
    public function index()
    {
        return view('manual.index');
    }

    public function defect()
    {
        return view('manual.defect');
    }

    public function slip()
    {
        return view('manual.slip');
    }

    public function month_slip()
    {
        return view('manual.month_slip');
    }

    public function years_slip()
    {
        return view('manual.years_slip');
    }

    public function subject()
    {
        return view('manual.subject');
    }

    public function account()
    {
        return view('manual.account');
    }

}
