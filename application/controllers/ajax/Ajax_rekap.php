<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_rekap extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model('rekap_model');
	}

    public function dt_rekap_absensi()
    {
        $data = [];

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $col_idx = $this->input->get('order')[0]['column'];
        $order_dir = $this->input->get('order')[0]['dir'];

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $col_array = [
            null, 'mk.nip', 'mk.nama'
        ];

        $col_name = isset($col_array[$col_idx]) ? $col_array[$col_idx] : 'mk.nip';

        $param_model = [
            'start' => $start,
            'limit' => $limit,
            'search' => $search,
            'col_name' => $col_name,
            'order_dir' => $order_dir,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];


        $get_rekap = $this->rekap_model->dt_select_rekap_absensi($param_model);
        $select_rekap = $get_rekap->result_array();
        $count_rekap = $get_rekap->row_array();

        if (!empty($select_rekap)) {
            $no = $start + 1;

            foreach ($select_rekap as $rekap) {
                $row = [];

                $row[] = $no++;

                $row[] = $rekap['nip'];
                $row[] = $rekap['nama_kary'];
                $row[] = $rekap['jumlah_hadir'];
                $row[] = $rekap['jumlah_telat'];
                $row[] = $rekap['jumlah_mangkir'];
                $row[] = $rekap['jumlah_ijin'];
                $row[] = $rekap['jumlah_cuti'];
                
                $data[] = $row;
            }
        }


        $response = [
            'draw' => $this->input->get('draw'),
            'recordsTotal' => isset($count_rekap['total_record']) ? $count_rekap['total_record'] : 0,
            'recordsFiltered' => isset($count_rekap['total_record']) ? $count_rekap['total_record'] : 0,
            'data' => $data
        ];

        return response_json($response);
    }

    public function dt_rekap_scanlog()
    {
        $data = [];

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $col_idx = $this->input->get('order')[0]['column'];
        $order_dir = $this->input->get('order')[0]['dir'];

        $col_array = [
            'mk.nama', 'mk.nip', null, 'ak.tanggal', 'ak.jam'
        ];

        $col_name = isset($col_array[$col_idx]) ? $col_array[$col_idx] : 'ak.jam';

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $param_model = [
            'start' => $start,
            'limit' => $limit,
            'search' => $search,
            'col_name' => $col_name,
            'order_dir' => $order_dir,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];


        $get_last_scan = $this->rekap_model->dt_select_rekap_scanlog($param_model);
        $select_last_scan = $get_last_scan->result_array();
        $count_last_scan = $get_last_scan->row_array();

        if (!empty($select_last_scan)) {
            $no = $start + 1;

            foreach ($select_last_scan as $scan) {
                $row = [];

                $row[] = $scan['nama_karyawan'];
                $row[] = $scan['nip_karyawan'];

                switch ($scan['flag_scan']) {
                    case '1':
                        $flag_scan = '<span class="badge bg-success">Berhasil Masuk</span>';
                        break;
                    
                    default:
                        $flag_scan = '<span class="badge bg-info">Berhasil Pulang</span>';
                        break;
                }

                $row[] = $flag_scan;
                $row[] = $scan['tanggal'];
                $row[] = $scan['jam'];
                
                $data[] = $row;
            }
        }


        $response = [
            'draw' => $this->input->get('draw'),
            'recordsTotal' => isset($count_last_scan['total_record']) ? $count_last_scan['total_record'] : 0,
            'recordsFiltered' => isset($count_last_scan['total_record']) ? $count_last_scan['total_record'] : 0,
            'data' => $data
        ];

        return response_json($response);
    }
}