@extends('mainlayout')

@section("sidebar-menu")
    @include("layouts.admin.includes.sidebar")
@endsection

@section("content")
    <input type="hidden" value="{{ csrf_token() }}" id="_token">
    <div class="card">
        <div class="card-header">
            Faculty
        </div>
        <div class="card-body">
            <div id="table-alert"></div>
            <div align="right">
                <button type="button" name="add" id="add" class="btn btn-info">Add</button>
            </div>
            <table id="schedule-table" class="teble table-bordered">
                <thead>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>last Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th></th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th></th>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function(){
  
            fetch_data();

            function fetch_data(){
                var dataTable = $('#schedule-table').DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "order" : [],
                    "ajax" : {
                        url:"{{ route('admin.getteachers') }}",
                        type:"post",
                        data: {_token: $("#_token").val()}
                    }
                });
            }
            $('#add').click(function(){
                var html = '<tr>';
                html += '<td  class="bg-primary"></td>';
                html += '<td contenteditable id="data1" class="bg-primary"></td>';
                html += '<td contenteditable id="data2" class="bg-primary"></td>';
                html += '<td contenteditable id="data3" class="bg-primary"></td>';
                html += '<td contenteditable id="data4" class="bg-primary"></td>';
                html += '<td  class="bg-primary"><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
                html += '</tr>';
                $('#schedule-table tbody').prepend(html);
            });
            function update_data(id, column_name, value){
                $.ajax({
                    url:"{{ route('admin.updateteacher') }}",
                    method:"POST",
                    data:{id:id, column_name:column_name, value:value, _token: $("#_token").val()},
                    success:function(data)
                    {
                        $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                        $('#schedule-table').DataTable().destroy();
                        fetch_data();
                    }
                });
                setTimeout(function(){
                    $('#table-alert').html('');
                }, 5000);
            }
            $(document).on('blur', '.update', function(){
                var id = $(this).data("id");
                var column_name = $(this).data("column");
                var value = $(this).text();
                update_data(id, column_name, value);
            });
            $(document).on('click', '#insert', function(){
                var f_name = $('#data1').text();
                var l_name = $('#data2').text();
                var username = $('#data3').text();
                var password = $('#data4').text();
                if(f_name != ''){
                    $.ajax({
                        url:"{{ route('admin.addteacher') }}",
                        method:"POST",
                        data:{
                            f_name: f_name,
                            l_name: l_name,
                            username: username,
                            password: password,
                            _token: $("#_token").val()
                            },
                        success:function(data){
                            $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                            $('#schedule-table').DataTable().destroy();
                            fetch_data();
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
                        url:"{{ route('admin.deleteteacher') }}",
                        method:"POST",
                        data:{id:id, _token: $("#_token").val()},
                        success:function(data){
                            $('#table-alert').html('<div class="alert alert-success">'+data+'</div>');
                            $('#schedule-table').DataTable().destroy();
                            fetch_data();
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