<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Karyawan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
    }

    public function dt_select_karyawan($params = [])
    {
		$start = isset($params['start']) ? $params['start'] : 0;
		$limit = isset($params['limit']) ? $params['limit'] : 10;

        $search = isset($params['search']) ? $params['search'] : '';
        $search = $this->db->escape_str($search);

        $col_name = isset($params['col_name']) ? $params['col_name'] : 'id';
		$order_dir = isset($params['order_dir']) ? $params['order_dir'] : 'asc';

        $query = $this->db->query("SELECT 
                mk.nama AS nama_karyawan,
                mk.nip AS nip_karyawan,
                mk.foto_profile AS foto_karyawan,
                mk.username, mk.jenis_kelamin,
                mj.jabatan AS jabatan_karyawan,
                md.divisi AS divisi_karyawan,
                COUNT(1) OVER() AS total_record
            FROM ms_karyawan mk 
            INNER JOIN ms_divisi md ON md.id = mk.id_divisi 
            INNER JOIN ms_jabatan mj ON mj.id = mk.id_jabatan
            WHERE mk.status = '1'
                AND (
                    mk.nama LIKE '%$search%'
                    OR mk.nip LIKE '%$search%'
                )
            ORDER BY $col_name $order_dir
            LIMIT $start, $limit");

        return $query;
    }

    public function get_karyawan_by_nip($nip_karyawan = '')
    {
        $query = $this->db->query("SELECT
                mk.nip, mk.nama,
                mk.username,
                mk.foto_profile AS profile,
                md.id AS id_divisi, md.divisi, 
                mj.id AS id_jabatan, mj.jabatan,
                mk.email, mk.phone AS no_telp,
                mk.nik, mk.tgl_lahir,
                mk.jenis_kelamin, 
                ma.id AS id_agama, ma.agama,
                mk.alamat, mk.status_kawin,
                msl.id AS id_lokasi_kerja,
                msl.lokasi AS lokasi_kerja
            FROM ms_karyawan mk
            LEFT JOIN ms_agama ma ON ma.id = mk.id_agama AND ma.status = 1
            LEFT JOIN ms_divisi md ON md.id = mk.id_divisi AND md.status = 1
            LEFT JOIN ms_jabatan mj ON mj.id = mk.id_jabatan AND mj.status = 1
            LEFT JOIN ms_scan_log msl ON msl.id = mk.id_lokasi_kerja AND msl.status = 1
            WHERE mk.nip = '$nip_karyawan'");

        return $query->row_array();
    }

    public function submit_proses_karyawan($params = [])
    {
        $nip = isset($params['nip']) ? $params['nip'] : '';
        $nama = isset($params['nama']) ? $params['nama'] : '';
        $nik = isset($params['nik']) ? $params['nik'] : '';
        $tanggal_lahir = isset($params['tanggal_lahir']) ? $params['tanggal_lahir'] : '';
        $jenis_kelamin = isset($params['jenis_kelamin']) ? $params['jenis_kelamin'] : '';
        $phone = isset($params['phone']) ? $params['phone'] : '';
        $status_kawin = isset($params['status_kawin']) ? $params['status_kawin'] : '';
        $agama = isset($params['agama']) ? $params['agama'] : '';
        $alamat_lengkap = isset($params['alamat_lengkap']) ? $params['alamat_lengkap'] : '';
        $email = isset($params['email']) ? $params['email'] : '';
        $divisi = isset($params['divisi']) ? $params['divisi'] : '';
        $username = isset($params['username']) ? $params['username'] : '';
        $jabatan = isset($params['jabatan']) ? $params['jabatan'] : '';
        $lokasi_kerja = isset($params['lokasi_kerja']) ? $params['lokasi_kerja'] : '';
        $is_admin = isset($params['is_admin']) ? $params['is_admin'] : '';
        $pass_foto = isset($params['pass_foto']) ? $params['pass_foto'] : '';

        $this->db->trans_begin();

        if (empty($nip)) {
            $nip = $this->master_model->generate_nip();
            $password = '123456';
            // $password = $this->master_model->password_generate($nip);

            $this->db->query("INSERT INTO ms_karyawan
                (
                    nip, nama, alamat, jenis_kelamin, 
                    email, username, password, foto_profile, 
                    phone, nik, tgl_lahir, id_agama, 
                    id_divisi, id_jabatan, id_lokasi_kerja, status_kawin, is_admin
                )
                VALUES (
                    '".$nip."', '".$nama."', '".$alamat_lengkap."', '".$jenis_kelamin."',
                    '".$email."', '".$username."', AES_ENCRYPT('".$password."', '".$nip."'), '".$pass_foto."',
                    '".$phone."', '".$nik."', '".$tanggal_lahir."', '".$agama."',
                    '".$divisi."', '".$jabatan."', '".$lokasi_kerja."', '".$status_kawin."', '".$is_admin."'
                )
            ");
        } else {
            $this->db->query("UPDATE ms_karyawan 
                SET nama = '$nama',
                    alamat = '$alamat_lengkap',
                    jenis_kelamin = '$jenis_kelamin',
                    email = '$email',
                    username = '$username',
                    foto_profile = '$pass_foto',
                    phone = '$phone',
                    nik = '$nik',
                    tgl_lahir = '$tanggal_lahir',
                    id_agama = '$agama',
                    id_divisi = '$divisi',
                    id_jabatan = '$jabatan',
                    status_kawin = '$status_kawin',
                    id_lokasi_kerja = '$lokasi_kerja',
                    is_admin = $is_admin
                WHERE nip = '$nip'");
        }


        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            return '0';
        } else {
            $this->db->trans_commit();

            return '1';
        }
    }
}