<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model(['karyawan_model']);
	}

    public function dt_karyawan()
	{
		$data = [];

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $col_idx = $this->input->get('order')[0]['column'];
		$order_dir = $this->input->get('order')[0]['dir'];

        $col_array = [
			null, 'mk.nama', 'mk.nip', null, 'mk.username', 
            'mk.jenis_kelamin', 'mj.jabatan', 'md.divisi'
        ];

        $col_name = isset($col_array[$col_idx]) ? $col_array[$col_idx] : 'id';

        $param_model = [
            'start' => $start,
            'limit' => $limit,
            'search' => $search,
            'col_name' => $col_name,
            'order_dir' => $order_dir
        ];


        $get_karyawan = $this->karyawan_model->dt_select_karyawan($param_model);
        $select_karyawan = $get_karyawan->result_array();
        $count_karyawan = $get_karyawan->row_array();

        if (!empty($select_karyawan)) {
            $no = $start + 1;

            foreach ($select_karyawan as $karyawan) {
                $row = [];

				$row[] = $no++;

				$row[] = $karyawan['nama_karyawan'];
				$row[] = $karyawan['nip_karyawan'];

                $pass_foto = '
                <a href="'.site_url('assets/upload/pass-foto/') . $karyawan['foto_karyawan'].'" target="_BLANK">
                    <div class="nk-activity-media">
                        <img class="pass-foto" src="'.site_url('assets/upload/pass-foto/') . $karyawan['foto_karyawan']. '" alt>
                    </div>
                </a>';

				$row[] = $pass_foto;
				$row[] = $karyawan['username'];
				$row[] = $karyawan['jenis_kelamin'];
				$row[] = $karyawan['jabatan_karyawan'];
				$row[] = $karyawan['divisi_karyawan'];

                $btn_delete = '
                <li>
                    <a href="javascript:;" onclick="delete_karyawan(this)" nip-kary="'.$karyawan['nip_karyawan'].'">
                        <em class="icon ni ni-user-remove-fill"></em>
                        <span>Delete Karyawan</span>
                    </a>
                </li>';

                $btn_reset_pass = '
                <li>
                    <a href="javascript:;" onclick="reset_password(this)" nip-kary="'.$karyawan['nip_karyawan'].'">
                        <em class="icon ni ni-reload-alt"></em>
                        <span>Reset Password</span>
                    </a>
                </li>';

                $btn_reset_deviceid = '
                <li>
                    <a href="javascript:;" onclick="reset_deviceid(this)" nip-kary="'.$karyawan['nip_karyawan'].'">
                        <em class="icon ni ni-regen-alt"></em>
                        <span>Reset Device ID</span>
                    </a>
                </li>';

                $btn_action = '
                <ul class="nk-tb-actions" style="display: block;">
                    <li>
                        <div class="drodown">
                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a href="'.site_url('karyawan/form_karyawan?nip-kary=').$karyawan['nip_karyawan'].'">
                                            <em class="icon ni ni-edit-fill"></em>
                                            <span>Update data</span>
                                        </a>
                                    </li>
                                    '.$btn_delete.'
                                    '.$btn_reset_pass.'
                                    '.$btn_reset_deviceid.'
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
            'recordsTotal' => isset($count_karyawan['total_record']) ? $count_karyawan['total_record'] : 0,
            'recordsFiltered' => isset($count_karyawan['total_record']) ? $count_karyawan['total_record'] : 0,
            'data' => $data
        ];

        return response_json($response);
	}

    public function submit_proses_karyawan()
    {
        $validator = [
            [
                'field' => 'nama_lengkap',
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'nik',
                'label' => 'NIK',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'tanggal_lahir',
                'label' => 'Tanggal Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'jenis_kelamin',
                'label' => 'Jenis Kelamin',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'phone',
                'label' => 'No. Telp',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'status_kawin',
                'label' => 'Status Kawin',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'agama',
                'label' => 'Agama',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'alamat_lengkap',
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'divisi',
                'label' => 'Divisi',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'jabatan',
                'label' => 'Jabatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
            [
                'field' => 'lokasi_kerja',
                'label' => 'Lokasi Kerja',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s harus diisi',
                ]
            ],
        ];

        $this->form_validation->set_rules($validator);
        
        if ($this->form_validation->run() === false) {
            $meta_status = 400;
            $meta_message = $this->form_validation->error_string();

        } else {
            $nip = $this->input->post('nip_karyawan');

            $pass_foto = '';

			$config_upload['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config_upload['max_size'] = 10000;
			$config_upload['file_ext_tolower'] = true;

			$this->load->library('upload');

            if (empty($nip)) {
                if (isset($_FILES['pass_foto'])) {
                    if ($_FILES['pass_foto']['size'] > 0) {
                        $config_upload['upload_path'] = './assets/upload/pass-foto';
                        $config_upload['file_name'] = time() . '_' . str_random(5);
    
                        $this->upload->initialize($config_upload);
    
                        if ($this->upload->do_upload('pass_foto')) {
                            $uploaded_pass_foto = $this->upload->data();
    
                            $pass_foto = $uploaded_pass_foto['file_name'];
                        }
                    }
                }
            } else {
                $karyawan = $this->karyawan_model->get_karyawan_by_nip($nip);
                $pass_foto = $karyawan['profile'];

                if (isset($_FILES['pass_foto'])) {
                    if ($_FILES['pass_foto']['size'] > 0) {
                        $config_upload['upload_path'] = './assets/upload/pass-foto';
                        $config_upload['file_name'] = time() . '_' . str_random(5);
    
                        $this->upload->initialize($config_upload);
    
                        if ($this->upload->do_upload('pass_foto')) {
                            $uploaded_pass_foto = $this->upload->data();
    
                            $pass_foto = $uploaded_pass_foto['file_name'];
                        }
                    }
                }
            }

            $params_model = [
                'nip' => $nip,
                'nama' => $this->input->post('nama_lengkap'),
                'nik' => $this->input->post('nik'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'phone' => $this->input->post('phone'),
                'status_kawin' => $this->input->post('status_kawin'),
                'agama' => $this->input->post('agama'),
                'alamat_lengkap' => $this->input->post('alamat_lengkap'),
                'email' => $this->input->post('email'),
                'divisi' => $this->input->post('divisi'),
                'username' => $this->input->post('username'),
                'jabatan' => $this->input->post('jabatan'),
                'lokasi_kerja' => $this->input->post('lokasi_kerja'),
                'is_admin' => $this->input->post('is_admin'),
                'pass_foto' => $pass_foto,
            ];

            $res_model = $this->karyawan_model->submit_proses_karyawan($params_model);

            switch ($res_model) {
                case '1':
                    $meta_status = 200;
                    $meta_message = 'Behasil menyimpan data karyawan!';
                    break;
                
                default:
                    $meta_status = 400;
                    $meta_message = 'Gagal menyimpan data karyawan!';
                    break;
            }
        }

        response_api($meta_status, $meta_message);
    }

    public function delete_karyawan()
    {
        $validator = [
            [
                'field' => 'nip',
                'label' => 'Nip',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Invalid Request',
                ]
            ]
        ];

        $this->form_validation->set_rules($validator);
        
        if ($this->form_validation->run() === false) {
            $meta_status = 400;
            $meta_message = $this->form_validation->error_string();

        } else {
            $nip = $this->input->post('nip');

            $delete_karyawan = 
                $this->db->where('nip', $nip)
                    ->update('ms_karyawan', [
                        'status' => 9
                    ]);

            if ($delete_karyawan === false) {
                $meta_status = 400;
                $meta_message = 'Gagal menghapus karyawan !';

            } else {
                $meta_status = 200;
                $meta_message = 'Berhasil menghapus karyawan !';
            }
        }

        response_api($meta_status, $meta_message);
    }

    public function reset_password_karyawan()
    {
        $validator = [
            [
                'field' => 'nip',
                'label' => 'Nip',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Invalid Request',
                ]
            ]
        ];

        $this->form_validation->set_rules($validator);
        
        if ($this->form_validation->run() === false) {
            $meta_status = 400;
            $meta_message = $this->form_validation->error_string();

        } else {
            $nip = $this->input->post('nip');

            $reset_password = $this->db->query("UPDATE ms_karyawan SET password = AES_ENCRYPT('123456', nip) WHERE nip = '$nip'");

            if ($reset_password === false) {
                $meta_status = 400;
                $meta_message = 'Gagal me-reset password !';

            } else {
                $meta_status = 200;
                $meta_message = 'Berhasil me-reset password !';
            }
        }

        response_api($meta_status, $meta_message);
    }

    public function reset_deviceid_karyawan()
    {
        $validator = [
            [
                'field' => 'nip',
                'label' => 'Nip',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Invalid Request',
                ]
            ]
        ];

        $this->form_validation->set_rules($validator);
        
        if ($this->form_validation->run() === false) {
            $meta_status = 400;
            $meta_message = $this->form_validation->error_string();

        } else {
            $nip = $this->input->post('nip');

            $reset_deviceid = 
                $this->db->where('nip', $nip)
                    ->update('ms_karyawan', [
                        'device_id' => '',
                        'user_token' => ''
                    ]);

            if ($reset_deviceid === false) {
                $meta_status = 400;
                $meta_message = 'Gagal me-reset Device ID !';

            } else {
                $meta_status = 200;
                $meta_message = 'Berhasil me-reset Device ID !';
            }
        }

        response_api($meta_status, $meta_message);
    }
}
