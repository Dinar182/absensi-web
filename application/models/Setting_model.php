<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Setting_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_setting_absensi($id_lokasi = 0)
    {
        $query = $this->db->where('id', $id_lokasi)->get('ms_scan_log');

        return $query->row_array();
    }

    public function dt_select_lokasi_kerja($params = [])
    {
		$start = isset($params['start']) ? $params['start'] : 0;
		$limit = isset($params['limit']) ? $params['limit'] : 10;

        $search = isset($params['search']) ? $params['search'] : '';
        $search = $this->db->escape_str($search);

        $col_name = isset($params['col_name']) ? $params['col_name'] : 'id';
		$order_dir = isset($params['order_dir']) ? $params['order_dir'] : 'asc';

        $query = $this->db->query("SELECT *,
                        COUNT(1) OVER() AS total_record
                    FROM ms_scan_log mcl
                    WHERE status = '1'
                        AND (
                            lokasi LIKE '%$search%'
                            OR latitude LIKE '%$search%'
                        )
                    ORDER BY $col_name $order_dir
                    LIMIT $start, $limit");

        return $query;
    }
}