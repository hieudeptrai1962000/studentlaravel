@extends('adminlte::page')
@extends('layouts.header')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8"> @yield('content') </div>
        </div>
    </div>


    <div class="well">

        @if(isset($subject))
        {!! Form::model($subject, ['route' => ['subject.update', $subject->id], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
    @else
        {{ Form::open(array('route' => 'subject.store','method' => 'post','enctype' => "multipart/form-data")) }}
    @endif

    <fieldset>

        <legend>UPDATE</legend>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group" style="display: none">
            {!! Form::label('id', 'ID:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('id', isset($subject->id) ? $subject->id : '', ['class' => 'form-control',]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Subject:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name',isset($subject->name) ? $subject->name : '', ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- Text Area -->

    </fieldset>
    {{Form::submit('Submit', array('class' => 'btn btn-success mt-2'))}}

    {!! Form::close()  !!}
    <a href="{{route('subject.index')}}" class="btn btn-success btn-add">Back</a>
</div>
@endsection
