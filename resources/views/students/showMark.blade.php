@extends('adminlte::page')
@section('content')
    <body>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-5">
                            <h2>User <b>Management</b></h2>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="col-xs-7">
                            <button style="color: black" id="btn">Add More</button>
                            <p id="count-subject">{{count($allSubject)}}</p>
                        </div>
                    </div>
                </div>
                {{ Form::open(array('route' => ['updateSubjectAndMark', $student->id],'method' => 'post','enctype' => "multipart/form-data")) }}
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Subject ID</th>
                        <th>Mark</th>
                    </tr>
                    </thead>
                    <tbody id="formadd">
                    @foreach($subjectDones as $subjectDone)
                    <tr>
                        <td>
                            <select class="form-select" name="subject_id[]" aria-label="Default select example">
                                <option value="select">Select subject...</option>
                                <option value="{{ $subjectDone->id }}" {{ $subjectDone->id ?'selected' : ''}}>{{ $subjectDone->name}}</option>
                                @foreach($allSubject as $subject)
                                    <option value="{{ $subject->id }}" >{{ $subject->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        {!! Form::text('mark[]', isset($subjectDone->pivot->mark) ? $subjectDone->pivot->mark : '', ['class' => 'form-control']) !!}
                        <td>
                            <a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                            <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                        </td>

                    </tr>
                    @endforeach
                    <tr class="addform" style="display:none;">
                        <td>
                            <select class="form-select" name="subject_id[]" aria-label="Default select example">
                                <option value="select">Select subject...</option>
                                @foreach($allSubject as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        {!! Form::text('mark[]', 0, ['class' => 'form-control']) !!}
                        <td>
                        <td>
                            <a href="#" class="settings" title="Settings" data-toggle="tooltip"><i class="material-icons">&#xE8B8;</i></a>
                            <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE5C9;</i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                {{Form::submit('Save', ['class'=> 'btn btn-success','id'=>'saveform'])}}
                {!! Form::close()  !!}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/updateMark.js') }}"></script>
@endsection

