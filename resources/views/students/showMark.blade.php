@extends('adminlte::page')
@section('content')
    <body>
    <div class="container">
        <div class="table-responsive">
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
                            <button style="color: black;margin-left: 500px" id="btnaddmore">Add More</button>
                            <p id="count-subject" style="display: none">{{count($allSubject)}}</p>
                        </div>
                    </div>
                </div>
                {{ Form::open(array('route' => ['updateSubjectAndMark', $student->id],'method' => 'post','enctype' => "multipart/form-data")) }}
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Subject ID</th>
                        <th>Mark</th>
                    </tr>
                    </thead>
                    <tbody id="formadd">
                    @foreach($subjectDones as $subjectDone)
                    <tr>
                        <td>
                            <select id="formtest" class="form-control" name="subject_id[]" aria-label="Default select example">
                                <option value="select">Select subject...</option>
                                <option value="{{ $subjectDone->id }}" {{ $subjectDone->id ?'selected' : ''}}>{{ $subjectDone->name}}</option>
                                @foreach($allSubject as $subject)
                                    <option value="{{ $subject->id }}" >{{ $subject->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        {!! Form::text('mark[]', isset($subjectDone->pivot->mark) ? $subjectDone->pivot->mark : '', ['class' => 'form-control']) !!}
                        <td>
                        <td>
                            <a href="#" class="delete" title="Delete" data-toggle="tooltip"><h2 style="color: black">X</h2></a>
                        </td>

                    </tr>
                    @endforeach
                    <tr class="addform" style="display:none;">
                        <td>
                            <select class="form-control" name="subject_id[]" aria-label="Default select example">
                                <option value="select">Select subject...</option>
                                @foreach($allSubject as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        {!! Form::text('mark[]', 0, ['class' => 'form-control']) !!}
                        <td>
                        <td>
                            <a href="#" class="delete" title="Delete" data-toggle="tooltip"><h2 style="color: black">X</h2></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                {{Form::submit('Save', ['class'=> 'btn btn-success','id'=>'saveform'])}}
                {!! Form::close()  !!}
            </div>
        </div>
    </div>
    <script>
        $("#formtest option").each(function() {
            $(this).siblings('[value="'+ this.value +'"]').remove();
        });
        $(document).ready(function () {
            form = $('tr.addform').html();
            $("#btnaddmore").click(function () {
                var len = $('tbody#formadd tr').length;
                var subject = $('p#count-subject').html();

                if (len - 1 < subject) {
                    $("tbody").append('<tr>' + form + '</tr>');
                } else {
                    alert('Đã đủ môn học');
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
@endsection

