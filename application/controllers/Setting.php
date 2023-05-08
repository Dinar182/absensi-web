<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model('setting_model');
	}

    public function form_lokasi_kerja($id_lokasi = 0)
    {
        $header = [
            'page_main_nav' => 'Setting Lokasi'
        ];

        $data = [
            'page_title' => 'Setting Lokasi',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/page/setting/seting-absensi.js?_=') . rand() .'"></script>
            ',

            'data' => $this->setting_model->get_setting_absensi($id_lokasi)
        ];

        admin_view($header, 'page/setting/seting-absensi', $data);
    }

    public function setting_lokasi_kerja()
    {
        $header = [
            'page_main_nav' => 'Lokasi Kerja'
        ];

        $data = [
            'page_title' => 'Setting Absensi',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/page/setting/lokasi-kerja.js?_=') . rand() .'"></script>
            '
        ];

        admin_view($header, 'page/setting/lokasi-kerja', $data);
    }

    public function submit_simpan_setting()
    {
        $validator = [
            [
                'field' => 'lokasi_kerja',
                'label' => 'Lokasi',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'jam_masuk',
                'label' => 'Jam Masuk',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'jam_pulang',
                'label' => 'Jam Pulang',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'radius',
                'label' => 'Radius',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'koordinat',
                'label' => 'Koordinat',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ]
        ];

        $this->form_validation->set_rules($validator);
        
        if ($this->form_validation->run() === false) {
            $meta_status = 400;
            $meta_message = $this->form_validation->error_string();

        } else {
            $id_lokasi = $this->input->post('id_lokasi');
            $lokasi_kerja = $this->input->post('lokasi_kerja');
            $jam_masuk = $this->input->post('jam_masuk');
            $jam_pulang = $this->input->post('jam_pulang');
            $radius = $this->input->post('radius');

            $koordinat = $this->input->post('koordinat');
            $exp_koor = explode(',', $koordinat);

            $latitude = $exp_koor[0];
            $longtitude = $exp_koor[1];

            if ($id_lokasi == 0) {
                $process_lokasi = $this->db->insert('ms_scan_log', [
                    'lokasi' => $lokasi_kerja,
                    'jam_masuk' => $jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'radius' => $radius,
                    'latitude' => trim($latitude),
                    'longtitude' => trim($longtitude)                    
                ]);

            } else {

                $process_lokasi = $this->db->where('id', $id_lokasi)
                    ->update('ms_scan_log', [
                        'lokasi' => $lokasi_kerja,
                        'jam_masuk' => $jam_masuk,
                        'jam_pulang' => $jam_pulang,
                        'radius' => $radius,
                        'latitude' => trim($latitude),
                        'longtitude' => trim($longtitude)
                ]);
            }


            if ($process_lokasi === true) {
                $meta_status = 200;
                $meta_message = 'Berhasil menyimpan setting';

            } else {
                $meta_status = 400;
                $meta_message = 'Gagal menyimpan setting';

            }
        }

        response_api($meta_status, $meta_message);
    }

    public function dt_lokasi_kerja()
    {
		$data = [];

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $col_idx = $this->input->get('order')[0]['column'];
		$order_dir = $this->input->get('order')[0]['dir'];

        $col_array = [
			null, 'lokasi', 'jam_masuk', 'jam_pulang', 'latitude', 'radius'
        ];

        $col_name = isset($col_array[$col_idx]) ? $col_array[$col_idx] : 'id';

        $param_model = [
            'start' => $start,
            'limit' => $limit,
            'search' => $search,
            'col_name' => $col_name,
            'order_dir' => $order_dir
        ];


        $get_lokasi = $this->setting_model->dt_select_lokasi_kerja($param_model);
        $select_lokasi = $get_lokasi->result_array();
        $count_lokasi = $get_lokasi->row_array();

        if (!empty($select_lokasi)) {
            $no = $start + 1;

            foreach ($select_lokasi as $lokasi) {
                $row = [];

				$row[] = $no++;

				$row[] = $lokasi['lokasi'];
				$row[] = $lokasi['jam_masuk'];
				$row[] = $lokasi['jam_pulang'];
				$row[] = $lokasi['latitude'].', '.$lokasi['longtitude'];
				$row[] = $lokasi['radius'].' Meter';

                $btn_action = '
                <ul class="nk-tb-actions" style="display: block;">
                    <li>
                        <div class="drodown">
                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a href="'.site_url('setting/form_lokasi_kerja/').$lokasi['id'].'">
                                            <em class="icon ni ni-edit-fill"></em>
                                            <span>Update data</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>';

				$row[] = $btn_action;
                
                $data[] = $row;
            }
        }


        $response = [
            'draw' => $this->input->get('draw'),
            'recordsTotal' => isset($count_lokasi['total_record']) ? $count_lokasi['total_record'] : 0,
            'recordsFiltered' => isset($count_lokasi['total_record']) ? $count_lokasi['total_record'] : 0,
            'data' => $data
        ];

        return response_json($response);
    }
}