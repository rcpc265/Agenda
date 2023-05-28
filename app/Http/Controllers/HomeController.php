<?php

namespace App\Http\Controllers;

use App\Models\Visit;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Retrieve all visits that are scheduled within the next 6 months, as well as those that occurred within the past 3 months.
        $visits = Visit::where('start_date', '>=', date('Y-m-d', strtotime('-3 months')))->where('start_date', '<=', date('Y-m-d', strtotime('+6 months')))->get(['id', 'subject', 'start_date', 'end_date', 'status']);
        return view('home', compact('visits'));
    }
}
