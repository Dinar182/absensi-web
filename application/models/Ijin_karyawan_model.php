<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Ijin_karyawan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
    }

    public function dt_select_ijin_karyawan($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 10;

        $search = isset($params['search']) ? $params['search'] : '';
        $search = $this->db->escape_str($search);

        $col_name = isset($params['col_name']) ? $params['col_name'] : 'ik.tanggal';
        $order_dir = isset($params['order_dir']) ? $params['order_dir'] : 'ASC';

        $query = $this->db->query("SELECT 
                    ik.id AS id_ijin,
                    mk.nip AS nip_karyawan,
                    mk.nama AS nama_karyawan,
                    ik.jenis_ijin,
                    ik.tanggal AS tanggal_ijin,
                    ik.jam AS jam_ijin,
                    ik.status_ijin,
                    ik.keterangan AS keterangan_ijin,
                    COUNT(1) OVER() AS total_record
                FROM ijin_karyawan ik 
                INNER JOIN ms_karyawan mk ON mk.nip = ik.nip
                WHERE ik.status = '1'
                    AND ik.status_ijin <> '4'
                    AND (
                        mk.nip LIKE '%$search%'
                        OR mk.nama LIKE '%$search%'
                        OR ik.keterangan LIKE '%$search%'
                    )
                ORDER BY $col_name $order_dir
                LIMIT $start, $limit");

        return $query;
    }

    public function get_detail_ijin_karyawan($id_ijin = 0)
    {
        $query = $this->db->query("SELECT 
            ik.id AS id_ijin,
            mk.nama AS nama_karyawan,
            CASE 
                WHEN ik.jenis_ijin = 1 THEN 'Pulang Awal'
                ELSE 'Keluar Kantor'
            END AS jenis_ijin,
            CONCAT(ik.tanggal, ' ', ik.jam) AS tanggal_ijin,
            ik.keterangan AS keterangan_ijin
        FROM ijin_karyawan ik 
        INNER JOIN ms_karyawan mk ON mk.nip = ik.nip 
        WHERE ik.id = '$id_ijin'");

        return $query->row_array();
    }

    public function dt_select_cuti_karyawan($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 10;

        $search = isset($params['search']) ? $params['search'] : '';
        $search = $this->db->escape_str($search);

        $col_name = isset($params['col_name']) ? $params['col_name'] : 'ck.tgl_mulai';
        $order_dir = isset($params['order_dir']) ? $params['order_dir'] : 'ASC';

        $query = $this->db->query("SELECT 
                    ck.id AS id_cuti,
                    mk.nama AS nama_karyawan,
                    ck.tgl_mulai AS mulai_cuti,
                    ck.tgl_selesai AS selesai_cuti,
                    ck.keterangan AS keterangan_cuti,
                    ck.status_cuti,
                    COUNT(1) OVER() AS total_record
                FROM cuti_karyawan ck 
                INNER JOIN ms_karyawan mk ON mk.nip = ck.nip 
                WHERE ck.status = '1'
                    AND mk.status = '1'
                    AND (
                        mk.nama LIKE '%$search%'
                        OR mk.nip LIKE '%$search%'
                        OR ck.keterangan LIKE '%$search%'
                    )
                ORDER BY $col_name $order_dir
                LIMIT $start, $limit");

        return $query;
    }

    public function get_detail_cuti_karyawan($id_cuti = 0)
    {
        $query = $this->db->query("SELECT 
                    ck.id AS id_cuti,
                    mk.nama AS nama_karyawan,
                    ck.tgl_mulai AS mulai_cuti,
                    ck.tgl_selesai AS selesai_cuti,
                    ck.keterangan AS keterangan_cuti
                FROM cuti_karyawan ck 
                INNER JOIN ms_karyawan mk ON mk.nip = ck.nip 
                WHERE ck.id = '$id_cuti'");

        return $query->row_array();
    }
}