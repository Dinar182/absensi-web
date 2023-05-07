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

window.onload = (event) => {
    data_rekap_absensi();

};