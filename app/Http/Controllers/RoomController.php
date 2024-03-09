<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(){

        return view('Room.index');
    }

    public function store(Request $request){

        $validator = \Validator::make($request -> all(),[
            'room_number'  => 'required',
            'room_status'  => 'required',
        ]);

        if($validator -> fails()){

            return response()->json([
                'code' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        }
        else{

            $create = new Room();
            $create -> room_number = $request->room_number;
            $create -> room_status = $request->room_status;
            $create->save();

            return response()->json([
                'code' => 200,
                'msg' => 'Created Successfully',
            ]);
        }

    }

    public function fetch() {

        $datas = Room::all();
        $i = 1;
        $output = '';
        if ($datas->count() > 0) {
            $output .= '<table class="table table-striped align-end" id="room">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Room Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($datas as $data) {
                $output .= '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $data->room_number . '</td>
                        <td>' . $data->room_status . '</td>
                        <td>
                            <a href="#" id="' . $data->id . '" class="text-default  btn btn-success btn-sm mx-1 edit" data-bs-toggle="modal" data-bs-target="#edit">Edit</a>
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

		$data = Room::find($request->id);

		return response()->json($data);
	}

    public function update(Request $request){

        $validator = \Validator::make($request -> all(),[

            'room_number'  => 'required',
            'room_status'  => 'required',
        ]);

        if($validator -> fails()){
            return response()->json([
                'code' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        }
        else{

            $update = Room::find($request->edit_id);
            $update -> room_number = $request->room_number;
            $update -> room_status = $request->room_status;
            $update->update();
            return response()->json([
                'code' => 200,
                'msg' => 'Updated Successfully',
            ]);
        }
    }

    // public function delete(Request $request){

    //     $data = Room::find($request->id);
    //     Room::destroy($request->id);
    // }

}
