@extends('adminlte::page')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <button type="button" class="btn btn-light" style="display:none">
        <a target="_blank" href="{{route('students.create')}}" class="btn btn-success"
           style="background-color: #343a40; border-color: white; margin-right: 10px">Add New</a>
    </button>
    <button type="button" class="btn btn-light">
        <a href="{{route('send-email')}}" class="btn btn-success"
           style="background-color: pink; border-color: white; margin-top: 20px">Send Mail to Bad Student</a>
    </button>
    @include('layouts.flash_message')
    <div class="form-group" style="margin-top: 20px">
        {{Form::open(['method' => 'GET', 'route' => 'search', 'class' => 'form-inline'])}}
        <div class="form-group" style="margin-right: 20px">
            {{Form::label('min1','Age from: ')}}
            {{Form::text('min_age',isset($data['min_age']) ? $data['min_age'] : null, ['class' => 'form-control','style' => 'width: 60px'])}}
            {{Form::label('max1','To: ')}}
            {{Form::text('max_age',isset($data['max_age']) ? $data['max_age'] : null, ['class' => 'form-control','style' => 'width: 60px'])}}
        </div>
        <div class="form-group">
            <label for="Subject">Subject:</label>
            <select class="form-control" id="subject_search" name="subject_id">
                <option value="">Select subject</option>
                @foreach($subjects as $subject)
                    <option class=""
                            value="{{$subject->id}}" {{isset($data['subject_id']) && ($subject->id == $data['subject_id']) ? 'selected' : ''}} >
                        {{$subject->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin-left: 20px">
            {{Form::label('mark','Mark from: ')}}
            {{Form::text('min_mark',isset($data['min_mark']) ? $data['min_mark'] : null, ['class' => 'form-control','style' => 'width: 60px'])}}
            {{Form::label('mark','To: ')}}
            {{Form::text('max_mark',isset($data['max_mark']) ? $data['max_mark'] : null, ['class' => 'form-control','style' => 'width: 60px'])}}
        </div>
        <div class="form-group" style="margin-left: 20px">
            <div style="display: inline-block;">
                <div class="form-check" style="display: inline-block">
                    {{ Form::checkbox('viettel', 1, null, ['id'=>'viettel_checkbox']) }}
                    {{Form::label('viettel_checkbox','Viettelphone')}}
                </div>

                <div class="form-check" style="display: inline-block">
                    {{ Form::checkbox('mobi', 1, null, ['id'=>'mobi_checkbox']) }}
                    {{Form::label('mobi_checkbox','Mobiphone')}}
                </div>

                <div class="form-check" style="display: inline-block">
                    {{ Form::checkbox('vina', 1, null, ['id'=>'vina_checkbox']) }}
                    {{Form::label('vina_checkbox','Vinaphone')}}
                </div>

            </div>


            <div class="form-group" style="margin-left: 20px">
                {{Form::label('learn_status','Finished: ')}}
                {{Form::select('learn_status',['all'=> 'All','finished'=>'Finished', 'unfinished'=>'Unfinished'], request('learn_status'))}}
            </div>
            <div style=" display: block;margin-left: 20px">
                <button type="submit" class="btn btn-info"><i class="fa fa-gamepad" aria-hidden="true"></i></button>
            </div>
            {{Form::close()}}
        </div>

        <div style="margin-top: 20px">
            <a href="{!! route('user.change-language', ['en']) !!}">{{ __('main.english') }}</a>
            <a href="{!! route('user.change-language', ['vi']) !!}">{{ __('main.vietnam') }}</a>
        </div>

        <table id="ajaxcontent" class="table table-striped table-hover" style="margin-top: 20px">
            <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">{{ __('main.fullname') }}</th>
                <th scope="col">Email</th>
                <th scope="col">{{ __('main.birthday') }}</th>
                <th scope="col">{{ __('main.gender') }}</th>
                <th scope="col">{{ __('main.phonenumber') }}</th>
                <th scope="col">{{ __('main.avatar') }}</th>
                <th scope="col">{{ __('main.action') }}</th>
                {{--                <th scope="col">Faculty ID</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr id="tr{{$student->id}}">
                    <td scope="col" id="{{'student_id_'.$student->id}}">{{$student->id}}</td>
                    <td id="{{'student_name_'.$student->id}}" scope="col">{{$student->full_name}}</td>
                    <td id="{{'student_email_'.$student->id}}" scope="col">{{$student->email}}</td>
                    <td id="{{'student_birthday_'.$student->id}}"
                        scope="col">{{$student->birthday}}</td>


                    <td id="{{'student_gender_'.$student->id}}" scope="col">
                        <?php
                        if ($student->gender == 0) {
                            echo 'Nam';
                        } else {
                            echo 'Nữ';
                        }
                        ?>
                    </td>
                    <td id="{{'student_phone_'.$student->id}}" scope="col">{{$student->phone_number}}</td>
                    <td id="{{'student_image_'.$student->id}}" scope="col"><img id="{{'new_image_'.$student->id}}"
                                                                                src="{{asset(url_file( $student ->image))}}" alt="" class="img img-responsive"
                                                                                width="50px"></td>


                    <td>
                        {!! Form::model($student, ['route' => ['students.destroy', $student->id], 'method' => 'DELETE', 'id' => 'FormDelete']) !!}
                        <a style="display:none" class="btn btn-primary"
                           href="{{ route('students.edit',$student->id ) }}">Edit</a>
                        <a class="btn btn-primary"
                           href="{{ route('createSubjectAndMark', $student->id) }}">S&M</a>
                        <a id="{{'student_link_'.$student->id}}" class="btn btn-primary"
                           href="{{ route('show-student',$student->slug ) }}">Show</a>

                        <button type="button" onclick="ajaxfunction({{$student->id}})"
                                class="btn btn-primary" data-id="{{$student->id}}">
                            Ajax Edit
                        </button>
{{--                        @can('delete articles per')--}}
                            {!! Form::submit('Delete', ['class' => 'btn btn-primary', 'id'=>'btndel', 'onClick' => "return confirm('Are you sure?')" ]) !!}
                            {{--                            @else--}}
                            {{--                                {!! Form::submit('Delete Role', ['class' => 'btn btn-xs btn-default text-danger mx-1 shadow', 'id'=>'btndel' ]) !!}--}}
{{--                        @endcan--}}
                        {!! Form::close()  !!}
                    </td>


                </tr>

            @endforeach
            </tbody>
        </table>
        <div style="margin-left: auto;margin-right: auto;width: 100%;">
            {{$students->links("pagination::bootstrap-4")}}
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="form-ajax-crud" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group" style="display: none" readonly>
                                    {!! Form::label('id', 'ID', []) !!}
                                    {!! Form::text('id', null, ['class' => 'form-control', 'id' => 'id_ajax']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('name', 'Student name', []) !!}
                                    {!! Form::text('full_name', null, ['class' => 'form-control', 'id' => 'fullname_ajax']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('email', 'Email', []) !!}
                                    {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email_ajax','readonly']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('birthday', 'Birthday', []) !!}
                                    {{--                                    {!! Form::text('birthday', null, ['class' => 'form-control', 'id' => 'birthday_ajax']) !!}--}}
                                    {!! Form::date('birthday', null ,['class' => 'form-control', 'id' => 'birthday_ajax']) !!}
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
                                    {!! Form::label('phone_number', 'Phonenumber', []) !!}
                                    {!! Form::text('phone_number', null, ['class' => 'form-control', 'id' => 'phone_ajax']) !!}
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10">
                                        <h9>Avatar</h9>
                                        <input type="file" id="avatar_ajax" name="image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="button_insert" class="btn btn-primary btn-update">Save changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="{{ asset('js/updateAjax.js') }}"></script>
        <h6 style="text-align: center">Tên tài khoản: {{\Illuminate\Support\Facades\Auth::user()->username}}</h6>
        <h6 style="text-align: center">Email: {{\Illuminate\Support\Facades\Auth::user()->email}}</h6>
        <h6 style="text-align: center">ID tài khoản: {{\Illuminate\Support\Facades\Auth::id()}}</h6>
        <h6 style="text-align: center">{{\Carbon\Carbon::now()->format('l jS \\of F Y')}}</h6>
@endsection
