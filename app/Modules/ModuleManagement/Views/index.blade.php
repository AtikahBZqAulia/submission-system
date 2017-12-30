@extends('layouts.admin')

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-inline pull-right">
                            <button id="btn_new" class="btn btn-primary">New</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        All User Data
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <table id="datalist" class="table table-responsive">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function() {
            $('#datalist').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.module.dt') !!}',
                columns: [
                    { title: 'id', data: 'id'},
                    { title: 'Name',data: 'name'},
                    { title: 'Description',data: 'description',},
                    { title: 'Folder Path',data: 'pathname', orderable: false, searchable: false},
                    { title: 'Created By',data: 'created_by'},
                    { title: 'Updated By',data: 'updated_by'},
                    { data: 'action', orderable: false, searchable: false}
                ]

            });

            $('#btn_new').on('click', function(e) {
                $.ajax({
                    url: '{{ route('admin.module.newmodule') }}',
                    method: 'GET',
                    success: function(response) {
                        $("#modal-container").html(response);
                        $(".modal", "#modal-container").modal();
                    },
                    error: function(xHr) {
                        console.log(xHr);
                    }
                });
            });
        });
    </script>

@endsection