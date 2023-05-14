const data_rekap_absensi = () => {
    NioApp.DataTable('#__TableLokasiKerja', {
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
            },
            {
                target: [0, 6],
                orderable: false
            }
        ],
        ajax : {
            url : base_url + "/setting/dt_lokasi_kerja",
            type : "GET"
        },
        order: [[ 1, 'desc' ]],
    });
};

const delete_lokasi_kerja = (el) => {
    Swal.fire({
        title: 'Yakin ingin menghapus lokasi kerja ?',
        text: "Proses hapus lokasi kerja tidak bisa di batalkan !",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Proses!',
        width: '350px'
    }).then(function (result) {
        if (result.isConfirmed == true) {
            let id_lokasi = el.getAttribute('id-lokasi');
        
            let form_data = new FormData();
                form_data.append('id_lokasi', id_lokasi);
        
            $.ajax({
                url: base_url + "/setting/delete_lokasi_kerja",
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
        
                        data_rekap_absensi();
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
    data_rekap_absensi();

};