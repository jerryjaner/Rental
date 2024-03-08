<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentInformation;

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
        $data = RentInformation::selectRaw('MONTH(date) as month, status, COUNT(*) as count')
        ->whereIn('status', ['Paid', 'UnPaid'])
        ->groupBy('month', 'status')
        ->get();

        return view('home', compact('data'));
    }
}
