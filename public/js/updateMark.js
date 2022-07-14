$(document).ready(function () {
    form = $('tr.addform').html();
    $("#btn").click(function () {
        var len = $('tbody#formadd tr').length;
        var subject = $('p#count-subject').html();
        if (len - 1 < subject) {
            $("tbody").append('<tr>' + form + '</tr>');
        } else {
            alert('Đã đủ môn học')
        }
    });
    $(document).on('click', '.delete', function () {
        $(this).parent().parent().remove();
        var $select = $("select");
        var selected = [];
        $.each($select, function (index, select) {
            if (select.value !== "") {
                selected.push(select.value);
            }
        });
    });

    $(document).on('click', 'select', function () {
        var $select = $("select");
        var selected = [];
        $.each($select, function (index, select) {
            if (select.value !== "") {
                selected.push(select.value);
            }
        });
        $('select > option').not(this).css('display', 'block');
        $("option").prop("disabled", false);
        for (var index in selected) {
            $('option[value="' + selected[index] + '"]').hide();
        }
        $(this).parent().parent().find('td > i.remove-item').on('click', function () {
            var del = $(this).val();
            selected.splice(selected.indexOf(del.toString()), 1);
            for (var index in selected) {
                $('option[value="' + selected[index] + '"]').show();
            }
        });
    });

    $('#saveform').on('click', function () {
        $('tr.addform').remove();
    });
});
