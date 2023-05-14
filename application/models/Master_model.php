<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Master_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_agama($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $search = isset($params['search']) ? $params['search'] : '';

        $search = $this->db->escape_str($search);

        $query = $this->db->query("SELECT
                    id AS id,
                    agama AS text,
                    COUNT(1) OVER() AS total_record
                FROM ms_agama ma
                WHERE ma.status = '1'
                    AND ma.agama LIKE '%$search%'
                LIMIT $start, $limit");

        return $query;
    }

    public function select_divisi($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $search = isset($params['search']) ? $params['search'] : '';

        $search = $this->db->escape_str($search);

        $query = $this->db->query("SELECT
                    id AS id,
                    divisi AS text,
                    COUNT(1) OVER() AS total_record
                FROM ms_divisi ma
                WHERE ma.status = '1'
                    AND ma.divisi LIKE '%$search%'
                LIMIT $start, $limit");

        return $query;
    }

    public function select_jabatan($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $search = isset($params['search']) ? $params['search'] : '';

        $search = $this->db->escape_str($search);

        $query = $this->db->query("SELECT
                    id AS id,
                    jabatan AS text,
                    COUNT(1) OVER() AS total_record
                FROM ms_jabatan ma
                WHERE ma.status = '1'
                    AND ma.jabatan LIKE '%$search%'
                LIMIT $start, $limit");

        return $query;
    }

    public function generate_nipOLD()
    {
        $query = $this->db->query("SELECT nip FROM ms_karyawan ORDER BY id DESC LIMIT 1");
        $get_query = $query->row_array();

        $last_nip = $get_query['nip'];
        $explode_nip = explode('.', $last_nip);
        $counter = intval($explode_nip[1]);
        $counter += 1;

        switch (strlen($counter)) {
            case '1':
                $nip_karyawan = '000' . $counter;
                break;

            case '2':
                $nip_karyawan = '00' . $counter;
                break;

            case '3':
                $nip_karyawan = '0' . $counter;
                break;

            case '4':
                $nip_karyawan =  $counter;
                break;

        }

        return '03.'.$nip_karyawan.'.'. date('m') . date('y');
    }

    public function generate_nip()
    {
        $query = $this->db->query("SELECT nip FROM ms_karyawan ORDER BY id DESC LIMIT 1");
        $get_query = $query->row_array();

        $last_nip = $get_query['nip'];
        $counter = (int)substr($last_nip, 6, 4);
        $counter += 1;

        switch (strlen($counter)) {
            case '1':
                $nip_karyawan = '000' . $counter;
                break;

            case '2':
                $nip_karyawan = '00' . $counter;
                break;

            case '3':
                $nip_karyawan = '0' . $counter;
                break;

            case '4':
                $nip_karyawan =  $counter;
                break;

        }

        return date('ymd') . $nip_karyawan;
    }

    public function password_generate($nip_karyawan = '')
    {
        $explode_nip = explode('.', $nip_karyawan);
        $counter_nip = intval($explode_nip[1]);
        
        return 'bjlgroup'.$counter_nip;
    }

    public function select_lokasi_kerja($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $search = isset($params['search']) ? $params['search'] : '';

        $search = $this->db->escape_str($search);

        $query = $this->db->query("SELECT
                    id AS id,
                    lokasi AS text,
                    COUNT(1) OVER() AS total_record
                FROM ms_scan_log msl
                WHERE msl.status = '1'
                    AND msl.lokasi LIKE '%$search%'
                LIMIT $start, $limit");

        return $query;
    }
}