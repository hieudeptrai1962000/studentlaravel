@extends('layouts.header')
<div class="container">
    <div class="table-wrapper">
        <div class="form-check" style="display: inline-block;margin-left: 50px">
            <form action="{{ route('age.create') }}">
                {!! Form::label('check4','Complete all subject: ',['style' => 'font-weight:bold'] ) !!}
                {{Form::checkbox('done','1',!empty(\Request::get('done')) && \Request::get('done') == 1,['id' => 'check4'])}}
                {{Form::label('check5',' Or not')}}
                {{Form::checkbox('not_done','1',!empty(\Request::get('not_done')) && \Request::get('not_done') == 1,['id' => 'check5'])}}
                {!! Form::submit('FIND', ['class' => 'btn btn-danger']) !!}
            </form>

        </div>
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>STUDENT MANAGE</h2>
                    @include('layouts.flash_message')
                </div>
                <div class="col-sm-6">
                    <a href="{{route('students.create')}}" class="btn btn-success"
                       data-toggle="modal"><span>Add New</span></a>
                </div>
                {!! Form::model(['route' => ['age.store'], 'method' => 'POST']) !!}
                {!! Form::label('Age', $value = null) !!}
                {!! Form::text('min', $value = null) !!}
                {!! Form::text('max', $value = null) !!}
                {!! Form::submit('FIND', ['class' => 'btn btn-danger']) !!}
                {!! Form::close()  !!}


            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>
                </th>
                <th>STT</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>BIRTHDAY</th>
                <th>GENDER</th>
                <th>PHONENUMBER</th>
                <th>AVATAR</th>
                <th>FACULTY ID</th>
            </tr>
            </thead>
            <tbody>
            @foreach($student as $studentinfor)
                <tr>
                    <td>
                    </td>
                    <td>{{$studentinfor->id}}</td>
                    <td>{{$studentinfor->full_name}}</td>
                    <td>{{$studentinfor->email}}</td>
                    <td>{{$studentinfor->birthday}}</td>
                    <td>
                        <?php
                        if ($studentinfor->gender == 0) {
                            echo 'Nam';
                        } else {
                            echo 'Nữ';
                        }
                        ?>
                    </td>
                    <td>{{$studentinfor->phone_number}}</td>
                    <td><img width="auto" height="150px" src="{{asset(''.$studentinfor->image)}}"></td>
                    <td>{{$studentinfor->faculty_id}}</td>

                </tr>
            @endforeach
            </tbody>
        </table
    </div>
    </body>
    </html>
