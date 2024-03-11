<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\RenewApartmentContract;

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

        return view('home');
    }

    public function get_record(Request $request) {


        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


        if($startDate == null && $endDate == Null){

        //$datas = RenewApartmentContract::with('rentinformation')->withTrashed()->get();
        //    $datas = RenewApartmentContract::with('rentinformation')->withTrashed()->get();
        $datas = RenewApartmentContract::with(['rentinformation' => function ($query) {
            $query->withTrashed();
        }])->get();


          // dd($datas);

        }
        else{

            $datas = RenewApartmentContract::with(['rentinformation' => function ($query) {
                        $query->withTrashed();
                    }])
                    ->where('renew_start_date', '>=', $startDate)
                    ->where('renew_end_date', '<=', $endDate)
                    ->get();
        }
        $i = 1;
        $output = '';

        if ($datas->count() > 0) {
            $output .= '<table class="table table-striped align-end" id="record_table">
                    <thead>
                        <tr class="border border-0">
                            <td colspan="8" class="text-center border border-0">
                                <h2>THRICE ADMIRABLE RENTAL</h2>
                            </td>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Tenant Name</th>
                            <th>Room Number</th>
                            <th>Rent Fee</th>
                            <th>Status</th>
                            <th>Contract Start Date</th>
                            <th>Contract End Date</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($datas as $data) {

                $output .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $data->rentinformation->tenant_name . '</td>
                        <td>' . $data->rentinformation->room_number . '</td>
                        <td>' . $data->rentinformation->rent_fee . '</td>
                        <td>' . $data->rentinformation->status . '</td>
                        <td>' . $data->renew_start_date . '</td>
                        <td>' . $data->renew_end_date . '</td>
                        <td>' . $data->status. '</td>
                    </tr>';
            }

            $output .= '</tbody></table>';
            return $output;
        }
        else{

            return '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }


	}
}
