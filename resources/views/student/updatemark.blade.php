@extends('layouts.javas')
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
                        <p id="count-subject">{{count($mark)}}</p>
                    </div>
                </div>
            </div>
            {{ Form::open(array('route' => 'student.updatemark','method' => 'post','enctype' => "multipart/form-data")) }}
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Subject ID</th>
                    <th>Mark</th>
                </tr>
                </thead>
                <tbody id="formadd">

                <tr>

                    <td>
                        <select class="form-select" name="mark_id[]" aria-label="Default select example">
                            @foreach($mark as $m)
                                <option value="{{ $m->id }}" {{$m->id  ?'selected' : ''}}>{{ $m->subject_id }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                            {!! Form::text('mark[]', $value = null, ['class' => 'form-control']) !!}
                    <td>
                        <a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                        <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                    </td>
                </tr>

                <tr class="addform"  style="display: none">
                    <td>
                        <select class="form-select" name="mark_id[]" aria-label="Default select example">
                            @foreach($mark as $m)
                                <option value="{{ $m->id }}">{{ $m->subject_id }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    {!! Form::text('mark[]', $value = null, ['class' => 'form-control']) !!}
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
</body>

