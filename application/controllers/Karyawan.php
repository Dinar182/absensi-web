<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model(['karyawan_model']);
	}

    public function index()
    {
		$header = [
			'page_main_nav' => 'data_karyawan'
        ];

		$data = [
            'page_title' => 'Data Karyawan',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/page/karyawan/index.js?_=') . rand() .'"></script>
            '
        ];

		admin_view($header, 'page/karyawan/index', $data);
    }

    public function form_karyawan()
    {
        $nip_karyawan = $this->input->get('nip-kary');

        $karyawan = [];
		$header = [
			'page_main_nav' => 'data_karyawan'
        ];

        if (!empty($nip_karyawan)) {
            $karyawan = $this->karyawan_model->get_karyawan_by_nip($nip_karyawan);
        }

		$data = [
            'page_title' => 'Form Karyawan',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/page/karyawan/form-karyawan.js?_=') . rand() .'"></script>
            ',

            'karyawan' => $karyawan
        ];

		admin_view($header, 'page/karyawan/form-karyawan', $data);
    }
}
