<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
	}

    public function ijin()
    {
		$header = [
			'page_main_nav' => 'approval_ijin'
        ];

		$data = [
			'page_title' => 'Daftar Persetujuan Ijin',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/page/approval/approval-ijin.js?_=') . rand() .'"></script>
            '
        ];

		admin_view($header, 'page/approval/approval-ijin', $data);
    }

    public function cuti()
    {
        $header = [
            'page_main_nav' => 'approval_cuti'
        ];

        $data = [
            'page_title' => 'Daftar Persetujuan Cuti',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/page/approval/approval-cuti.js?_=') . rand() .'"></script>
            '
        ];

        admin_view($header, 'page/approval/approval-cuti', $data);
    }
}
