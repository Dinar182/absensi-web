<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // $this->auth_model->check_login();
	}

    public function index()
    {
		$header = [
			'page_title' => 'Dashboard',
			'page_main_nav' => 'dashboard'
        ];

		$data = [
        ];

		admin_view($header, 'dashboard', $data);
    }
}
