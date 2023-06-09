<?php defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Api extends CI_Controller
{
    function __construct()
    {
	    header("Access-Control-Allow-Origin: *"); 
        header("Access-Control-Allow-Methods: POST, OPTIONS"); 
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); 
        header("Access-Control-Max-Age: 86400");
        header("Access-Control-Allow-Credentials: true");
        $method = $_SERVER['REQUEST_METHOD']; 
        if($method == "OPTIONS") { die(); }
		
        parent::__construct();
        $this->load->model('api_model');
        $this->api_model->store_log_post_data();

        $this->form_validation->set_error_delimiters('', ''); 

    }

    public function login()
    {
        $data = [];

        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

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
                ],
                [
                    'field' => 'device_id',
                    'label' => 'Device ID',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '%s tidak terdeteksi'
                    ]
                ]
            ];

            $this->form_validation->set_rules($validator);
            
            if ($this->form_validation->run() === false) {
                $meta_status = 400;
                $meta_message = $this->form_validation->error_string();
                

            } else {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $device_id = $this->input->post('device_id');
                
                $check_user = $this->api_model->check_user($username, $password);
    
                if (empty($check_user)) {
                    $meta_status = 400;
                    $meta_message = 'Username / Password salah!';
    
                } else {

                    if ($check_user['is_admin'] == 1) {
                        # jika akun login adalah admin
                        # maka gagal login

                        $meta_status = 400;
                        $meta_message = 'Anda tidak memiliki akses ke aplikasi!';

                    } else {
                        
                        if ($check_user['device_id'] == '') {
                            # jika device id terdaftar kosong
                            # maka insert device id di akun 
                            # login berhasil

                            $device_id_valid = true;

                            $this->db->where('nip', $check_user['nip'])
                            ->update('ms_karyawan', [
                                'device_id' => $device_id
                            ]);

                        } else if ($check_user['device_id'] == $device_id) {
                            # jika device id perangkat sama dengan yang terdaftar
                            # maka login berhasil

                            $device_id_valid = true;

                        } else {
                            # jika device id perangkat tidak sama dengan yang terdaftar
                            # maka login gagal

                            $device_id_valid = false;

                        }

                        if ($device_id_valid === false) {
                            $meta_status = 400;
                            $meta_message = 'ID perangkat tidak sesuai !';

                        } else {
                            $meta_status = 200;
                            $meta_message = 'Berhasil login !';
        
                            $token_payload = $check_user;
                            $token_payload['expired'] = time() + 500000;
        
                            $encode_data = json_encode($token_payload);
                            $user_token = token_encrypt($encode_data);
        
                            $this->db->where('nip', $check_user['nip'])
                                ->update('ms_karyawan', [
                                    'user_token' => $user_token
                                ]);
            
                            $data = [
                                'karyawan' => $check_user,
                                'token' => $user_token
                            ];
                        }
                    }
                }
            }
        }

        response_api($meta_status, $meta_message, $data);
    }

    public function detail_karyawan()
    {
        $data = [];

        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $header_authentication = $this->api_model->header_authentication();

            if ($header_authentication === false) {
                $meta_status = 401;
                $meta_message = 'Unauthorized, invalid request';

            } else {
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
                    
                    $detail_karyawan = $this->api_model->get_detail_karyawan($nip);
        
                    if (empty($detail_karyawan)) {
                        $meta_status = 400;
                        $meta_message = 'Data karyawan tidak ditemukan !';
        
                    } else {
                        $meta_status = 200;
                        $meta_message = 'Data karyawan ditemukan !';
        
                        $data = $detail_karyawan;
                    }
                }
            }
        }

        response_api($meta_status, $meta_message, $data);
    }

    public function ganti_password()
    {
        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $header_authentication = $this->api_model->header_authentication();

            if ($header_authentication === false) {
                $meta_status = 401;
                $meta_message = 'Unauthorized, invalid request';

            } else {
                $validator = [
                    [
                        'field' => 'nip',
                        'label' => 'Nip',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Invalid Request',
                        ]
                    ],
                    [
                        'field' => 'password_lama',
                        'label' => 'Password Lama',
                        'rules' => 'required|alpha_numeric',
                        'errors' => [
                            'required' => '%s harus diisi',
                            'alpha_numeric' => '%s tidak berlaku'
                        ]
                    ],
                    [
                        'field' => 'password_baru',
                        'label' => 'Password Baru',
                        'rules' => 'required|alpha_numeric',
                        'errors' => [
                            'required' => '%s harus diisi',
                            'alpha_numeric' => '%s tidak berlaku'
                        ]
                    ]
                ];
    
                $this->form_validation->set_rules($validator);
                
                if ($this->form_validation->run() === false) {
                    $meta_status = 400;
                    $meta_message = $this->form_validation->error_string();
    
                } else {
                    $nip = $this->input->post('nip');
                    $password_lama = $this->input->post('password_lama');
                    $password_baru = $this->input->post('password_baru');
    
                    $karyawan = $this->api_model->get_karyawan_by_nip($nip);
    
                    if ($password_lama != $karyawan['password']) {
                        $meta_status = 400;
                        $meta_message = 'Password lama tidak sesuai!';
    
                    } else {
                        $params_model = [
                            'nip' => $nip,
                            'password_baru' => $password_baru,
                        ];
    
                        $res_model = $this->api_model->update_password($params_model);
    
                        switch ($res_model) {
                            case '1':
                                $meta_status = 200;
                                $meta_message = 'Behasil mengubah password!';
                                break;
                            
                            default:
                                $meta_status = 400;
                                $meta_message = 'Gagal mengubah password!';
                                break;
                        }
                    }
                }
            }
        }

        response_api($meta_status, $meta_message);
    }

    public function cuti_karyawan()
    {
        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $header_authentication = $this->api_model->header_authentication();

            if ($header_authentication === false) {
                $meta_status = 401;
                $meta_message = 'Unauthorized, invalid request';

            } else {
                $validator = [
                    [
                        'field' => 'nip',
                        'label' => 'NIP',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Invalid Request',
                        ]
                    ],
                    [
                        'field' => 'tanggal_mulai',
                        'label' => 'Tanggal Mulai',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '%s harus diisi',
                        ]
                    ],
                    [
                        'field' => 'tanggal_selesai',
                        'label' => 'Tanggal Selesai',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '%s harus diisi',
                        ]
                    ],
                    [
                        'field' => 'keterangan',
                        'label' => 'Keterangan',
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
    
                    $params_model = [
                        'nip' => $this->input->post('nip'),
                        'tanggal_mulai' => $this->input->post('tanggal_mulai'),
                        'tanggal_selesai' => $this->input->post('tanggal_selesai'),
                        'keterangan' => $this->input->post('keterangan')
                    ];
    
                    $res_model = $this->api_model->submit_cuti_karyawan($params_model);
    
                    switch ($res_model) {
                        case '1':
                            $meta_status = 200;
                            $meta_message = 'Behasil mengajukan cuti!';
                            break;

                        case '2':
                            $meta_status = 400;
                            $meta_message = 'Anda masih memiliki Outstanding cuti!';
                            break;
                        
                        default:
                            $meta_status = 400;
                            $meta_message = 'Gagal mengajukan cuti!';
                            break;
                    }
                }
            }
        }

        response_api($meta_status, $meta_message);
    }

    public function ijin_karyawan()
    {
        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $header_authentication = $this->api_model->header_authentication();

            if ($header_authentication === false) {
                $meta_status = 401;
                $meta_message = 'Unauthorized, invalid request';

            } else {
                $validator = [
                    [
                        'field' => 'nip',
                        'label' => 'NIP',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Invalid Request',
                        ]
                    ],
                    [
                        'field' => 'jenis_ijin',
                        'label' => 'Jenis Ijin',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '%s harus diisi',
                        ]
                    ],
                    [
                        'field' => 'tanggal',
                        'label' => 'Tanggal',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '%s harus diisi',
                        ]
                    ],
                    [
                        'field' => 'jam',
                        'label' => 'Jam',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '%s harus diisi',
                        ]
                    ],
                    [
                        'field' => 'keterangan',
                        'label' => 'Keterangan',
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
    
                    $params_model = [
                        'nip' => $this->input->post('nip'),
                        'jenis_ijin' => $this->input->post('jenis_ijin'),
                        'tanggal' => $this->input->post('tanggal'),
                        'jam' => $this->input->post('jam'),
                        'keterangan' => $this->input->post('keterangan')
                    ];
    
                    $res_model = $this->api_model->submit_ijin_karyawan($params_model);
    
                    switch ($res_model) {
                        case '1':
                            $meta_status = 200;
                            $meta_message = 'Behasil mengajukan ijin!';
                            break;

                        case '2':
                            $meta_status = 400;
                            $meta_message = 'Anda masih memiliki Outstanding ijin!';
                            break;
                        
                        default:
                            $meta_status = 400;
                            $meta_message = 'Gagal mengajukan ijin!';
                            break;
                    }
                }
            }
        }

        response_api($meta_status, $meta_message);
    }

    public function scan_log()
    {
        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $header_authentication = $this->api_model->header_authentication();

            if ($header_authentication === false) {
                $meta_status = 401;
                $meta_message = 'Unauthorized, invalid request';

            } else {
                $validator = [
                    [
                        'field' => 'nip',
                        'label' => 'NIP',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Invalid Request',
                        ]
                    ],
                    [
                        'field' => 'latitude',
                        'label' => 'Lokasi',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '%s tidak terdeteksi',
                        ]
                    ],
                    [
                        'field' => 'longtitude',
                        'label' => 'Lokasi',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '%s tidak terdeteksi',
                        ]
                    ]
                ];
    
                if (isset($_FILES['foto'])) {
                    if ($_FILES['foto']['size'] == 0) {
                        array_push($validator, [
                            'field' => 'foto',
                            'label' => 'Foto',
                            'rules' => 'required',
                            'errors' => [
                                'required' => '%s tidak terdeteksi'
                            ]
                        ]);
                    }
                }
    
                $this->form_validation->set_rules($validator);
                
                if ($this->form_validation->run() === false) {
                    $meta_status = 400;
                    $meta_message = $this->form_validation->error_string();
    
                } else {
                    $mid_day = '12:00';
                    $jam = date('H:i:s');
                    $nip = $this->input->post('nip');
                    $latitude = $this->input->post('latitude');
                    $longtitude = $this->input->post('longtitude');

                    $lokasi_kerja = $this->api_model->get_lokasi_kerja($nip);
    
                    if (strtotime($jam) > strtotime($lokasi_kerja['jam_pulang'])) {
                        $flag_scan = '2'; # Checkout
                        $scan_message = 'Absen Pulang !';
    
                    } else {
                        $flag_scan = '1'; # checkin
                        $scan_message = 'Absen Masuk !';
                    }
    
                    $params_model = [
                        'nip' => $nip,
                        'tanggal' => date('Y-m-d'),
                        'jam' => $jam,
                        'flag_scan' => $flag_scan,
                        'latitude' => $latitude,
                        'longtitude' => $longtitude
                    ];
    
                    $res_model = $this->api_model->scan_log($params_model);
    
                    switch ($res_model) {
                        case '1':
                            $meta_status = 200;
                            $meta_message = 'Behasil '. $scan_message .PHP_EOL;
                            $meta_message .= 'Koordinat : '. $latitude .', '. $longtitude;
                            break;
    
                        case '2':
                            $meta_status = 400;
                            $meta_message = 'Anda tidak dalam radius yang valid' .PHP_EOL;
                            $meta_message .= 'Koordinat : '. $latitude .', '. $longtitude;
                            break;

                        case '3':
                            $meta_status = 400;
                            $meta_message = 'Lokasi kerja belum terdaftar';
                            break;
                        
                        default:
                            $meta_status = 400;
                            $meta_message = 'Gagal '. $scan_message;
                            break;
                    }
                }
            }
        }

        response_api($meta_status, $meta_message);      
    }

    public function rekap_absensi()
    {
        $data = [];

        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $header_authentication = $this->api_model->header_authentication();

            if ($header_authentication === false) {
                $meta_status = 401;
                $meta_message = 'Unauthorized, invalid request';

            } else {
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
                    $meta_status = 200;
                    $meta_message = 'Data rekap dimuat!';
    
                    $nip = $this->input->post('nip');
                    $tanggal_mulai = $this->input->post('tanggal_mulai');
                    $tanggal_sampai = $this->input->post('tanggal_sampai');
    
                    $rekap_absensi = $this->api_model->rekap_absensi_karyawan($nip, $tanggal_mulai, $tanggal_sampai);
                    $total_telat = isset($rekap_absensi['total_telat']) ? $rekap_absensi['total_telat'] : 0;
                    $tidak_absen_masuk = isset($rekap_absensi['tidak_absen_masuk']) ? $rekap_absensi['tidak_absen_masuk'] : 0;
                    $tidak_absen_pulang = isset($rekap_absensi['tidak_absen_pulang']) ? $rekap_absensi['tidak_absen_pulang'] : 0;
    
                    $data = [
                        'rekap_absensi' => [
                            'total_telat' => $total_telat,
                            'tidak_absen_masuk' => $tidak_absen_masuk,
                            'tidak_absen_pulang' => $tidak_absen_pulang
                        ],
    
                        'detail_rekap' => $this->api_model->detail_rekap_absensi($nip, $tanggal_mulai, $tanggal_sampai)
                    ];
                }
            }

        }

        response_api($meta_status, $meta_message, $data);
    }

    public function dayli_absen_karyawan()
    {
        $data = [];

        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $header_authentication = $this->api_model->header_authentication();

            if ($header_authentication === false) {
                $meta_status = 401;
                $meta_message = 'Unauthorized, invalid request';

            } else {
                
                $validator = [
                    [
                        'field' => 'nip',
                        'label' => 'Nip',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Invalid Request',
                        ]
                    ],
                    [
                        'field' => 'tanggal',
                        'label' => 'Tanggal',
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
                    $meta_status = 200;
                    $meta_message = 'Data rekap dimuat!';
    
                    $nip = $this->input->post('nip');
                    $tanggal = $this->input->post('tanggal');
    
                    $rekap_absensi = $this->api_model->rekap_dayli_absensi($nip, $tanggal);
    
                    $data = [
                        'rekap_absensi' => $rekap_absensi,
                    ];
                }
            }

        }

        response_api($meta_status, $meta_message, $data);
    }

    public function logout()
    {
        $data = [];

        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $validator = [
                [
                    'field' => 'nip',
                    'label' => 'Karyawan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '%s tidak berlaku'
                    ]
                ]
            ];

            $this->form_validation->set_rules($validator);
            
            if ($this->form_validation->run() === false) {
                $meta_status = 400;
                $meta_message = $this->form_validation->error_string();

            } else {
                $nip = $this->input->post('nip');
                
                $logout = 
                    $this->db->where('nip', $nip)
                        ->update('ms_karyawan', [
                            'user_token' => ''
                        ]);

    
                if ($logout === FALSE) {
                    $meta_status = 400;
                    $meta_message = 'Gagal Logout !';
    
                } else {
                    $meta_status = 200;
                    $meta_message = 'Berhasil Lgout !';
                }
            }
        }

        response_api($meta_status, $meta_message);
    }

    public function current_scanlog()
    {
        $data = [];

        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $validator = [
                [
                    'field' => 'nip',
                    'label' => 'Karyawan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '%s tidak berlaku'
                    ]
                ]
            ];

            $this->form_validation->set_rules($validator);
            
            if ($this->form_validation->run() === false) {
                $meta_status = 400;
                $meta_message = $this->form_validation->error_string();

            } else {
                $nip = $this->input->post('nip');
                $tanggal = $this->input->post('tanggal');
                $get_current_scan = $this->api_model->get_current_scanlog($nip, $tanggal);
    
                if (empty($get_current_scan)) {
                    $meta_status = 400;
                    $meta_message = 'Karyawan tidak ditemukan';
    
                } else {
                    $meta_status = 200;
                    $meta_message = 'Berhasil memuat data';

                    $data = $get_current_scan;
                }
            }
        }

        response_api($meta_status, $meta_message, $data);
    }

    public function history_ijin()
    {
        $data = [];

        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $validator = [
                [
                    'field' => 'nip',
                    'label' => 'Karyawan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '%s tidak berlaku'
                    ]
                ]
            ];

            $this->form_validation->set_rules($validator);
            
            if ($this->form_validation->run() === false) {
                $meta_status = 400;
                $meta_message = $this->form_validation->error_string();

            } else {
                $nip = $this->input->post('nip');
                $get_history_ijin = $this->api_model->get_history_ijin($nip);
    
                if (empty($get_history_ijin)) {
                    $meta_status = 400;
                    $meta_message = 'Karyawan tidak ditemukan';
    
                } else {
                    $meta_status = 200;
                    $meta_message = 'Berhasil memuat data';

                    $data = $get_history_ijin;
                }
            }
        }

        response_api($meta_status, $meta_message, $data);
    }

    public function history_cuti()
    {
        $data = [];

        if ($this->input->method() != 'post') {
            $meta_status = 405;
            $meta_message = 'Request method not allowed';

        } else {
            $validator = [
                [
                    'field' => 'nip',
                    'label' => 'Karyawan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '%s tidak berlaku'
                    ]
                ]
            ];

            $this->form_validation->set_rules($validator);
            
            if ($this->form_validation->run() === false) {
                $meta_status = 400;
                $meta_message = $this->form_validation->error_string();

            } else {
                $nip = $this->input->post('nip');
                $get_history_cuti = $this->api_model->get_history_cuti($nip);
    
                if (empty($get_history_cuti)) {
                    $meta_status = 400;
                    $meta_message = 'Karyawan tidak ditemukan';
    
                } else {
                    $meta_status = 200;
                    $meta_message = 'Berhasil memuat data';

                    $data = $get_history_cuti;
                }
            }
        }

        response_api($meta_status, $meta_message, $data);
    }
}
