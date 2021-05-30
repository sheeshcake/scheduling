<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subject;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\Schedule;

use Carbon\Carbon;
use DateTime;

class ScheduleController extends Controller
{
    public function index(){
        $teachers = Teacher::all()->toArray();
        $rooms = Room::all()->toArray();
        $subjects = Subject::all()->toArray();
        return view("layouts.admin.schedule")->with("data",[
            "teachers" => $teachers,
            "rooms" => $rooms,
            "subjects" => $subjects
        ]);
    }

    public function get(Request $request){
        $schedules = Schedule::join("teachers", "teachers.id", "=", "schedules.teacher_id")
                        ->join("rooms", "rooms.id", "=", "schedules.room_id")
                        ->join("subjects", "subjects.id", "=", "schedules.subject_id")
                        ->where("schedules.teacher_id", "=", $request->id)
                        ->get(['teachers.*', 'rooms.*', 'subjects.*', 'schedules.*', 'schedules.id as sched_id'])->toArray();
        $allschedules = [];
        $counter = 0;
        foreach($schedules as $data){
            $data["schedule_time_start"] = Carbon::parse($data["schedule_time_start"])->format("h:i a");
            $data["schedule_time_end"] = Carbon::parse($data["schedule_time_end"])->format("h:i a");
            $days = json_decode($data["schedule_day"]);
            foreach($days as $index => $day){
                if($day == "0"){$days[$index] = "Sunday";}
                if($day == "1"){$days[$index] = "Monday";}
                if($day == "2"){$days[$index] = "Tuesday";}
                if($day == "3"){$days[$index] = "Wednesday";}
                if($day == "4"){$days[$index] = "Thursday";}
                if($day == "5"){$days[$index] = "Friday";}
                if($day == "6"){$days[$index] = "Saturday";}
                
            }
            $data["schedule_day"] = json_encode($days);
            $allschedules[$counter][0] = '<div class="text-dark">' . $data["sched_id"] . '</div>';
            $allschedules[$counter][1] = '<div class="text-dark" data-id="'.$data["sched_id"].'" data-column="room_name">' . $data["room_name"] . '</div>';
            $allschedules[$counter][2] = '<div class="text-dark" data-id="'.$data["sched_id"].'" data-column="subject_name">' . $data["subject_name"] . '</div>';
            $allschedules[$counter][3] = '<div class="text-dark" data-id="'.$data["sched_id"].'" data-column="schedule_time">' . $data["schedule_time_start"] . " to " . $data["schedule_time_end"] . '</div>';
            $allschedules[$counter][4] = '<div class="text-dark" data-id="'.$data["sched_id"].'" data-column="schedules_day">' . str_replace(['[', '"', ']'], " ",$data["schedule_day"]) . '</div>';
            $allschedules[$counter][5] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$data["sched_id"].'">Delete</button>';
            $counter++;
        }
        $output = array(
            "draw" => 1,
            "recordsTotal" => count($schedules),
            "recordsFiltered" => count($schedules),
            "data" => $allschedules,
        );
        return json_encode($output);
    }

    public function get_calendar(Request $request){
        $schedules = Schedule::join("teachers", "teachers.id", "=", "schedules.teacher_id")
                        ->join("rooms", "rooms.id", "=", "schedules.room_id")
                        ->join("subjects", "subjects.id", "=", "schedules.subject_id")
                        ->where("schedules.teacher_id", "=", $request->id)
                        ->get()->toArray();
        $allschedules = [];
        foreach($schedules as $index => $sched){
            $allschedules[$index]["dow"] = array_map('intval', explode(',', str_replace(['[', '"', ']'], "",$sched["schedule_day"])));
            $allschedules[$index]["title"] = $sched["subject_name"];
            $allschedules[$index]["startTime"] = $sched["schedule_time_start"];
            $allschedules[$index]["endTime"] = $sched["schedule_time_end"];
            $allschedules[$index]["start"] = $sched["start_month"];
            $allschedules[$index]["end"] = $sched["end_month"];
        }
        return json_encode($allschedules);
    }

    public function create(Request $request){
        $data = Schedule::where("teacher_id", "=", $request->teacher_id)
                        ->get()->toArray();
        $conflict = false;
        foreach($data as $d){
            foreach($request->schedule_day as $day){
                if(str_contains(json_encode($d["schedule_day"]),$day)){
                    $start_time = DateTime::createFromFormat('G:i', $d["schedule_time_start"]);
                    $end_time = DateTime::createFromFormat('G:i', $d["schedule_time_end"]);
                    $request_time = DateTime::createFromFormat('G:i', $request->schedule_time_start);
                    if($request_time > $start_time && $request_time < $end_time){
                        $conflict = true;
                        $subject = Subject::where("id", "=", $d["subject_id"])->get(['subject_name']);
                        echo "<p style='color:red' >Conflict Time to " . $subject[0]['subject_name'] . "</p>";
                        break;
                    }else if($d["room_id"] == $request->room_id){
                        echo "<p style='color:red' >This room has a class to " . $subject[0]['subject_name'] . "</p>";
                        break;
                    }
                }
            }
        }
        if($conflict == false){
            $data = Schedule::create($request->except("_token", "schedule_day") + ["schedule_day" => json_encode($request->schedule_day)]);
            if($data){
                echo "Schedule Added!";
            }
        }
    }

    public function delete(Request $request){
        $data = Schedule::where("id", "=", $request->id)
                        ->delete();
        if($data){
            echo "Schedule Deleted!";
        }
    }

}
