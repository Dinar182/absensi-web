const data_ijin_karyawan = () => {
    NioApp.DataTable('#__TableIjinKaraywan', {
        serverSide: true,
        processing: true,
        bDestroy: true,
        responsive: {
            details: true
        },
        columnDefs: [
            {
                target: [0, 2, 3, 4, 5, 6, 7],
                className: "text-center align-middle"
            },
            {
                target: 1,
                className: 'align-middle'
            }
        ],
        ajax : {
            url : base_url_ajax + "/ajax_approval/dt_ijin_karyawan",
            type : "GET",
        },
        order: [[ 1, 'desc' ]],
    });
};

const approval_ijin = (el) => {
    let id_ijin = el.getAttribute('id-ijin');

    $.ajax({
        url: base_url_ajax + "/ajax_approval/detail_ijin_karyawan?id-ijin=" + id_ijin,
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
                let ijin = res.response.detail_ijin;

                $('#__NamaKaryawan').text(ijin.nama_karyawan);
                $('#__JenisIjin').text(ijin.jenis_ijin);
                $('#__TanggalIjin').text(ijin.tanggal_ijin);
                $('#__KeteranganIjin').text(ijin.keterangan_ijin);
                $('.btn-approval-ijin').attr('id-ijin', ijin.id_ijin);

                $('#__ModalApproveIjin').modal('show');
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

const approval_ijin_karyawan = (el) => {
    let form_data = new FormData();
    let id_ijin = el.getAttribute('id-ijin');
    let status_approval = el.getAttribute('status-approve');

    form_data.append('id_ijin', id_ijin);
    form_data.append('status_approval', status_approval);

    $.ajax({
        url: base_url_ajax + "/ajax_approval/approval_ijin_karyawan",
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

                data_ijin_karyawan();
                $('#__ModalApproveIjin').modal('hide');
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
    data_ijin_karyawan();

};