@extends('layouts.user')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form id="newsubmission" role="form" method="POST" action="{{ route('user.publication.submit') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <fieldset>
                    <legend>Publication Detail</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="submission_event_id">Title</label>
                                {{ Form::select('submission_id', $submissionlist, [] ,["id" => "submission_id","class" => "form-control select2-single"]) }}
                            </div>
                        </div>

                        {{--<div class="col-md-6">--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="submission_event_id">Topics | Event</label>--}}
                        {{--{{ Form::select('submission_event_id', $eventlist, [] ,["id" => "submission_event_id","class" => "form-control select2-single"]) }}--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="submission_event_id">Type of Submission (Presentation)</label>--}}
                        {{--{{ Form::select('submission_type_id', \App\Models\BaseModel\SubmissionType::getlist(), [] ,["id" => "submission_type_id","class" => "form-control select2-single", "disabled"]) }}--}}

                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-6">--}}
                        {{--<div class="form-group">--}}
                        {{--<label for="publication_id">Publication</label>--}}
                        {{--<select id="publicationlist" name="publication_id" data-need="#submission_event_id" data-src="{{ url('api/publication/list') }}" class="form-control select2-single"></select>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file">Abstract File (.PDF, .DOCX)</label>
                                <div class="input-group">
                                    <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    Browse&hellip; <input name="file" type="file" style="display: none;">
                                </span>
                                    </label>
                                    <input type="text" class="form-control" required readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="form-group">--}}
                    {{--<label for="title">Title</label>--}}
                    {{--<input class="form-control" id="title" name="title" placeholder="Paper Title" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                    {{--<label for="abstract">Abstract</label>--}}
                    {{--<textarea required="" class="form-control" placeholder="Abstract" rows="10" cols="30" id="description" name="abstract"></textarea>--}}
                    {{--</div>--}}

                </fieldset>


                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            userSaveUpload("#newsubmission",
                function(d) {
                    if(d.success) {
                        showAlert('Your submission has been registered','success','Success:')
                        setTimeout(function() {
                            location.href = '{{ route('user.submission') }}'
                        }, 1000);
                    }
                },
                function(xHr) {
                    showAlert('Something when wrong.. Please contact the administrator if the problem persists','danger','Error:')
                }
            );

            $('.select2-single').select2({
                placholder: "Choose"
            })

            loadListOption("#publicationlist")
        });
    </script>
@endsection