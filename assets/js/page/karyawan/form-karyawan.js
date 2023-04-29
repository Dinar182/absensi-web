const select_agama = () => {
    NioApp.Select2('#__Agamakaryawan', {
        placeholder: '- Pilih Agama -',
        allowClear: true,
        ajax: {
            type: 'GET',
            url: base_url_ajax + '/ajax_master/select_agama',
            data: function(params) {
                let query = {
                    search: params.term,
                    page: params.page || 1
                };

                return query;
            },
            delay: 500
        }
    });
}

const select_divisi = () => {
    NioApp.Select2('#__Divisikaryawan', {
        placeholder: '- Pilih Divisi -',
        allowClear: true,
        ajax: {
            type: 'GET',
            url: base_url_ajax + '/ajax_master/select_divisi',
            data: function(params) {
                let query = {
                    search: params.term,
                    page: params.page || 1
                };

                return query;
            },
            delay: 500
        }
    });
}

const select_jabatan = () => {
    NioApp.Select2('#__Jabatankaryawan', {
        placeholder: '- Pilih Jabatan -',
        allowClear: true,
        ajax: {
            type: 'GET',
            url: base_url_ajax + '/ajax_master/select_jabatan',
            data: function(params) {
                let query = {
                    search: params.term,
                    page: params.page || 1
                };

                return query;
            },
            delay: 500
        }
    });
}

$('#__SubmitKaryawan').on('click', function(){
    Swal.fire({
        title: 'Yakin ingin memproses?',
        text: "Proses simpan data karyawan tidak bisa di batalkan !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Proses!',
        width: '350px'
    }).then(function (result) {
        if (result.isConfirmed == true) {
            let form_data = new FormData($('#__formSubmitKaryawan')[0]);

            $.ajax({
                url: base_url_ajax + "/ajax_karyawan/submit_proses_karyawan",
                type: "POST",
                data: form_data,
                dataType: "json",
                async: true,
                contentType: false,
                processData: false,
                beforeSend: function () {blockUI()},
                complete: function () {unBlockUI()},
                success: function (res) {
                    let res_data = res.metadata;

                    if (res_data.status > 200) {
                        basic_alert('warning', 'Warning', res_data.message);

                    } else {
                        var title_alert = res_data.message,
                            message_alert = 'Halaman akan segera dialihkan',
                            direct_uri =  base_url + '/karyawan';

                        alert_successfuly(title_alert, message_alert, direct_uri);
                    }
                },
                error : function(jqXHR, textStatus, errorThrow){
                    if (jqXHR.status == 500) {
                        basic_alert('error', 'Danger', 'Terjadi kesalahan saat memproses data');
                    }
                }
            });
        }
    }).catch(function(){
        basic_alert('error', 'Danger', 'Terjadi kesalahan saat memproses data');
    });
});

window.onload = (event) => {
    select_agama();
    select_divisi();
    select_jabatan();

};