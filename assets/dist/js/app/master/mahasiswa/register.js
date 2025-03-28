function load_jurusan() {
    $('#jurusan').find('option').not(':first').remove();

    $.getJSON(base_url+'register/load_jurusan', function (data) {
        var option = [];
        for (let i = 0; i < data.length; i++) {
            option.push({
                id: data[i].id_jurusan,
                text: data[i].nama_jurusan
            });
        }
        $('#jurusan').select2({
            data: option    
        })
    });
}

function load_kelas(id) {
    $('#kelas').find('option').not(':first').remove();

    $.getJSON(base_url+'register/kelas_by_jurusan/' + id, function (data) {
        var option = [];
        for (let i = 0; i < data.length; i++) {
            option.push({
                id: data[i].id_kelas,
                text: data[i].nama_kelas
            });
        }
        $('#kelas').select2({
            data: option
        });
    });
}

$(document).ready(function () {

    // ajaxcsrf();

    // Load Jurusan
    load_jurusan();

    // Load Kelas By Jurusan
    $('#jurusan').on('change', function () {
        load_kelas($(this).val());
    });

    $('form#reg_employee input, form#reg_employee select').on('change', function () {
        $(this).closest('.form-group').removeClass('has-error has-success');
        $(this).nextAll('.help-block').eq(0).text('');
    });

    $('[name="jenis_kelamin"]').on('change', function () {
        $(this).parent().nextAll('.help-block').eq(0).text('');
    });

    $('form#reg_employee').on('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var btn = $('#submit');
        btn.attr('disabled', 'disabled').text('Wait...');

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            success: function (data) {
                btn.removeAttr('disabled').text('Save');
                if (data.status) {
                    Swal.fire({
                        "title": "Success",
                        "text": "User created successfully. Employee ID is used as a password at login.",
                        "type": "success"
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = base_url+'Auth';
                        }
                    });
                } else {
                    console.log(data.errors);
                    $.each(data.errors, function (key, value) {
                        $('[name="' + key + '"]').nextAll('.help-block').eq(0).text(value);
                        $('[name="' + key + '"]').closest('.form-group').addClass('has-error');
                        if (value == '') {
                            $('[name="' + key + '"]').nextAll('.help-block').eq(0).text('');
                            $('[name="' + key + '"]').closest('.form-group').removeClass('has-error').addClass('has-success');
                        }
                    });
                }
            }
        });
    });
});