let payload_data = {
    start_date: $('#__tanggalStart').val(),
    end_date: $('#__tanggalEnd').val(),
}

const dt_rekap_scanlog = () => {
    NioApp.DataTable('#__TableRekapScanLog', {
        serverSide: true,
        processing: true,
        bDestroy: true,
        responsive: {
            details: true
        },
        columnDefs: [
            {
                target: [0, 2, 3, 4],
                className: "text-center align-middle"
            },
            {
                target: 1,
                className: 'align-middle'
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
            url : base_url_ajax + "/ajax_rekap/dt_rekap_scanlog",
            type : "GET",
            data: payload_data
        },
        order: [[ 3, 'DESC' ]],
    });
};

$('#__btnFilter').on('click', function(){
    payload_data.start_date = $('#__tanggalStart').val();
    payload_data.end_date = $('#__tanggalEnd').val();

    dt_rekap_scanlog();
});

window.onload = (event) => {
    dt_rekap_scanlog();

};