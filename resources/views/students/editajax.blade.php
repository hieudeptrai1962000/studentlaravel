
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">​
</head>
<body>
<div class="container">
    <a href="#" class="btn btn-success btn-add" data-target="#modal-add" data-toggle="modal">Add</a>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Fullname</th>
                <th scope="col">Email</th>
                <th scope="col">Birthday</th>
                <th scope="col">Gender</th>
                <th scope="col">Phonenumber</th>
                <th scope="col">Avatar</th>
                <th scope="col">Faculty ID</th>
            </tr>
            </thead>
            <tbody>
            {{-- biến $todos được controller trả cho view
                chứa dữ liệu tất cả các bản ghi trong bảng students. Dùng foreach để hiển
                thị từng bản ghi ra table này. --}}

            @foreach ($students as $student)
                <tr>
                    <td id="{{$student->id}}">{{$student->id}}</td>
                    <td id="full_name-{{$student->id}}">{{$student->full_name}}</td>
                    <td id="email-{{$student->id}}">{{$student->email}}</td>
                    <td id="birthday-{{$student->id}}">{{$student->birthday}}</td>
                    <td id="gender-{{$student->id}}">
                        <?php
                        if ($student->gender == 0) {
                            echo 'Nam';
                        } else {
                            echo 'Nữ';
                        }
                        ?></td>
                    <td id="phone_number-{{$student->id}}">{{$student->phone_number}}</td>
                    <td id="image-{{$student->id}}"><img width="100px" height="auto" src="{{asset(''.$student->image)}}"></td>
                    <td id="faculty_id-{{$student->id}}">{{$student->faculty_id}}</td>
                    <td>
{{--                        <button data-url="{{ route('studentajax.show',$student->id) }}"​ type="button" data-target="#show" data-toggle="modal" class="btn btn-info btn-show">Detail</button>--}}
                        <button data-url="{{ route('editajax.update',$student->id) }}"​ type="button" data-target="#edit" data-toggle="modal" class="btn btn-warning btn-edit">Edit</button>
{{--                        <button data-url="{{ route('studentajax.destroy',$student->id) }}"​ type="button" data-target="#delete" data-toggle="modal" class="btn btn-danger btn-delete">Delete</button>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{-- {{$students->links()}} --}}
</div>

{{--@include('students.editajax')--}}
{{--@include('student.add')--}}
{{--@include('student.detail')--}}
{{--@include('student.edit')--}}


</body>
</html>​
