const data_cuti_karyawan = () => {
    NioApp.DataTable('#__TableCutiKaraywan', {
        serverSide: true,
        processing: true,
        bDestroy: true,
        responsive: {
            details: true
        },
        columnDefs: [
            {
                target: [0, 2, 3, 4, 5, 6],
                className: "text-center align-middle"
            },
            {
                target: 1,
                className: 'align-middle'
            }
        ],
        ajax : {
            url : base_url_ajax + "/ajax_approval/dt_cuti_karyawan",
            type : "GET",
        },
        order: [[ 2, 'ASC' ]],
    });
};

const approval_cuti = (el) => {
    let id_cuti = el.getAttribute('id-cuti');

    $.ajax({
        url: base_url_ajax + "/ajax_approval/detail_cuti_karyawan?id-cuti=" + id_cuti,
        type: "GET",
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
                let cuti = res.response.detail_cuti;

                $('#__NamaKaryawan').text(cuti.nama_karyawan);
                $('#__MulaiCuti').text(cuti.mulai_cuti);
                $('#__SelesaiCuti').text(cuti.selesai_cuti);
                $('#__KeteranganCuti').text(cuti.keterangan_cuti);
                $('.btn-approval-cuti').attr('id-cuti', cuti.id_cuti);

                $('#__ModalApproveCuti').modal('show');
            }
        },
        error : function(jqXHR, textStatus, errorThrow){  
            if (jqXHR.status == 500) {
                toaster_notification({
                    message: 'Terjadi kesalahan saat memproses data',
                    alert: 'error',
                    position: 'top-right'
                });
            }
        }
    });
}

const approval_cuti_karyawan = (el) => {
    let form_data = new FormData();
    let id_cuti = el.getAttribute('id-cuti');
    let status_approval = el.getAttribute('status-approve');

    form_data.append('id_cuti', id_cuti);
    form_data.append('status_approval', status_approval);

    $.ajax({
        url: base_url_ajax + "/ajax_approval/approval_cuti_karyawan",
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
                basic_alert('success', 'Success', res_data.message);

                data_cuti_karyawan();
                $('#__ModalApproveCuti').modal('hide');
            }
        },
        error : function(jqXHR, textStatus, errorThrow){
            if (jqXHR.status == 500) {
                basic_alert('error', 'Danger', 'Terjadi kesalahan saat memproses data');
            }
        }
    });
}

window.onload = (event) => {
    data_cuti_karyawan();

};