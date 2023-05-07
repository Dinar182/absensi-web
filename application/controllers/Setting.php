<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model('setting_model');
	}

    public function index()
    {
        $header = [
            'page_main_nav' => 'setting'
        ];



        $data = [
            'page_title' => 'Setting Absensi',
            'bottom_js_pages' => '
                <script src="'. site_url('assets/js/page/setting/seting-absensi.js?_=') . rand() .'"></script>
            ',

            'data' => $this->setting_model->get_setting_absensi()
        ];

        admin_view($header, 'page/setting/seting-absensi', $data);
    }

    public function submit_simpan_setting()
    {
        $validator = [
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
            $jam_masuk = $this->input->post('jam_masuk');
            $jam_pulang = $this->input->post('jam_pulang');
            $radius = $this->input->post('radius');

            $koordinat = $this->input->post('koordinat');
            $exp_koor = explode(',', $koordinat);

            $latitude = $exp_koor[0];
            $longtitude = $exp_koor[1];

            $process = $this->db->update('ms_scan_log', [
                'jam_masuk' => $jam_masuk,
                'jam_pulang' => $jam_pulang,
                'radius' => $radius,
                'latitude' => trim($latitude),
                'longtitude' => trim($longtitude)
            ]);

            if ($process === true) {
                $meta_status = 200;
                $meta_message = 'Berhasil menyimpan setting';

            } else {
                $meta_status = 400;
                $meta_message = 'Gagal menyimpan setting';

            }
        }

        response_api($meta_status, $meta_message);
    }
}