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

window.onload = (event) => {
    data_karyawan();

};