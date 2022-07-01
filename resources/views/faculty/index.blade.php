@extends('adminlte::page')
@section('content')
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>FACULTIES MANAGE</h2>
                        @include('layouts.flash_message')
                    </div>
                    <button type="button" class="btn btn-light">
                        <a target="_blank" href="{{route('faculties.create')}}" class="btn btn-success"
                           style="background-color: #343a40; border-color: white">Add New</a>
                    </button>
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
                @foreach($faculties as $faculty)
                    <tr>
                        <td>
                        </td>
                        <td>{{++$i}}</td>
                        <td>{{$faculty->name}}</td>
                        <td>

                            {!! Form::model($faculty, ['route' => ['faculties.destroy', $faculty->id], 'method' => 'DELETE']) !!}

                            <a class="btn btn-primary"
                               href="{{ route('faculties.edit', $faculty->id) }}">Edit</a>

                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="margin-left: auto;margin-right: auto;width: 100%;">
                {{$faculties->links("pagination::bootstrap-4")}}
            </div>
        </div>
</div>
@endsection
