<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Setting_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_setting_absensi()
    {
        $query = $this->db->get('ms_scan_log');

        return $query->row_array();
    }
}