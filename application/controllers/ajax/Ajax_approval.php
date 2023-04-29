<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_approval extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->auth_model->check_login();
        $this->load->model(['ijin_karyawan_model']);
	}

    public function dt_ijin_karyawan()
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


        $get_ijin = $this->ijin_karyawan_model->dt_select_ijin_karyawan($param_model);
        $select_ijin = $get_ijin->result_array();
        $count_ijin = $get_ijin->row_array();

        if (!empty($select_ijin)) {
            $no = $start + 1;

            foreach ($select_ijin as $ijin) {
                $row = [];

                $row[] = $no++;

                $row[] = $ijin['nama_karyawan'];

                switch ($ijin['jenis_ijin']) {
                    case '1':
                        $jenis_ijin = 'Pulang Awal';
                        break;
                    
                    default:
                        $jenis_ijin = 'Keluar Kantor';
                        break;
                }

                $row[] = $jenis_ijin;
                $row[] = $ijin['tanggal_ijin'];
                $row[] = $ijin['jam_ijin'];
                $row[] = $ijin['keterangan_ijin'];

                switch ($ijin['status_ijin']) {
                    case '1':
                        $status_ijin = '<span class="badge rounded-pill bg-outline-info">Pengajuan</span>';
                        break;

                    case '2':
                        $status_ijin = '<span class="badge rounded-pill bg-outline-success">Approve</span>';
                        break;                    
                    
                    default:
                        $status_ijin = '<span class="badge rounded-pill bg-outline-danger">Ditolak</span>';
                        break;
                }

                $row[] = $status_ijin;

                if ($ijin['status_ijin'] != '1') {
                    $btn_action = '-';

                } else {
                    $btn_action = '
                    <ul class="nk-tb-actions" style="display: block;">
                        <li>
                            <div class="drodown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li>
                                            <a href="javascript:;" id-ijin="'.$ijin['id_ijin'].'"
                                                onclick="approval_ijin(this)">
                                                <em class="icon ni ni-edit-fill"></em>
                                                <span>Persetujuan Ijin</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>';
                }
                
                $row[] = $btn_action;
                
                $data[] = $row;
            }
        }


        $response = [
            'draw' => $this->input->get('draw'),
            'recordsTotal' => isset($count_ijin['total_record']) ? $count_ijin['total_record'] : 0,
            'recordsFiltered' => isset($count_ijin['total_record']) ? $count_ijin['total_record'] : 0,
            'data' => $data
        ];

        return response_json($response);
    }

    public function detail_ijin_karyawan()
    {
        $data = [];
        $id_ijin = $this->input->get('id-ijin');

        if (empty($id_ijin)) {
            $meta_status = 400;
            $meta_message = 'Invalid Request';

        } else {
            $get_detail_ijin = $this->ijin_karyawan_model->get_detail_ijin_karyawan($id_ijin);

            if (empty($get_detail_ijin)) {
                $meta_status = 400;
                $meta_message = 'Ijin karyawan tidak dapat dimuat';

            } else {
                $meta_status = 200;
                $meta_message = 'Ijin karyawan dimuat';

                $data = [
                    'detail_ijin' => $get_detail_ijin
                ];
            }
        }

        response_api($meta_status, $meta_message, $data);
    }

    public function approval_ijin_karyawan()
    {
        $validator = [
            [
                'field' => 'id_ijin',
                'label' => 'Ijin',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s tidak berlaku',
                ]
            ],
            [
                'field' => 'status_approval',
                'label' => 'Ijin',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s tidak berlaku',
                ]
            ]
        ];

        $this->form_validation->set_rules($validator);
        
        if ($this->form_validation->run() === false) {
            $meta_status = 400;
            $meta_message = $this->form_validation->error_string();

        } else {

            $id_ijin = $this->input->post('id_ijin');
            $status_approval = $this->input->post('status_approval');

            $process = 
                $this->db->where('id', $id_ijin)
                ->update('ijin_karyawan', [
                    'status_ijin' => $status_approval
                ]);

            if ($process === FALSE) {
                $meta_status = 400;
                $meta_message = 'Gagal memproses persetujuan ijin';

            } else {
                $meta_status = 200;
                $meta_message = 'Berhasil memproses persetujuan ijin';

            }
        }

        response_api($meta_status, $meta_message);
    }

    public function dt_cuti_karyawan()
    {
        $data = [];

        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $col_idx = $this->input->get('order')[0]['column'];
        $order_dir = $this->input->get('order')[0]['dir'];

        $col_array = [
            null, 'mk.nama', 'ck.tgl_mulai', 'ck.tgl_selesai', 'ck.keterangan', 'ck.status_cuti', null
        ];

        $col_name = isset($col_array[$col_idx]) ? $col_array[$col_idx] : 'ck.tgl_mulai';

        $param_model = [
            'start' => $start,
            'limit' => $limit,
            'search' => $search,
            'col_name' => $col_name,
            'order_dir' => $order_dir
        ];


        $get_cuti = $this->ijin_karyawan_model->dt_select_cuti_karyawan($param_model);
        $select_cuti = $get_cuti->result_array();
        $count_cuti = $get_cuti->row_array();

        if (!empty($select_cuti)) {
            $no = $start + 1;

            foreach ($select_cuti as $cuti) {
                $row = [];

                $row[] = $no++;
                $row[] = $cuti['nama_karyawan'];
                $row[] = $cuti['mulai_cuti'];
                $row[] = $cuti['selesai_cuti'];
                $row[] = $cuti['keterangan_cuti'];

                switch ($cuti['status_cuti']) {
                    case '1':
                        $status_ijin = '<span class="badge rounded-pill bg-outline-info">Pengajuan</span>';
                        break;

                    case '2':
                        $status_ijin = '<span class="badge rounded-pill bg-outline-success">Approve</span>';
                        break;                    
                    
                    default:
                        $status_ijin = '<span class="badge rounded-pill bg-outline-danger">Ditolak</span>';
                        break;
                }

                $row[] = $status_ijin;

                if ($cuti['status_cuti'] != '1') {
                    $btn_action = '-';

                } else {
                    $btn_action = '
                    <ul class="nk-tb-actions" style="display: block;">
                        <li>
                            <div class="drodown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li>
                                            <a href="javascript:;" id-cuti="'.$cuti['id_cuti'].'"
                                                onclick="approval_cuti(this)">
                                                <em class="icon ni ni-edit-fill"></em>
                                                <span>Persetujuan Cuti</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>';
                }
                
                $row[] = $btn_action;
                
                $data[] = $row;
            }
        }


        $response = [
            'draw' => $this->input->get('draw'),
            'recordsTotal' => isset($count_cuti['total_record']) ? $count_cuti['total_record'] : 0,
            'recordsFiltered' => isset($count_cuti['total_record']) ? $count_cuti['total_record'] : 0,
            'data' => $data
        ];

        return response_json($response);
    }

    public function detail_cuti_karyawan()
    {
        $data = [];
        $id_cuti = $this->input->get('id-cuti');

        if (empty($id_cuti)) {
            $meta_status = 400;
            $meta_message = 'Invalid Request';

        } else {
            $get_detail_cuti = $this->ijin_karyawan_model->get_detail_cuti_karyawan($id_cuti);

            if (empty($get_detail_cuti)) {
                $meta_status = 400;
                $meta_message = 'Cuti karyawan tidak dapat dimuat';

            } else {
                $meta_status = 200;
                $meta_message = 'Cuti karyawan dimuat';

                $data = [
                    'detail_cuti' => $get_detail_cuti
                ];
            }
        }

        response_api($meta_status, $meta_message, $data);
    }

    public function approval_cuti_karyawan()
    {
        $validator = [
            [
                'field' => 'id_cuti',
                'label' => 'Cuti',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s tidak berlaku',
                ]
            ],
            [
                'field' => 'status_approval',
                'label' => 'Cuti',
                'rules' => 'required',
                'errors' => [
                    'required' => '%s tidak berlaku',
                ]
            ]
        ];

        $this->form_validation->set_rules($validator);
        
        if ($this->form_validation->run() === false) {
            $meta_status = 400;
            $meta_message = $this->form_validation->error_string();

        } else {

            $id_cuti = $this->input->post('id_cuti');
            $status_approval = $this->input->post('status_approval');

            $process = 
                $this->db->where('id', $id_cuti)
                ->update('cuti_karyawan', [
                    'status_cuti' => $status_approval
                ]);

            if ($process === FALSE) {
                $meta_status = 400;
                $meta_message = 'Gagal memproses persetujuan cuti';

            } else {
                $meta_status = 200;
                $meta_message = 'Berhasil memproses persetujuan cuti';

            }
        }

        response_api($meta_status, $meta_message);
    }
}