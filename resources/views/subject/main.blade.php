@extends('layouts.header')
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>SUBJECT MANAGE</h2>
                    @include('layouts.flash_message')
                </div>
                <div class="col-sm-6">
                    <a href="{{route('subject.create')}}" class="btn btn-success" data-toggle="modal"><i
                            class="material-icons">&#xE147;</i> <span>Add New</span></a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>
                </th>
                <th>STT</th>
                <th>NAME</th>
            </tr>
            </thead>
            <tbody>
            @foreach($subject as $s)
                <tr>
                    <td>
                    </td>
                    <td>{{++$i}}</td>
                    <td>{{$s->name}}</td>
                    <td>
                        {!! Form::model($s, ['route' => ['subject.destroy', $s->id], 'method' => 'DELETE']) !!}

                        <a class="btn btn-primary"
                           href="{{ route('subject.edit', $s->id) }}">Edit</a>

                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="margin-left: auto;margin-right: auto;width: 100%;">
            {{$subject->links("pagination::bootstrap-4")}}
        </div>
    </div>
</div>
</body>
</html>
