<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // $this->auth_model->check_login();
	}

    public function index()
    {
        if ($this->input->method() == 'get') {

            $this->load->view('auth/login');
        } else {
            $validator = [
                [
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'required|alpha_numeric',
                    'errors' => [
                        'required' => '%s harus diisi',
                        'alpha_numeric' => '%s tidak berlaku'
                    ]
                ],
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required|alpha_numeric',
                    'errors' => [
                        'required' => '%s harus diisi',
                        'alpha_numeric' => '%s tidak berlaku'
                    ]
                ]
            ];

            $this->form_validation->set_rules($validator);

            if ($this->form_validation->run() === false) {
                $this->load->view('auth/login');

            } else {

            }
        }
    }
}
