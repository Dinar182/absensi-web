const dt_last_scan_log = () => {
    NioApp.DataTable('#__TableLastScanLog', {
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
        ajax : {
            url : base_url + "/dashboard/dt_last_scan_log",
            type : "GET",
        },
        order: [[ 1, 'desc' ]],
    });
};

window.onload = (event) => {
    dt_last_scan_log();

};