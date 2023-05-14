const data_karyawan = () => {
    NioApp.DataTable('#__TableKaraywan', {
        serverSide: true,
        processing: true,
        bDestroy: true,
        responsive: {
            details: true
        },
        columnDefs: [
            {
                target: [0, 2, 3, 4, 5, 6, 7, 8],
                className: "text-center align-middle"
            },
            {
                target: 1,
                className: 'align-middle'
            },
            {
                target: [0, 3],
                orderable: false
            }
        ],
        ajax : {
            url : base_url_ajax + "/ajax_karyawan/dt_karyawan",
            type : "GET",
        },
        order: [[ 1, 'desc' ]],
    });
};

const delete_karyawan = (el) => {
    Swal.fire({
        title: 'Yakin ingin menghapus karyawan ?',
        text: "Proses hapus data karyawan tidak bisa di batalkan !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Proses!',
        width: '350px'
    }).then(function (result) {
        if (result.isConfirmed == true) {

            let nip_kary = el.getAttribute('nip-kary');
        
            let form_data = new FormData();
                form_data.append('nip', nip_kary);
        
            $.ajax({
                url: base_url_ajax + "/ajax_karyawan/delete_karyawan",
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
                        toaster_notification({
                            message: res_data.message,
                            alert: 'warning'
                        });
        
                    } else {
                        toaster_notification({
                            message: res_data.message,
                            alert: 'success'
                        });
        
                        data_karyawan();
                    }
                },
                error : function(jqXHR, textStatus, errorThrow){
                    if (jqXHR.status == 500) {
                        toaster_notification({
                            message: 'Terjadi kesalahan saat memproses data!',
                            alert: 'error'
                        });
                    }
                }
            });
        }
    }).catch(function(){
        toaster_notification({
            message: 'Terjadi kesalahan saat memproses data!',
            alert: 'error'
        });
    });
}

const reset_password = (el) => {
    Swal.fire({
        title: 'Yakin ingin me-reset password karyawan ?',
        text: "Proses reset password tidak bisa di batalkan !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Proses!',
        width: '350px'
    }).then(function (result) {
        if (result.isConfirmed == true) {

            let nip_kary = el.getAttribute('nip-kary');
        
            let form_data = new FormData();
                form_data.append('nip', nip_kary);
        
            $.ajax({
                url: base_url_ajax + "/ajax_karyawan/reset_password_karyawan",
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
                        toaster_notification({
                            message: res_data.message,
                            alert: 'warning'
                        });
        
                    } else {
                        toaster_notification({
                            message: res_data.message,
                            alert: 'success'
                        });
        
                        data_karyawan();
                    }
                },
                error : function(jqXHR, textStatus, errorThrow){
                    if (jqXHR.status == 500) {
                        toaster_notification({
                            message: 'Terjadi kesalahan saat memproses data!',
                            alert: 'error'
                        });
                    }
                }
            });
        }
    }).catch(function(){
        toaster_notification({
            message: 'Terjadi kesalahan saat memproses data!',
            alert: 'error'
        });
    });
}

const reset_deviceid = (el) => {
    Swal.fire({
        title: 'Yakin ingin me-reset device id ?',
        text: "Proses reset device id tidak bisa di batalkan !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Proses!',
        width: '350px'
    }).then(function (result) {
        if (result.isConfirmed == true) {

            let nip_kary = el.getAttribute('nip-kary');
        
            let form_data = new FormData();
                form_data.append('nip', nip_kary);
        
            $.ajax({
                url: base_url_ajax + "/ajax_karyawan/reset_deviceid_karyawan",
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
                        toaster_notification({
                            message: res_data.message,
                            alert: 'warning'
                        });
        
                    } else {
                        toaster_notification({
                            message: res_data.message,
                            alert: 'success'
                        });
        
                        data_karyawan();
                    }
                },
                error : function(jqXHR, textStatus, errorThrow){
                    if (jqXHR.status == 500) {
                        toaster_notification({
                            message: 'Terjadi kesalahan saat memproses data!',
                            alert: 'error'
                        });
                    }
                }
            });
        }
    }).catch(function(){
        toaster_notification({
            message: 'Terjadi kesalahan saat memproses data!',
            alert: 'error'
        });
    });
}

window.onload = (event) => {
    data_karyawan();

};