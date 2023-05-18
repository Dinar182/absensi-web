<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_total_karyawan()
    {
        $query = $this->db->query("SELECT
                COUNT(*) AS total_karyawan
            FROM ms_karyawan mk
            WHERE mk.status = '1'")->row_array();

        return $query['total_karyawan'];
    }

    public function get_total_karyawan_ijin()
    {
        $query = $this->db->query("SELECT 
                    COUNT(*) AS total_ijin
                FROM ijin_karyawan ik
                WHERE ik.status = '1'
                    AND ik.status_ijin = '2'
                    AND ik.tanggal = DATE(NOW())")->row_array();

        return $query['total_ijin'];
    }

    public function get_total_karyawan_cuti()
    {
        $query = $this->db->query("SELECT 
                    COUNT(*) AS total_ijin
                FROM cuti_karyawan ck
                WHERE ck.status = '1'
                    AND ck.status_cuti = '2'
                    AND DATE(NOW()) BETWEEN ck.tgl_mulai AND ck.tgl_selesai")->row_array();

        return $query['total_ijin'];
    }

    public function get_total_karyawan_terlambat()
    {
        $query = $this->db->query("SELECT 
                    COUNT(*) AS total_karyawan_terlambat
                FROM ms_karyawan mk 
                INNER JOIN (
                    SELECT *
                    FROM absensi_karyawan ak 
                    WHERE ak.status = '1'
                        AND ak.status_absen = '2'
                        AND ak.tanggal = DATE(NOW())
                    GROUP BY ak.nip
                ) ab ON ab.nip = mk.nip 
                WHERE mk.status  = '1'")->row_array();

        return $query['total_karyawan_terlambat'];
    }

    public function get_total_karyawan_hadir()
    {
        $query = $this->db->query("SELECT 
                    COUNT(*) AS karyawan_hadir
                FROM ms_karyawan mk 
                INNER JOIN (
                    SELECT *
                    FROM absensi_karyawan ak 
                    WHERE ak.status = '1'
                        AND ak.flag_scan = '1'
                        AND ak.tanggal = DATE(NOW())
                    GROUP BY ak.nip
                ) ab ON ab.nip = mk.nip 
                WHERE mk.status  = '1'")->row_array();

        return $query['karyawan_hadir'];
    }

    public function dt_select_last_scan_log($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 10;

        $search = isset($params['search']) ? $params['search'] : '';
        $search = $this->db->escape_str($search);

        $col_name = isset($params['col_name']) ? $params['col_name'] : 'ak.jam';
        $order_dir = isset($params['order_dir']) ? $params['order_dir'] : 'ASC';

        $query = $this->db->query("SELECT 
                    ak.foto AS foto_scan,
                    mk.nama AS nama_karyawan,
                    mk.nip AS nip_karyawan,
                    ak.flag_scan, ak.tanggal, ak.jam,
                    COUNT(1) OVER() AS total_record
                FROM absensi_karyawan ak 
                INNER JOIN ms_karyawan mk ON mk.nip = ak.nip
                INNER JOIN (
                    SELECT 
                        MAX(id) AS id_scan
                    FROM absensi_karyawan ak
                    WHERE ak.status = '1'
                        AND ak.tanggal = DATE(NOW())    
                    GROUP BY nip
                ) ls ON ls.id_scan = ak.id
                WHERE mk.status = '1'
                    AND (
                        mk.nama LIKE '%$search%'
                        OR mk.nip LIKE '%$search%'
                    )
                ORDER BY $col_name $order_dir
                LIMIT $start, $limit");

        return $query;
    }
}