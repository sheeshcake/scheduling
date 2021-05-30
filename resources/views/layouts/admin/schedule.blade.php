@extends('mainlayout')

@section("sidebar-menu")
    @include("layouts.admin.includes.sidebar")
@endsection

@section("content")
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<input type="hidden" value="{{ csrf_token() }}" id="_token">
    <div class="card">
        <div class="card-header">
            Subjects
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col">
                    <label for="teachert">Faculty</label>
                    <select name="teacher_id" id="teacher" class="select-picker form-control" data-live-search="true">
                        @foreach($data['teachers'] as $teacher)
                            <option value="{{ $teacher['id'] }}">{{ $teacher['f_name'] . " " . $teacher['l_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div id="table-alert"></div>
            <div class="row">
                <div class="col">
                    <label for="room">Subject</label><br>
                    <select name="room_id" id="subject" class="select-picker form-control" data-live-search="true" >
                        @foreach($data['subjects'] as $subject)
                            <option value="{{ $subject['id'] }}">{{ $subject['subject_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="room">Room</label><br>
                    <select name="room_id" id="room" class="select-picker form-control" data-live-search="true" >
                        @foreach($data['rooms'] as $room)
                            <option value="{{ $room['id'] }}">{{ $room['room_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <label for="">Day</label><br>
                    <select id="day" multiple data-live-search="true" class="select-picker">
                        <option value="0">Sunday</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="time">Time Start</label>
                    <input type="time" class="form-control" id="time_start">
                </div>
                <div class="form-group col">
                    <label for="time">Time End</label>
                    <input type="time" class="form-control" id="time_end">
                </div>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label for="time">Date Start</label>
                    <input type="date" class="form-control" id="date_start">
                </div>
                <div class="form-group col">
                    <label for="time">Date End</label>
                    <input type="date" class="form-control" id="date_end">
                </div>
            </div>
            <div align="right">
                <button type="button" name="add" id="add" class="btn btn-info">Add Schedule</button>
            </div>
            <table id="schedule-table" class="teble table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Room Name</th>
                    <th>Subject Name</th>
                    <th>Time</th>
                    <th>Day</th>
                    <th></th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <th>ID</th>
                    <th>Room Name</th>
                    <th>Subject Name</th>
                    <th>Time</th>
                    <th>Day</th>
                    <th></th>
                </tfoot>
            </table>
            <div class="row">
                <div id="calendar"></div>
            </div>
            
        </div>
    </div>
    <script>
        var calendar = $("#calendar").fullCalendar({
            height: 600,
            plugins: [ 'dayGrid', 'interaction' ],
            events: []
        });
        $(document).ready(function(){
            $('.select-picker').selectpicker();
            fetch_data($("#teacher").val());
            function fetch_data(id){
                var dataTable = $('#schedule-table').DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "order" : [],
                    "ajax" : {
                        url:"{{ route('admin.getschedules') }}",
                        type:"post",
                        data: {_token: $("#_token").val(), id: id}
                    }
                });
                $.ajax({
                    url: "{{ route('admin.getcalendar') }}",
                    type: "post",
                    data: {_token: $("#_token").val(), id: id},
                    success: function(d){
                        $("#calendar").fullCalendar('removeEvents'); 
                        $("#calendar").fullCalendar('addEventSource', JSON.parse(d)); 
                    }
                });

            }
            $(document).on('click', '#add', function(){
                var teacher_id = $('#teacher').val();
                var subject_id = $('#subject').val();
                var room = $('#room').val();
                var day = $('#day').val();
                var time_start = $("#time_start").val();
                var time_end = $("#time_end").val();
                var month_start = $("#date_start").val();
                var month_end = $("#date_end").val();
                if(teacher_id != ''){
                    $.ajax({
                        url:"{{ route('admin.addschedule') }}",
                        method:"POST",
                        data:{
                            teacher_id: teacher_id,
                            subject_id: subject_id,
                            room_id: room,
                            schedule_day: day,
                            schedule_time_start: time_start,
                            schedule_time_end: time_end,
                            start_month: month_start,
                            end_month: month_end,
                            _token: $("#_token").val()
                            },
                        success:function(data){
                            $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                            $('#schedule-table').DataTable().destroy();
                            fetch_data($("#teacher").val());
                        }
                    });
                    setTimeout(function(){
                        $('#table-alert').html('');
                    }, 5000);
                }
                else{
                    alert("Both Fields is required");
                }
            });
            $(document).on('click', '.delete', function(){
                var id = $(this).attr("id");
                if(confirm("Are you sure you want to remove this?")){
                    $.ajax({
                        url:"{{ route('admin.deleteschedule') }}",
                        method:"POST",
                        data:{id:id, _token: $("#_token").val()},
                        success:function(data){
                            $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                            $('#schedule-table').DataTable().destroy();
                            fetch_data($("#teacher").val());
                        }
                    });
                    setTimeout(function(){
                        $('#table-alert').html('');
                    }, 5000);
                }
            });
        });
    </script>
@endsection