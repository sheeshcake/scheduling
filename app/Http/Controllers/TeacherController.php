<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Teacher;

use Hash;

class TeacherController extends Controller
{
    public function index(){
        return view("layouts.admin.teachers");
    }

    public function get(){
        $teachers = Teacher::orderBy("id", "desc")->get()->toArray();
        $allteachers = [];
        $counter = 0;
        foreach($teachers as $data){
            $allteachers[$counter][0] = '<div class="text-dark">' . $data["id"] . '</div>';
            $allteachers[$counter][1] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="f_name">' . $data["f_name"] . '</div>';
            $allteachers[$counter][2] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="l_name">' . $data["l_name"] . '</div>';
            $allteachers[$counter][3] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="username">' . $data["username"] . '</div>';
            $allteachers[$counter][4] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="password">' . $data["plain_password"] . '</div>';
            $allteachers[$counter][5] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$data["id"].'">Delete</button>';
            $counter++;
        }
        $output = array(
            "draw" => 1,
            "recordsTotal" => count($teachers),
            "recordsFiltered" => count($teachers),
            "data" => $allteachers,
        );
        return json_encode($output);
    }

    public function create(Request $request){
        $data = Teacher::create($request->except("_token", "password") + ["plain_password" => $request->password, "password" => Hash::make($request->password)]);
        if($data){
            echo "Teacher Added!";
        }else{
            echo "Error adding teacher";
        }
    }

    public function delete(Request $request){
        $data = Teacher::where("id", "=", $request->id)->delete();
        if($data){
            echo "Teacher Deleted!";
        }else{
            echo "Error deleting teacher";
        }
    }

    public function update(Request $request){
        $update;
        if($request->column_name == "plain_password"){
            $update = [
                "plain_password" => $request->value,
                "password" => Hash::make($request->value)
            ];
        }else{
            $update = [
                $request->column_name => $request->value
            ];
        }
        $data = Teacher::where("id", "=", $request->id)->update($update);
        if($data){
            echo "Teacher Updated!";
        }else{
            echo "Error updating teacher";
        }
    }
}
