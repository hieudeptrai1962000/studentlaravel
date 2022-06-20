@extends('adminlte::page')
@extends('layouts.header')
@section('content')
    <div class="container" style="">
        <div class="row">
            <div class="col-lg-8"> @yield('content') </div>
        </div>
    </div>
    <div class="well">

        {{ Form::open(array('route' => 'students.updatesubject','method' => 'post','enctype' => "multipart/form-data")) }}

        <fieldset>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="h1">
                <h1 style=text-align:center>STUDENT ID {{ $student->id }}</h1>
                <div class="col-lg-10">
                    <input type="text" style="display: none" name="student_id" value="{{ $student->id }}">
                </div>
            </div>
            <div class="h2">
                <div class="col-lg-10">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Subject Name</th>
                        </tr>
                        </thead>
                        @foreach($subject as $su)
                            <tbody>
                            <tr>
                                <td>{{ $su->name }}</label></td>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" name="subject_id[]"
                                               value="{{ $su->id }}" {{ $student->stu->contains($su->id) ? 'checked' : '' }}>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="form-group" style="display: none">
                {!! Form::label('name', 'Result:', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-10">
                    {!! Form::text('mark', 0, ['class' => 'form-control']) !!}
                </div>
            </div>
        </fieldset>
        {{Form::submit('Submit', array('class' => 'btn btn-dark'))}}

        {!! Form::close()  !!}
        <a style="float: left; margin-left: 100px;margin-top: -38px" href="" class="btn btn-dark">Back</a>
    </div>

@endsection
