
$('#__SubmitSimpanSetting').on('click', function(){
    let form_data = new FormData($('#__formSimpanSettingAbsensi')[0]);

    $.ajax({
        url: base_url + "/setting/submit_simpan_setting",
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
                    alert: 'warning',
                    position: 'top-right'
                });
            } else {
                toaster_notification({
                    message: res_data.message,
                    alert: 'success',
                    position: 'top-right'
                });
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
});