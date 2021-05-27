<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;

class RoomController extends Controller
{
    public function index(){
        return view("layouts.admin.rooms");
    }

    public function get(){
        $room = Room::orderBy("id", "desc")->get()->toArray();
        $allroom = [];
        $counter = 0;
        foreach($room as $data){
            $allroom[$counter][0] = '<div class="text-dark">' . $data["id"] . '</div>';
            $allroom[$counter][1] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="room_name">' . $data["room_name"] . '</div>';
            $allroom[$counter][2] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$data["id"].'">Delete</button>';
            $counter++;
        }
        $output = array(
            "draw" => 1,
            "recordsTotal" => count($room),
            "recordsFiltered" => count($room),
            "data" => $allroom,
        );
        return json_encode($output);
    }

    public function create(Request $request){
        $data = Room::create($request->except("_token"));
        if($data){
            echo "Room Added!";
        }else{
            echo "Error adding Room";
        }
    }

    public function delete(Request $request){
        $data = Room::where("id", "=", $request->id)->delete();
        if($data){
            echo "Room Deleted!";
        }else{
            echo "Error deleting Room";
        }
    }

    public function update(Request $request){
        $data = Room::where("id", "=", $request->id)->update(
            [$request->column_name => $request->value]
        );
        if($data){
            echo "Room Updated!";
        }else{
            echo "Error updating Room";
        }
    }
}
