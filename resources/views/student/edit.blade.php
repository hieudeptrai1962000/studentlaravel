<div class="container">
    <div class="row">
        <div class="col-lg-8"> @yield('content') </div>
    </div>
</div>


<div class="well">

    {{  Form::open(array('route' => array('student.update', $student->id), 'method'=>'put','enctype'=>'multipart/form-data'))   }}

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
            {!! Form::label('full_name', 'Full Name:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('full_name', $student->full_name, ['class' => 'form-control', 'placeholder' => 'Khoa']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('email', $student->email, ['class' => 'form-control', 'placeholder' => 'Khoa']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('birthday', 'Birthday:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::date('birthday', $student->birthday, ['class' => 'form-control', 'placeholder' => 'Khoa']) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('gender', 'Gender:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                <label class="radio-inline">
                    {{Form::radio('gender', '0', true)}} Nam
                </label>
                <label class="radio-inline">
                    {{Form::radio('gender', '1', true)}} Nữ
                </label>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('phone_number', 'Phone Number:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('phone_number', $student->phone_number, ['class' => 'form-control', 'placeholder' => 'Khoa']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10">
                <h9>Avatar</h9>
                <input type="file" name="image" value="">
            </div>
        </div>

        <div class="form-group">

            <h9>Faculty ID:</h9>
            <div class="col-lg-10">
                <select class="form-control" name="faculty_id">
                    @foreach($faculty as $f)
                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


    </fieldset>
    {{Form::submit('Submit', array('class' => 'btn btn-success mt-2'))}}

    {!! Form::close()  !!}
    <a href="{{route('student.index')}}" class="btn btn-success btn-add">Back</a>
</div>
</body>

</html>

