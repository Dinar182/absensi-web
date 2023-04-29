<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function check_login()
    {
        if ($this->session->is_login !== true) {
            $this->session->sess_destroy();

            return redirect('/auth/login');
        }

        return true;
    }

    public function check_user($username = '', $password = '')
    {
        $query = $this->db->query("SELECT * 
            FROM ms_karyawan 
            WHERE username = '$username' 
                AND AES_DECRYPT(password, nip) = '$password' 
                AND is_admin = '1'");

        return $query->row_array();
    }
}