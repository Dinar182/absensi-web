<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // $this->auth_model->check_login();
	}

    public function login()
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

                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $check_user = $this->auth_model->check_user($username, $password);

                if (empty($check_user)) {
                    $this->session->set_flashdata([
                        'class' => 'danger',
                        'message' => 'Anda tidak memiliki akses ke aplikasi ini'
                    ]);

                    return redirect('auth/login');
                } else {
                    $this->session->set_userdata([
                        'is_login' => true,
                        'nip' => $check_user['nip'],
                        'nama' => $check_user['nama'],
                        'foto_profile' => $check_user['foto_profile']
                    ]);

                    return redirect('/');
                }
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();

        redirect('auth/login');
    }
}
