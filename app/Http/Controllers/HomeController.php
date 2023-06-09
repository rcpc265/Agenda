<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function generatePDF()
    {
        $legalVisits = Visit::join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->where('visitors.entity', 'Persona jurídica')
            ->get();

        $naturalVisits = Visit::join('visitors', 'visits.visitor_id', '=', 'visitors.id')
            ->where('visitors.entity', 'Persona natural')
            ->get();

        $pdf = Pdf::loadView('visits.pdf', compact('legalVisits', 'naturalVisits'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
