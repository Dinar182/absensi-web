<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_master extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model(['master_model']);
	}

    public function select_agama()
    {
        $start = $this->input->get('page');
        $limit = 20;
        $search = $this->input->get('search');

        if ($start <= 0) {
            $start = 1;
        }

        $param_model = [
            'start' => ceil($start - 1),
            'limit' => $limit,
            'search' => $search
        ];

        $get_agama = $this->master_model->select_agama($param_model);
        $select_agama = $get_agama->result_array();
        $count_agama = $get_agama->row_array();

        $response = [
            'results' => $select_agama,
            'pagination' => [
                'more' => ($start * $limit) < isset($count_agama->total_record) ? $count_agama->total_record : 0
            ]
        ];

        response_json($response);
    }

    public function select_divisi()
    {
        $start = $this->input->get('page');
        $limit = 20;
        $search = $this->input->get('search');

        if ($start <= 0) {
            $start = 1;
        }

        $param_model = [
            'start' => ceil($start - 1),
            'limit' => $limit,
            'search' => $search
        ];

        $get_divisi = $this->master_model->select_divisi($param_model);
        $select_divisi = $get_divisi->result_array();
        $count_divisi = $get_divisi->row_array();

        $response = [
            'results' => $select_divisi,
            'pagination' => [
                'more' => ($start * $limit) < isset($count_divisi->total_record) ? $count_divisi->total_record : 0
            ]
        ];

        response_json($response);
    }

    public function select_jabatan()
    {
        $start = $this->input->get('page');
        $limit = 20;
        $search = $this->input->get('search');

        if ($start <= 0) {
            $start = 1;
        }

        $param_model = [
            'start' => ceil($start - 1),
            'limit' => $limit,
            'search' => $search
        ];

        $get_jabatan = $this->master_model->select_jabatan($param_model);
        $select_jabatan = $get_jabatan->result_array();
        $count_jabatan = $get_jabatan->row_array();

        $response = [
            'results' => $select_jabatan,
            'pagination' => [
                'more' => ($start * $limit) < isset($count_jabatan->total_record) ? $count_jabatan->total_record : 0
            ]
        ];

        response_json($response);
    }
}