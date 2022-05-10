@extends('layouts.header')
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>FACULTIES MANAGE</h2>
                    @include('layouts.flash_message')
                </div>
                <div class="col-sm-6">
                    <a href="{{route('faculty.create')}}" class="btn btn-success" data-toggle="modal"><i
                            class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
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
            </tr>
            </thead>
            <tbody>
            @foreach($faculty as $facultyinfor)
                <tr>
                    <td>
                    </td>
                    <td>{{$facultyinfor->id}}</td>
                    <td>{{$facultyinfor->name}}</td>
                    <td>
                        {{  Form::open(array('route' => array('faculty.edit', $facultyinfor->id), 'method'=>'get')) }}

                        <form>
                            {{ csrf_field() }}
                            {{ method_field('GET') }}
                            <div class="edit">
                                <input type="submit" class="btn" value="Edit">
                            </div>

                            {!! Form::close()  !!}
                            {!! Form::close()  !!}
                            {{  Form::open(array('route' => array('faculty.destroy', $facultyinfor->id), 'method'=>'post')) }}
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
            {{$faculty->links("pagination::bootstrap-4")}}
        </div>
    </div>
</div>
</body>
</html>
