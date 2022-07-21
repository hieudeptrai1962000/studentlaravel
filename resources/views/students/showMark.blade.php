@extends('adminlte::page')
@section('content')
    @php
        if(!empty(old('subject_id'))) {
            $subject_ids = old('subject_id');
            $marks = old('mark');
        }
    @endphp
    <a class="btn btn-outline-success" href="{{route('students.index')}}">Back to Main Page</a>
    <body>
    <div class="container">
        <div class="table">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-5">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="col-xs-7">
                            <button class="btn btn-outline-success" style="margin-left: 500px" id="btnaddmore">Add
                                More
                            </button>
                            <p id="count-subject" style="display: none">{{count($allSubject)}}</p>
                        </div>
                    </div>
                </div>
                {{ Form::open(array('route' => ['updateSubjectAndMark', $student->id],'method' => 'post','enctype' => "multipart/form-data", 'id' => 'myForm')) }}
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Subject ID</th>
                        <th>Mark</th>
                    </tr>
                    </thead>
                    <tbody id="formadd">
                    @foreach($marks as $key => $mark)
                        <tr>
                            <td>
                                {!! Form::select('subject_id[]', $allSubject, (int)$subject_ids[$key], ['class' => 'form-control']) !!}
                            </td>
                            <td>
                            {!! Form::text('mark[]', $mark, ['class' => 'form-control']) !!}
                            <td>
                            <td>
                                <a href="#" class="btn btn-outline-danger delete" title="Delete" data-toggle="tooltip">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="addform" style="display:none;">
                        <td>
                            {!! Form::select('subject_id[]', $allSubject, null, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                        {!! Form::text('mark[]', 0, ['class' => 'form-control']) !!}
                        <td>
                        <td>
                            <a href="#" class="btn btn-outline-danger delete" title="Delete" data-toggle="tooltip">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                {{Form::submit('Save', ['class'=> 'btn btn-outline-dark','id'=>'saveform'])}}
                {!! Form::close()  !!}
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            form = $('tr.addform').html();
            $("#btnaddmore").click(function () {
                var len = $('tbody#formadd tr').length;
                var subject = $('p#count-subject').html();

                if (len < subject) {
                    $("tbody").append('<tr>' + form + '</tr>');
                } else {
                    $("#btnaddmore").hide();
                }
            });
            $(document).on('click', '.delete', function () {
                $(this).parent().parent().remove();
                var $select = $("select");
                var selected = [];
                $.each($select, function (index, select) {
                    if (select.value !== "") {
                        selected.push(select.value);
                        $("#btnaddmore").show();
                    }
                });
            });

            $(document).on('click', 'select', function () {

                var $select = $("select");
                var selected = [];
                $.each($select, function (index, select) {
                    if (select.value !== "") {
                        selected.push(select.value);
                    }
                });
                $('select > option').not(this).css('display', 'block');
                $("option").prop("disabled", false);
                for (var index in selected) {
                    $('option[value="' + selected[index] + '"]').hide();
                }
                $(this).parent().parent().find('td > i.remove-item').on('click', function () {
                    var del = $(this).val();
                    selected.splice(selected.indexOf(del.toString()), 1);
                    for (var index in selected) {
                        $('option[value="' + selected[index] + '"]').show();
                    }
                });
            });

            $('#saveform').on('click', function () {
                $('tr.addform').remove();
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\UpdateMarkRequest::class, 'form'); !!}
@endsection

