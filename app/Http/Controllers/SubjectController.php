<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subject;

class SubjectController extends Controller
{
    public function index(){
        return view("layouts.admin.subjects");
    }

    public function get(){
        $subjects = Subject::orderBy("id", "desc")->get()->toArray();
        $allsubjects = [];
        $counter = 0;
        foreach($subjects as $data){
            $allsubjects[$counter][0] = '<div class="text-dark">' . $data["id"] . '</div>';
            $allsubjects[$counter][1] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="subjects_link">' . $data["subject_name"] . '</div>';
            $allsubjects[$counter][2] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="subject_code">' . $data["subject_code"] . '</div>';
            $allsubjects[$counter][3] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="subject_unit">' . $data["subject_unit"] . '</div>';
            $allsubjects[$counter][4] = '<div contenteditable class="update text-dark" data-id="'.$data["id"].'" data-column="subject_description">' . $data["subject_description"] . '</div>';
            $allsubjects[$counter][5] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$data["id"].'">Delete</button>';
            $counter++;
        }
        $output = array(
            "draw" => 1,
            "recordsTotal" => count($subjects),
            "recordsFiltered" => count($subjects),
            "data" => $allsubjects,
        );
        return json_encode($output);
    }

    public function create(Request $request){
        $data = Subject::create($request->except("_token"));
        if($data){
            echo "Subject Added!";
        }else{
            echo "Error adding subject";
        }
    }

    public function delete(Request $request){
        $data = Subject::where("id", "=", $request->id)->delete();
        if($data){
            echo "Subject Deleted!";
        }else{
            echo "Error deleting subject";
        }
    }

    public function update(Request $request){
        $data = Subject::where("id", "=", $request->id)->update(
            [$request->column_name => $request->value]
        );
        if($data){
            echo "Subject Updated!";
        }else{
            echo "Error updating subject";
        }
    }

}
