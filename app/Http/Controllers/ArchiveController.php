<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentInformation;
use Illuminate\Support\Facades\DB;
use App\Models\RenewApartmentContract;

class ArchiveController extends Controller
{
    public function index(){

        return view('Archive.index');
    }

    public function trashed_data(){

        // $datas = RenewApartmentContract::with(['rentinformation' => function ($query) {
        //     $query->withTrashed();
        // }])->get();

        // $datas = RenewApartmentContract::with(['rentinformation' => function ($query) {
        //     $query->whereNotNull('deleted_at')->withTrashed();
        // }])->get();



       //$datas = RentInformation::with('renewcontracts')->withTrashed()->where('deleted_at', '!=', NULL)->get();

       $datas = DB::table('rent_information')
                ->join('renew_apartment_contracts','rent_information.id','=', 'renew_apartment_contracts.rent_info_id')
                ->select('rent_information.*', 'renew_apartment_contracts.renew_start_date','renew_apartment_contracts.renew_end_date')
                ->where('rent_information.deleted_at', '!=', NULL)
                ->get();
    //  dd($datas);


        $i = 1;
        $output = '';

        if ($datas->count() > 0) {
            $output .= '<table class="table table-striped align-end" id="trashed_table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tenant Name</th>
                            <th>Room Number</th>
                            <th>Rent Fee</th>
                            <th>Status</th>
                            <th>Contract Start Date</th>
                            <th>Contract End Date</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($datas as $data) {

                $output .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $data->tenant_name . '</td>
                        <td>' . $data->room_number . '</td>
                        <td>' . $data->rent_fee . '</td>
                        <td>' . $data->status . '</td>
                        <td>' . $data->renew_start_date . '</td>
                        <td>' . $data->renew_end_date . '</td>
                        <td>' . $data->status. '</td>
                        <td>
                            <a href="#" id="' . $data->id . '" class="text-default btn btn-success btn-sm mx-1 restore">Restore</a>
                            <a href="#" id="' . $data->id . '" class="text-default btn btn-danger btn-sm mx-1 delete">Force Delete</a>
                        </td>
                    </tr>';
            }

            $output .= '</tbody></table>';
            return $output;
        }
        else{

            return '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    public function delete(Request $request){

          $data = RentInformation::withTrashed()->find($request->id)->forceDelete();

    }

    public function restore(Request $request){

        $data = RentInformation::withTrashed()->find($request->id)->restore();

  }
}
