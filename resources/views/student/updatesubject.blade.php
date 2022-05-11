<div class="container" style="">
    <div class="row">
        <div class="col-lg-8"> @yield('content') </div>
    </div>
</div>


<div class="well">

    {{ Form::open(array('route' => 'student.updatesubject','method' => 'post','enctype' => "multipart/form-data")) }}

    <fieldset>

        <legend>CREATE</legend>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <h1>STUDENT ID {{ $student->id }}</h1>
            <div class="col-lg-10">
                <input type="text" style="display: none" name="student_id" value="{{ $student->id }}">
            </div>
        </div>
        <div class="form-group">
            <h9>Subject ID</h9>
            <div class="col-lg-10">
                @foreach($subject as $su)
                    <input type="checkbox" name="subject_id[]" value="{{ $su->id }}">
                    <label>{{ $su->id }}</label><br/><br/>
                @endforeach
            </div>
        </div>
        <div class="form-group" style="display: none">
            {!! Form::label('name', 'Result:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('mark', 0, ['class' => 'form-control']) !!}
            </div>
        </div>
    </fieldset>
    {{Form::submit('Submit', array('class' => 'btn btn-success mt-2'))}}

    {!! Form::close()  !!}
    <a href="" class="btn btn-success btn-add">Back</a>
</div>
</body>

</html>
