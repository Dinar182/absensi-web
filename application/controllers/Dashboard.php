<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model('dashboard_model');
	}

    public function index()
    {
		$header = [
			'page_main_nav' => 'dashboard'
        ];

		$data = [
			'page_title' => 'Dashboard',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/page/dashboard.js?_=') . rand() .'"></script>
            ',

            'total_karyawan' => $this->dashboard_model->get_total_karyawan(),
            'total_karyawan_ijin' => $this->dashboard_model->get_total_karyawan_ijin(),
            'total_karyawan_terlambat' => $this->dashboard_model->get_total_karyawan_terlambat(),
            'total_karyawan_hadir' => $this->dashboard_model->get_total_karyawan_hadir()
        ];

		admin_view($header, 'dashboard', $data);
    }

    public function dt_last_scan_log()
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

        $param_model = [
            'start' => $start,
            'limit' => $limit,
            'search' => $search,
            'col_name' => $col_name,
            'order_dir' => $order_dir
        ];


        $get_last_scan = $this->dashboard_model->dt_select_last_scan_log($param_model);
        $select_last_scan = $get_last_scan->result_array();
        $count_last_scan = $get_last_scan->row_array();

        if (!empty($select_last_scan)) {
            $no = $start + 1;

            foreach ($select_last_scan as $scan) {
                $row = [];

                $pass_foto = '<img class="pass-foto me-2" src="'.site_url('assets/upload/scanlog/') . $scan['foto_scan']. '" alt>';

                $row[] = $pass_foto.$scan['nama_karyawan'];
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
