function ajaxfunction(id) {
    $('#exampleModal').modal('show')
    $('#id_ajax').val($('#student_id_' + id).html());
    $('#fullname_ajax').val($('#student_name_' + id).html());
    $('#email_ajax').val($('#student_email_' + id).html());
    $('#birthday_ajax').val($('#student_birthday_' + id).html());
    $('#phone_ajax').val($('#student_phone_' + id).html());
    $('#faculty_ajax').val($('#student_faculty_' + id).html()).change();

}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#button_insert').on('click', function () {
        var modal_id = $('#id_ajax').val();

        formData = new FormData($("#form-ajax-crud")[0])

        formData.append('image', $('#avatar_ajax')[0].files[0])

        $.ajax({
            type: "POST",
            url: "students/ajax/" + modal_id,
            data: formData,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                $("#student_link_" + modal_id).attr("href", window.location.href + '/' + 'seen' + '/' + response.slug);
                if (response.gender == '1') {
                    var valueGender = 'Nữ';
                } else {
                    var valueGender = 'Nam';
                }
                $('#student_name_' + modal_id).html(response.full_name);
                $('#student_email_' + modal_id).html(response.email);
                $('#student_phone_' + modal_id).html(response.phone_number);
                $('#student_gender_' + modal_id).html(valueGender);
                $('#student_birthday_' + modal_id).html(response.birthday);
                $('#new_image_' + modal_id).attr('src', response.image);
                $('#student_faculty_' + modal_id).html(response.faculty_id);

                $('#form-ajax-crud').trigger("reset");
                $('#exampleModal').modal('hide')
            },
            error: function (data) {
                $.each(data , function (index, value){
                    console.log(data);
                });
            }
        })
    })
})
