@extends('mainlayout')

@section("sidebar-menu")
    @include("layouts.admin.includes.sidebar")
@endsection

@section("content")
    <input type="hidden" value="{{ csrf_token() }}" id="_token">
    <div class="card">
        <div class="card-header">
            Subjects
        </div>
        <div class="card-body">
            <div id="table-alert"></div>
            <div align="right">
                <button type="button" name="add" id="add" class="btn btn-info">Add</button>
            </div>
            <table id="schedule-table" class="teble table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Subject Unit</th>
                    <th>Subject Description</th>
                    <th></th>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <th>ID</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Subject Unit</th>
                    <th>Subject Description</th>
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
                        url:"{{ route('admin.getsubjects') }}",
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
                    url:"{{ route('admin.updatesubject') }}",
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
                var subject_name = $('#data1').text();
                var subject_code = $('#data2').text();
                var subject_unit = $('#data3').text();
                var subject_description = $('#data4').text();
                if(subject_name != ''){
                    $.ajax({
                        url:"{{ route('admin.addsubject') }}",
                        method:"POST",
                        data:{
                            subject_name: subject_name,
                            subject_code: subject_code,
                            subject_unit: subject_unit,
                            subject_description: subject_description,
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
                        url:"{{ route('admin.deletesubject') }}",
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