@extends('layouts.admin')

@section("content")
    <div class="container-fluid">
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
                        All Events
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
                ajax: '{!! route('admin.event.dt') !!}',
                columns: [
                    { title: 'id', data: 'id'},
                    { title: 'Name',data: 'name'},
                    { title: 'Parent',data: 'parent', orderable: false, searchable: false},
                    { title: 'Description',data: 'description',},
                    { title: 'Event Date',data: 'date_range', orderable: false, searchable: false},
                    { title: 'Created By',data: 'created_by'},
                    { title: 'Updated By',data: 'updated_by'},
                    { data: 'action', orderable: false, searchable: false}
                ]

            });


            $('#btn_new').on('click', function(e) {
                $.ajax({
                    url: '{{ route('admin.event.new') }}',
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

            $('body').on('click','a.btn-edit', function(e) {
                e.preventDefault()

                $.ajax({
                    url: $(this).attr('href'),
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