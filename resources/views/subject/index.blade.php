@extends('adminlte::page')
@section('content')
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>SUBJECT MANAGE</h2>
                    @include('layouts.flash_message')
                </div>
                <div class="col-sm-6">
                    <a href="{{route('subjects.create')}}" class="btn btn-success"><i
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
            @foreach($subjects as $subject)
                <tr>
                    <td>
                    </td>
                    <td>{{$subject->id}}</td>
                    <td>{{$subject->name}}</td>
                    <td>
                        {!! Form::model($subject, ['route' => ['subjects.destroy', $subject->id], 'method' => 'DELETE']) !!}

                        <a class="btn btn-primary"
                           href="{{ route('subjects.edit', $subject->id) }}">Edit</a>

                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="margin-left: auto;margin-right: auto;width: 100%;">
            {{$subjects->links("pagination::bootstrap-4")}}
        </div>
    </div>
</div>
@endsection
