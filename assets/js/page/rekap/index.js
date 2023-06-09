let payload_data = {
    start_date: $('#__tanggalStart').val(),
    end_date: $('#__tanggalEnd').val(),
}

const data_rekap_absensi = () => {
    NioApp.DataTable('#__TableRekapAbsensi', {
        serverSide: true,
        processing: true,
        bDestroy: true,
        responsive: {
            details: true
        },
        columnDefs: [
            {
                target: [0, 1, 3, 4, 5, 6, 7],
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
		buttons: [
            {
                extend: 'pdf',
                titleAttr:'Export Pdf'
            },
            {
                extend: 'excel',
                titleAttr:'Export Excel'
            }
        ],
        ajax : {
            url : base_url_ajax + "/ajax_rekap/dt_rekap_absensi",
            type : "GET",
            data: payload_data
        },
        order: [[ 1, 'desc' ]],
    });
};

$('#__btnFilter').on('click', function(){
    payload_data.start_date = $('#__tanggalStart').val();
    payload_data.end_date = $('#__tanggalEnd').val();

    data_rekap_absensi();
});

window.onload = (event) => {
    data_rekap_absensi();

};