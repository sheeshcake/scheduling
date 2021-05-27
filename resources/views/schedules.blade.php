<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.0.1/fullcalendar.js"></script>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ url('/') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/') }}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="">
<input type="hidden" value="{{ csrf_token() }}" id="_token">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>SMC</b>Scheduling</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <div class="form-group">
        <label for="">Teacher ID</label>
        <input type="number" id="teacher" class="form-control">
    </div>
    <div class="d-flex justify-content-center">
        <button class="btn btn-primary" id="get">Get Schedules</button>
    </div>
    <div class="row">
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
    </div>
    <div class="row">
        <div id="calendar"></div>
    </div>
    <style>
        .delete{
            display: none !important;
        }
    </style>
    <script>
        $("#get").click(function(){
            fetch_data($("#teacher").val());
        });
        var calendar = $("#calendar").fullCalendar({
            height: 600,
            plugins: [ 'dayGrid', 'interaction' ],
            events: []
        });
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
    </script>
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<!-- Bootstrap 4 -->
<script src="{{ url('/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('/') }}/dist/js/adminlte.min.js"></script>
</body>
</html>
