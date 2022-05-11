

<div class="container">
    <div class="row">
        <div class="col-lg-8"> @yield('content') </div>
    </div>
</div>


<div class="well">

    {{ Form::open(array('route' => 'subject.store','method' => 'post')) }}

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
            {!! Form::label('name', 'Subject:', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-10">
                {!! Form::text('name', $value = null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!-- Text Area -->

    </fieldset>
    {{Form::submit('Submit', array('class' => 'btn btn-success mt-2'))}}

    {!! Form::close()  !!}
    <a href="{{route('subject.index')}}" class="btn btn-success btn-add">Back</a>
</div>
</body>

</html>
