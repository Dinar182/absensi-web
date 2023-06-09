<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model('rekap_model');
	}

    public function absensi()
    {
        $header = [
            'page_main_nav' => 'rekap'
        ];

        $data = [
            'page_title' => 'Laporan Absensi Karyawan',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/datatables/datatable-btns.js?_=') . rand() .'"></script>
                <script src="'. site_url('assets/js/page/rekap/index.js?_=') . rand() .'"></script>
            '
        ];

        admin_view($header, 'page/rekap/index', $data);
    }

    public function scanlog()
    {
        $header = [
            'page_main_nav' => 'rekap'
        ];

        $data = [
            'page_title' => 'Laporan Scanlog Karyawan',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/datatables/datatable-btns.js?_=') . rand() .'"></script>
                <script src="'. site_url('assets/js/page/rekap/scan-log.js?_=') . rand() .'"></script>
            '
        ];

        admin_view($header, 'page/rekap/scan-log', $data);
    }
}