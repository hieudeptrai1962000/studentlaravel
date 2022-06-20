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
                            <p id="count-subject">{{count($all)}}</p>
                        </div>
                    </div>
                </div>
                {{ Form::open(array('route' => ['students.updatemark', $student->id],'method' => 'post','enctype' => "multipart/form-data")) }}
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Subject ID</th>
                        <th>Mark</th>
                    </tr>
                    </thead>
                    <tbody id="formadd">

                    @foreach($done as $do)
                    <tr>
                        <td>
                            <select class="form-select" name="subject_id[]" aria-label="Default select example">
                                <option value="subject">Select subject...</option>
                                <option value="{{ $do->id }}" {{ $do->id ?'selected' : ''}}>{{ $do->name}}</option>
                                @foreach($all as $di)
                                    <option value="{{ $di->id }}" >{{ $di->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        {!! Form::text('mark[]', isset($do->pivot->mark) ? $do->pivot->mark : '', ['class' => 'form-control']) !!}
                        <td>
                            <a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                            <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                        </td>

                    </tr>
                    @endforeach


                    <tr class="addform" style="display:none;">
                        <td>
                            <select class="form-select" name="subject_id[]" aria-label="Default select example">
                                <option value="subject">Select subject...</option>
                                @foreach($all as $di)
                                    <option value="{{ $di->id }}">{{ $di->name}}</option>
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

