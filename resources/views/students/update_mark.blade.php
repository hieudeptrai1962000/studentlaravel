@extends('layouts.javas')
@extends('adminlte::page')
@extends('layouts.header')
@section('content')
    <body>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-5">
                            <h2>User <b>Management</b></h2>
                        </div>
                        <div class="col-xs-7">
                        <button style="color: black" id="btn">Add More</button>
                        <p id="count-subject">{{count($subject)}}</p>
                    </div>
                </div>
            </div>
                {{ Form::open(array('route' => 'students.updatemark','method' => 'post','enctype' => "multipart/form-data")) }}
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Subject ID</th>
                    <th>Mark</th>
                </tr>
                </thead>
                <tbody id="formadd">
{{--                <input type="text" name="student_id" style="display: none" value="{{ $student->id }}">--}}


                <tr>



                    <td>
                        <select class="form-select" name="subject_id[]" aria-label="Default select example">
                                <option value="{{ $mark->id }}">{{ $mark->id}}</option>
                        </select>
                    </td>
                    <td>
                    {!! Form::text('mark[]', 0, ['class' => 'form-control']) !!}
                    <td>
                        <a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                        <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                    </td>

                </tr>



                <tr class="addform" style="display:none;">
                    <td>
                        <select class="form-select" name="subject_id[]" aria-label="Default select example">
                            @foreach($subject as $s)
                                <option value="{{ $s->id }}">{{ $s->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    {!! Form::text('mark[]', 0, ['class' => 'form-control']) !!}
                    <td>
                    <td>
                        <a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                        <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                    </td>
                </tr>
                </tbody>
            </table>
            {{Form::submit('Save', ['class'=> 'btn btn-success','id'=>'saveform'])}}
            {!! Form::close()  !!}
        </div>
    </div>
</div>
@endsection

