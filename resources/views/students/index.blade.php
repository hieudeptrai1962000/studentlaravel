@extends('adminlte::page')
@extends('layouts.header')
@section('content')
    <button type="button" class="btn btn-light">
        <a target="_blank" href="{{route('students.create')}}" class="btn btn-success"
           style="background-color: #343a40; border-color: white; margin-right: 10px">Add New</a>
    </button>
    <button type="button" class="btn btn-light">
        <a href="{{route('age.create')}}" class="btn btn-success"
           style="background-color: pink; border-color: white">Send Mail to Bad Student</a>
    </button>





    <div class="form-group" style="margin-left: 20px">
        {{Form::open(['method' => 'GET', 'route' => 'age.index', 'class' => 'form-inline'])}}
        <div class="form-group" style="margin-right: 50px">
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
        <div class="form-group">
            <div style="display: inline-block;">
                <span><b>Mobile network:</b></span>
                <div class="form-check" style="display: inline-block">
                    {{Form::checkbox('phoneviettel')}}
                    {{Form::label('pp','Viettel')}}
                </div>

                <div class="form-check" style="display: inline-block">
                    {{Form::checkbox('phonemobi')}}
                    {{Form::label('pp','Mobiphone')}}
                </div>

                <div class="form-check" style="display: inline-block">
                    {{Form::checkbox('phonevina')}}
                    {{Form::label('pp','Vinaphone')}}
                </div>

            </div>


            <div class="form-check" style="display: inline-block;margin-left: 50px">
                {!! Form::label('don4','Finished subject: ',['style' => 'font-weight:bold'] ) !!}
                {{Form::checkbox('done','1',isset($data['done']) ? $data['done'] : null,['id' => 'done4'])}}
                {{Form::label('done5',' Or Not')}}
                {{Form::checkbox('not_done','1',isset($data['not_done']) ? $data['not_done'] : null,['id' => 'done5'])}}
            </div>
            <div class="form-check" style="display: inline-block;margin-left: 50px">
                {!! Form::label('check6','AVG < 5: ',['style' => 'font-weight:bold'] ) !!}
                {{Form::checkbox('less_5','1',isset($data['less_5']) ? $data['less_5'] : null,['id' => 'check6'])}}
                {{Form::label('check7',' Or not')}}
                {{Form::checkbox('greater_5','1',isset($data['greater_5']) ? $data['greater_5'] : null,['id' => 'check7'])}}

            </div>
            <div style="    display: flex;margin-left: 20px">
                <button type="submit" class="btn btn-info"><i class="fa fa-gamepad" aria-hidden="true"></i></button>
            </div>
            {{Form::close()}}
        </div>
        @include('layouts.flash_message')


        <a href="{!! route('user.change-language', ['en']) !!}">English</a>
        <a href="{!! route('user.change-language', ['vi']) !!}">Vietnam</a>


        <table id="ajaxcontent" class="table table-striped table-hover">
            <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">{{ __('main.fullname') }}</th>
                <th scope="col">Email</th>
                <th scope="col">Birthday</th>
                <th scope="col">Gender</th>
                <th scope="col">Phonenumber</th>
                <th scope="col">Avatar</th>
                <th scope="col">Action</th>
{{--                <th scope="col">Faculty ID</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr id="tr{{$student->id}}">
                    <td scope="col">{{$student->id}}</td>
                    <td contenteditable id="{{'student_name_'.$student->id}}" scope="col">{{$student->full_name}}</td>
                    <td id="{{'student_email_'.$student->id}}" scope="col">{{$student->email}}</td>
                    <td contenteditable id="{{'student_birthday_'.$student->id}}" scope="col">{{date('d-m-Y', strtotime($student->birthday))}}</td>


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
                    <td id="{{'student_image_'.$student->id}}" scope="col"><img width="100px" height="auto" src="{{asset(''.$student->image)}}"></td>
{{--                    <td id="{{'student_faculty_'.$student->id}}" scope="col">{{$student->faculty_id}}</td>--}}

                        <td>
                            {!! Form::model($student, ['route' => ['students.destroy', $student->id], 'method' => 'DELETE', 'id' => 'FormDelete']) !!}
                            <a class="btn btn-xs btn-default text-danger mx-1 shadow" data-id="{{$student->id}}"
                               href="{{ route('students.edit',$student->id ) }}">Edit</a>


                            {{--                        <a style="display: none" class="btn btn-xs btn-default text-danger mx-1 shadow"--}}
                            {{--                           href="{{ route('students.subject', $student->id) }}">Update Subject</a>--}}
                            {{--                        <a style="display: none" class="btn btn-xs btn-default text-danger mx-1 shadow"--}}
                            {{--                           href="{{ route('students.mark', $student->id) }}">Add Mark</a>--}}
                            <a class="btn btn-xs btn-default text-danger mx-1 shadow"
                               href="{{ route('students.show', $student->id) }}" >Update Subject and Mark</a>
                            <a class="btn btn-xs btn-default text-danger mx-1 shadow"
                               href="{{ route('show.students',[$student->id, $student->slug] ) }}" >Show</a>

                            <a class="Update" href="javascript:void(0)" data-toggle="modal" onclick="editStudent({{$student->id}})" data-target="#exampleModal">UPDATE</a>
                            <a class="btn btn-warning" href="javascript:void(0)"
                               onclick="editStudent({{ $student->id }})" data-target="#exampleModal" data-toggle="modal">Edit</a>

                            {!! Form::button('Button', ['class' => 'btn btn-success edit-btn', 'data-toggle' => 'modal', 'data-target' => '#exampleModal-' . $student->id]) !!}
                            @can('delete articles per')
                            {!! Form::submit('Delete', ['class' => 'btn btn-xs btn-default text-danger mx-1 shadow', 'id'=>'btndel' ]) !!}
{{--                            @else--}}
{{--                                {!! Form::submit('Delete Role', ['class' => 'btn btn-xs btn-default text-danger mx-1 shadow', 'id'=>'btndel' ]) !!}--}}
                            @endcan
                            {!! Form::close()  !!}
                        </td>


                </tr>
                <div class="modal fade hidden" id="exampleModal-{{ $student->id }}" tabindex="-1"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('getStudentId', $student->id) }}"
                                  id="editStudentModal" name="editStudentModal" class="form-horizontal" method="POST">
                                <div class="modal-body">
                                    @csrf
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Student name', []) !!}
                                            {!! Form::text('full_name', $student->full_name, ['class' => 'form-control', 'id' => 'fullname']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('faculty', 'Faculty', []) !!}
                                            {!! Form::select('faculty_id', $faculties, isset($student) ? $student->faculty : '', ['class' => 'form-control']) !!}

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('email', 'Email', []) !!}
                                            {!! Form::text('email', isset($student) ? $student->email : '', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('birthday', 'Birthday', []) !!}
                                            {!! Form::date('birthday', isset($student) ? $student->birthday : '', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('phone', 'Phone number', []) !!}
                                            {!! Form::text('phone', isset($student) ? $student->phone : '', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('gender', 'Gender', []) !!}
                                        {!! Form::radio('gender', '0', true) !!}
                                        <span>Nam</span>
                                        {!! Form::radio('gender', '1') !!}
                                        <span>Nữ</span>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            {!! Form::label('image', 'Image', []) !!}
                                            {!! Form::file('image', ['class' => 'form-control-file']) !!}
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary btn-update"
                                                data-modal="exampleModal-{{ $student->id }}">Save
                                            changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endforeach

            </tbody>
        </table>
        <div style="margin-left: auto;margin-right: auto;width: 100%;">
            {{$students->links("pagination::bootstrap-4")}}



        @endsection
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
        ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" type="text/javascript"
                charset="utf-8" async defer></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.btn-update').click(function () {

                    modal_id = $(this).closest('button').attr("data-modal");
                    // console.log(modal_id); //exampleModal-2
                    // modal_id = $(this).closest('button').css('border', '10px solid red'); //exampleModal-2

                    input_full_name = $('#' + modal_id + ' #fullname')[0];


                    // input_faculty = $('#' + modal_id + ' select[name="faculty_id"]')[0];
                    // input_email = $('#' + modal_id + ' input[name="email"]')[0];
                    // input_phone = $('#' + modal_id + ' input[name="phone"]')[0];
                    // input_birthday = $('#' + modal_id + ' input[name="birthday"]')[0];
                    // input_gender = $('#' + modal_id + ' input[name="gender"]:checked');
                    // input_image = $('#' + modal_id + ' input[name="image"]')[0];
                    input_token = $('#' + modal_id + ' input[name="_token"]')[0];
                    url_action = $('#' + modal_id + ' form');

                    formData = new FormData()

                    formData.append('full_name', input_full_name.value);
                    // console.log(input_full_name.value);
                    // formData.append('faculty_id', input_faculty.value)
                    // formData.append('email', input_email.value)
                    // formData.append('phone', input_phone.value)
                    // formData.append('birthday', input_birthday.value)
                    // formData.append('avatar', input_image.files[0])
                    // formData.append('birthday', input_birthday.value)
                    // formData.append('gender', input_gender.value)
                    formData.append('_token', input_token.value);

                    $.ajax({
                        type: "POST",
                        url: url_action.attr('action'),
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,

                        enctype: 'multipart/form-data',
                        success: function (data) {
                            // console.log(data);
                            $("#tr" + data.id + ' td:nth-child(2)').html(data.full_name);
                            // location.reload();
                        },
                        error: function (err) {
                            console.log(err);
                        },
                    });
                });
            });
        </script>




