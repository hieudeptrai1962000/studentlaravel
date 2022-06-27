@extends('adminlte::page')
{{--@extends('layouts.header')--}}
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                    {{Form::checkbox('viettel')}}
                    {{Form::label('pp','Viettel')}}
                </div>

                <div class="form-check" style="display: inline-block">
                    {{Form::checkbox('mobi')}}
                    {{Form::label('pp','Mobiphone')}}
                </div>

                <div class="form-check" style="display: inline-block">
                    {{Form::checkbox('vina')}}
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


        <a href="{!! route('user.change-language', ['en']) !!}">{{ __('main.english') }}</a>
        <a href="{!! route('user.change-language', ['vi']) !!}">{{ __('main.vietnam') }}</a>


        <table id="ajaxcontent" class="table table-striped table-hover">
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
                    <td contenteditable id="{{'student_name_'.$student->id}}" scope="col">{{$student->full_name}}</td>
                    <td id="{{'student_email_'.$student->id}}" scope="col">{{$student->email}}</td>
                    <td contenteditable id="{{'student_birthday_'.$student->id}}"
                        scope="col">{{date('d-m-Y', strtotime($student->birthday))}}</td>


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


                    <td>
                        {!! Form::model($student, ['route' => ['students.destroy', $student->id], 'method' => 'DELETE', 'id' => 'FormDelete']) !!}
                        <a class="btn btn-xs btn-default text-danger mx-1 shadow"
                           href="{{ route('students.edit',$student->id ) }}">Edit</a>


                        <a class="btn btn-xs btn-default text-danger mx-1 shadow"
                           href="{{ route('students.show', $student->id) }}">Update Subject and Mark</a>
                        <a class="btn btn-xs btn-default text-danger mx-1 shadow"
                           href="{{ route('show.students',[$student->id, $student->slug] ) }}">Show</a>


                        <button type="button" onclick="ajaxfunction({{$student->id}})"
                                class="btn btn-primary" data-id="{{$student->id}}">
                            Ajax Edit
                        </button>
                        @can('delete articles per')
                            {!! Form::submit('Delete', ['class' => 'btn btn-xs btn-default text-danger mx-1 shadow', 'id'=>'btndel' ]) !!}
                            {{--                            @else--}}
                            {{--                                {!! Form::submit('Delete Role', ['class' => 'btn btn-xs btn-default text-danger mx-1 shadow', 'id'=>'btndel' ]) !!}--}}
                        @endcan
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
                                    {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email_ajax']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('birthday', 'Birthday', []) !!}
                                    {!! Form::text('birthday', null, ['class' => 'form-control', 'id' => 'birthday_ajax']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('gender', 'Gender:', ['class' => 'col-lg-2 control-label', 'id' => 'gender_new']) !!}
                                    <div class="col-lg-10">
                                        <label class="radio-inline">
                                            {{Form::radio('gender', '0', true, ['id' => 'gender_ajax'])}} Nam
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
                                        <input type="file" id="avatar_ajax" name="image" value="">
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
        @endsection
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript">
            function ajaxfunction(id) {
                $('#exampleModal').modal('show')
                $('#id_ajax').val($('#student_id_' + id).html());
                $('#fullname_ajax').val($('#student_name_' + id).html());
                $('#email_ajax').val($('#student_email_' + id).html());

                // $('#birthday_ajax').val($('#student_birthday_' + id).html());
                $('#gender_ajax').val($('#student_gender_' + id).html());
                $('#phone_ajax').val($('#student_phone_' + id).html());
                // $('#avatar_ajax').val($('#student_image_' + id).html());
            }

            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#button_insert').on('click', function () {
                    var student_id = $('#id_ajax').val();
                    var full_name = $('#fullname_ajax').val();
                    var email = $('#email_ajax').val();
                    // if ($('#gender_ajax').val() === 1) {
                    //     $('#male_check').prop('checked', true);
                    // } else {
                    //     $('#female_check').prop('checked', true);
                    // }
                    // var birthday = $('#birthday_ajax').val();
                    var gender = $('#gender_ajax').val();
                    alert(gender)
                    var phone = $('#phone_ajax').val();
                    // var avatar = $('#avatar_ajax').val();
                    // console.log(name)
                    data = {
                        id: student_id,
                        full_name: full_name,
                        email: email,
                        // birthday: birthday,
                        gender: gender,
                        phone_number: phone,
                        // image: avatar,
                        _token: "{{csrf_token()}}",
                        // productName: productName
                    };
                    // console.log(data);
                    $.ajax({
                        url: "students/ajax/" + student_id,
                        method: "post",
                        data: data,
                        success: function (response) {
                            alert('Đã cập nhật thành công !')
                            console.log(response);
                            $('#student_name_' + student_id).html(data.full_name);
                            $('#student_email_' + student_id).html(data.email);
                            $('#student_phone_' + student_id).html(data.phone_number);
                            $('#form-ajax-crud').trigger("reset");
                            $('#exampleModal').modal('hide')
                            // $('#button_insert').val('Save Changes');
                        },
                        error: function () {
                            alert('ko thanh cong')
                        }
                    })

                })
            });

        </script>




