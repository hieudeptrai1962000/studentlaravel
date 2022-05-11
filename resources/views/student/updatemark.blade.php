@extends('layouts.header')
<div class="col-lg-10">
    {{ Form::open(array('route' => 'student.updatemark','method' => 'post','enctype' => "multipart/form-data")) }}
    <label>Subject ID</label>
    <select class="form-control" name="mark_id">
        @foreach($mark as $m)
            <option value="{{ $m->id }}">{{ $m->subject_id }}</option>
        @endforeach
    </select>
    <div class="form-group">
        {!! Form::label('mark', 'Mark:', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('mark', $value = null, ['class' => 'form-control']) !!}
        </div>
    </div>
    {{Form::submit('Submit', array('class' => 'btn btn-success mt-2'))}}
    {!! Form::close()  !!}
</div>
