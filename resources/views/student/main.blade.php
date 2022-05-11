@extends('layouts.header')
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>STUDENT MANAGE</h2>
                    @include('layouts.flash_message')
                </div>
                <div class="col-sm-6">
                    <a href="{{route('student.create')}}" class="btn btn-success" data-toggle="modal"><i
                            class="material-icons">&#xE147;</i> <span>Add New</span></a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>
                </th>
                <th>ID</th>
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
                    <td>{{$studentinfor->gender}}</td>
                    <td>{{$studentinfor->phone_number}}</td>
                    <td><img width="auto" height="150px" src="{{asset(''.$studentinfor->image)}}"></td>
                    <td>{{$studentinfor->faculty_id}}</td>
                    <td>
                        {{  Form::open(array('route' => array('student.edit', $studentinfor->id), 'method'=>'get')) }}

                        <form>
                            {{ csrf_field() }}
                            {{ method_field('GET') }}
                            <div class="edit">
                                <input type="submit" class="btn" value="Edit">
                            </div>

                            {!! Form::close()  !!}
                            {!! Form::close()  !!}
                            {{  Form::open(array('route' => array('student.destroy', $studentinfor->id), 'method'=>'post')) }}
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="delete">
                                <input type="submit" onclick="return confirm('Are you sure?')"
                                       class="btn" value="Delete">
                            </div>
                        {!! Form::close()  !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="margin-left: auto;margin-right: auto;width: 100%;">
            {{$student->links("pagination::bootstrap-4")}}
        </div>
    </div>
</div>
</body>
</html>
