<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\RentInformation;
use App\Models\RenewApartmentContract;
use Carbon\Carbon;

class RentController extends Controller
{
    public function index(){

        // $rooms = Room::where('room_status', 'Available')->get();
        return view('ApartmentRent.index');
    }

    public function getAvailableRooms() {
        $rooms = Room::where('room_status', 'Available')->get();
        return response()->json($rooms);
    }


    public function store(Request $request){

        $validator = \Validator::make($request -> all(),[

            'tenant_name' => 'required',
            'room_number'  => 'required',
            'date' => 'required',
            'status'  => 'required',
            'rent_fee'  => 'required',

        ]);

        if($validator -> fails()){
            return response()->json([
                'code' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        }
        else{

            $create = new RentInformation();
            $create -> tenant_name = $request->tenant_name;
            $create -> date = $request->date;
            $create -> room_number = $request->room_number;
            $create -> status = $request->status;
            $create -> rent_fee = $request->rent_fee;
            $create->save();


            foreach ($request->inputs as $key => $value) {
                $value['rent_info_id'] =  $create->id;
                RenewApartmentContract::create($value);
            }

            return Room::where('room_number', '=', $request -> room_number)->update(['room_status'=> 'Not Available']);

            return response()->json([
                'code' => 200,
                'msg' => 'Created Successfully',
            ]);

        }

    }

    public function fetch() {

        $datas = RentInformation::all();
        $i = 1;
        $output = '';
        if ($datas->count() > 0) {
            $output .= '<table class="table table-striped align-end" id="sample1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tenant Name</th>
                            <th>Date</th>
                            <th>Room Number</th>
                            <th>Rent Fee</th>
                            <th>Tenant Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($datas as $data) {
                $output .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $data->tenant_name . '</td>
                        <td>' . $data->date . '</td>
                        <td>' . $data->room_number . '</td>
                        <td>' . $data->rent_fee . '</td>
                        <td>' . $data->status . '</td>
                        <td>
                            <a href="#" id="' . $data->id . '" class="text-default  btn btn-success btn-sm mx-1 edit" data-bs-toggle="modal" data-bs-target="#edit">Edit</a>
                            <a href="#" id="' . $data->id . '" class="text-default btn btn-danger btn-sm mx-1 delete">Delete</a>
                         </td>
                    </tr>';
            }

            $output .= '</tbody></table>';
            echo $output;
        }
        else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }

	}

    public function edit(Request $request) {

		$data = RentInformation::with('renewcontracts')->find($request->id);

		return response()->json($data);
	}

    public function update(Request $request){

        $validator = \Validator::make($request -> all(),[

            'tenant_name' => 'required',
            'room_number'  => 'required',
            'date' => 'required',
            'status'  => 'required',
            'rent_fee'  => 'required',


        ]);

        if($validator -> fails()){
            return response()->json([
                'code' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        }
        else{

            $update = RentInformation::find($request->edit_id);
            $update -> tenant_name = $request->tenant_name;
            $update -> date = $request->date;
            $update -> room_number = $request->room_number;
            $update -> status = $request->status;
            $update -> rent_fee = $request->rent_fee;
            $update->update();

            $canInsert = true;

            foreach ($request->inputs as $key => $value) {
                // Check if any value is null
                foreach ($value as $inputValue) {
                    if ($inputValue === null) {
                        $canInsert = false;
                        break 2; // Break out of both loops
                    }
                }
            }

            if ($canInsert) {
                foreach ($request->inputs as $key => $value) {
                    $value['rent_info_id'] = $update->id;
                    RenewApartmentContract::create($value);
                }
            }


            return response()->json([
                'code' => 200,
                'msg' => 'Updated Successfully',
            ]);
        }

    }

    public function delete(Request $request){

        $data = RentInformation::find($request->id);
        RentInformation::destroy($request->id);
    }

}
