@extends('adminlte::page')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 8 Ajax CRUD Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-2" id="group">

    <div class="row">


        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewBook" class="btn btn-success">Add</button></div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
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
                @foreach($students as $student)
                    <tr>
                        <td contenteditable scope="col">{{$student->full_name}}</td>
                        <td contenteditable scope="col">{{$student->email}}</td>
                        <td contenteditable scope="col">{{$student->birthday}}</td>
                        <td contenteditable scope="col">
                            <?php
                            if ($student->gender == 0) {
                                echo 'Nam';
                            } else {
                                echo 'Nữ';
                            }
                            ?>
                        </td>
                        <td contenteditable scope="col">{{$student->phone_number}}</td>
                        <td contenteditable scope="col"><img width="100px" height="auto" src="{{asset(''.$student->image)}}"></td>
                        <td contenteditable scope="col">{{$student->faculty_id}}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $student->id }}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $student->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $students->links() !!}
        </div>
    </div>
</div>

<!-- boostrap model -->
<div class="modal fade" id="ajax-book-model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBookModel"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addEditBookForm" name="addEditBookForm" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Book Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Book Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Birthday</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="birthday" name="birthday" placeholder="Enter Book Name" value="" maxlength="50" required="">
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
                        <label for="name" class="col-sm-2 control-label">Phonenumber</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="phonenumber" name="phone_number" placeholder="Enter Book Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Avatar</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="image" name="image" placeholder="Enter Book Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBook">Save changes
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->
<script type="text/javascript">
    $(document).ready(function($){



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $('body').on('click', '.edit', function () {

            var id = $(this).data('id');

            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('edit-book') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#ajaxBookModel').html("Edit Book");
                    $('#ajax-book-model').modal('show');
                    $('#id').val(res.id);
                    $('#fullname').val(res.full_name);
                    $('#email').val(res.email);
                    $('#birthday').val(res.birthday);
                    $('#gender').val(res.gender);
                    $('#phonenumber').val(res.phone_number);
                    $('#image').val(res.image);

                }
            });

        });

        $('body').on('click', '#btn-save', function (event) {

            var id = $("#id").val();
            var full_name = $("#fullname").val();
            var email = $("#email").val();
            var birthday = $("#birthday").val();
            var gender = $("#gender").val();
            var phone_number = $("#phonenumber").val();
            var image = $("#image").val();


            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('add-update-book  ') }}",
                data: {
                    id:id,
                    full_name:full_name,
                    email:email,
                    birthday:birthday,
                    gender:gender,
                    phone_number:phone_number,
                    image:image,
                },
                dataType: 'json',
                success: function(res){
                    $("form")[0].reset();
                }
            });

        });

        $('body').on('click', '.delete', function () {

            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('delete-book') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){


                    }
                });
            }

        });


    });
</script>
</body>
</html>
@endsection
