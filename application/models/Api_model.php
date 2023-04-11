<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Api_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function check_user($username = '', $password = '')
    {
        $query = $this->db->query("SELECT
                mk.nip, mk.nama, 
                mk.foto_profile AS profile,
                md.divisi, mj.jabatan,
                mk.email, mk.phone AS no_telp,
                mk.nik, mk.tgl_lahir,
                mk.jenis_kelamin, ma.agama,
                mk.alamat, mk.status_kawin AS status_pernikahan
            FROM ms_karyawan mk
            INNER JOIN ms_agama ma ON ma.id = mk.id_agama
            INNER JOIN ms_divisi md ON md.id = mk.id_divisi
            INNER JOIN ms_jabatan mj ON mj.id = mk.id_jabatan
            WHERE mk.username = '$username'
                AND AES_DECRYPT(mk.password, mk.nip) = '$password'");

        return $query->row_array();
    }

    public function get_detail_karyawan($nip = '')
    {
        $query = $this->db->query("SELECT
                mk.nip, mk.nama, 
                mk.foto_profile AS profile,
                md.divisi, mj.jabatan,
                mk.email, mk.phone AS no_telp,
                mk.nik, mk.tgl_lahir,
                mk.jenis_kelamin, ma.agama,
                mk.alamat, mk.status_kawin AS status_pernikahan
            FROM ms_karyawan mk
            INNER JOIN ms_agama ma ON ma.id = mk.id_agama
            INNER JOIN ms_divisi md ON md.id = mk.id_divisi
            INNER JOIN ms_jabatan mj ON mj.id = mk.id_jabatan
            WHERE mk.nip = '$nip'");

        return $query->row_array();
    }

    public function get_karyawan_by_nip($nip = '')
    {
        $query = $this->db->query("SELECT
                mk.nip, mk.nama, mk.username,
                AES_DECRYPT(mk.password, nip) AS password,
                mk.foto_profile AS profile,
                md.divisi, mj.jabatan,
                mk.email, mk.phone AS no_telp,
                mk.nik, mk.tgl_lahir,
                mk.jenis_kelamin, ma.agama,
                mk.alamat, mk.status_kawin AS status_pernikahan
            FROM ms_karyawan mk
            INNER JOIN ms_agama ma ON ma.id = mk.id_agama
            INNER JOIN ms_divisi md ON md.id = mk.id_divisi
            INNER JOIN ms_jabatan mj ON mj.id = mk.id_jabatan
            WHERE mk.nip = '$nip'");

        return $query->row_array();
    }

    public function update_password($params = [])
    {
        $nip = isset($params['nip']) ? $params['nip'] : '';
        $password_baru = isset($params['password_baru']) ? $params['password_baru'] : '';

        $this->db->trans_begin();

        $query = "UPDATE ms_karyawan SET password = AES_ENCRYPT('$password_baru', nip) WHERE nip = '$nip'";
        $this->db->query($query);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            return '0';
        } else {
            $this->db->trans_commit();

            return '1';
        }
    }

    public function submit_cuti_karyawan($params = [])
    {
        $nip = isset($params['nip']) ? $params['nip'] : '';
        $tanggal_mulai = isset($params['tanggal_mulai']) ? $params['tanggal_mulai'] : '';
        $tanggal_selesai = isset($params['tanggal_selesai']) ? $params['tanggal_selesai'] : '';
        $keterangan = isset($params['keterangan']) ? $params['keterangan'] : '';

        $this->db->trans_begin();

        $data_cuti = [
            'nip' => $nip,
            'tgl_mulai' => $tanggal_mulai,
            'tgl_selesai' => $tanggal_selesai,
            'keterangan' => $keterangan
        ];

        $this->db->insert('cuti_karyawan', $data_cuti);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            return '0';
        } else {
            $this->db->trans_commit();

            return '1';
        }
    }

    public function submit_ijin_karyawan($params = [])
    {
        $nip = isset($params['nip']) ? $params['nip'] : '';
        $jenis_ijin = isset($params['jenis_ijin']) ? $params['jenis_ijin'] : '';
        $tanggal = isset($params['tanggal']) ? $params['tanggal'] : '';
        $jam = isset($params['jam']) ? $params['jam'] : '';
        $keterangan = isset($params['keterangan']) ? $params['keterangan'] : '';

        $this->db->trans_begin();

        $data_ijin = [
            'nip' => $nip,
            'jenis_ijin' => $jenis_ijin,
            'tanggal' => $tanggal,
            'jam' => $jam,
            'keterangan' => $keterangan
        ];

        $this->db->insert('ijin_karyawan', $data_ijin);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            return '0';
        } else {
            $this->db->trans_commit();

            return '1';
        }
    }

    public function scan_log($params = [])
    {
		$this->load->library('upload');
        $foto = '';

        $nip = isset($params['nip']) ? $params['nip'] : '';
        $tanggal = isset($params['tanggal']) ? $params['tanggal'] : '';
        $jam = isset($params['jam']) ? $params['jam'] : '';
        $flag_scan = isset($params['flag_scan']) ? $params['flag_scan'] : '';
        $current_latitude = isset($params['latitude']) ? $params['latitude'] : '';
        $current_longtitude = isset($params['longtitude']) ? $params['longtitude'] : '';

        $rule_scan = $this->db->get('ms_scan_log')->row_array();
        $latitude = $rule_scan['latitude'];
        $longtitude = $rule_scan['longtitude'];
        $status_absen = '1';

        $get_radius = radius_calculate($latitude, $longtitude, $current_latitude, $current_longtitude);
        
        if ($get_radius > $rule_scan['radius']) {

            return '2';
        }

		$config_upload['allowed_types'] = 'jpg|jpeg|png';
		$config_upload['max_size'] = 10000;
		$config_upload['file_ext_tolower'] = true;

        if ($_FILES['foto']['size'] > 0) {
            $config_upload['upload_path'] = './assets/upload/scanlog';
            $config_upload['file_name'] = time() . '_' . str_random(5);

            $this->upload->initialize($config_upload);

            if ($this->upload->do_upload('foto')) {
                $uploaded_file_fb = $this->upload->data();

                $foto = $uploaded_file_fb['file_name'];
            }
        }

        $this->db->trans_begin();

        if ($flag_scan == '1') {
            if (strtotime($jam) > strtotime($rule_scan['jam_masuk'])) {
                # jika jam scan lebih dari jam masuk
                # maka status absen telat
                $status_absen = '2';
            } else {

                $status_absen = '1';
            }
        }

        $data_scan = [
            'nip' => $nip,
            'tanggal' => $tanggal,
            'jam' => $jam,
            'flag_scan' => $flag_scan,
            'status_absen' => $status_absen,
            'foto' => $foto
        ];

        $this->db->insert('absensi_karyawan', $data_scan);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            return '0';
        } else {
            $this->db->trans_commit();

            return '1';
        }
    }

    public function rekap_absensi_karyawan($nip = '', $tanggal_mulai = '', $tanggal_sampai = '')
    {
        $query = $this->db->query("SELECT ak.nip,
                    cit.total_telat,
                    ci.jumlah_uncheckin AS tidak_absen_masuk,
                    co.jumlah_uncheckout AS tidak_absen_pulang
                FROM absensi_karyawan ak 
                LEFT JOIN (
                    SELECT ak.nip, COUNT(1) AS total_telat
                    FROM (
                        SELECT ak.nip, ak.tanggal
                        FROM absensi_karyawan ak
                        WHERE ak.status = '1'
                            AND ak.flag_scan = '1'	
                            AND ak.status_absen = '2'
                            AND ak.nip = '$nip'
                            AND ak.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                            AND NOT EXISTS (
                                SELECT * 
                                FROM absensi_karyawan 
                                WHERE nip = ak.nip
                                    AND tanggal = ak.tanggal
                                    AND flag_scan = '1'
                                    AND status_absen = '1'
                            )
                        GROUP BY ak.tanggal
                    ) ak
                ) cit ON cit.nip = ak.nip
                LEFT JOIN (
                    SELECT
                        ci.nip, 
                        COUNT(1) AS jumlah_uncheckin
                    FROM (
                        SELECT ak.nip,
                            COUNT(1) AS jumlah_uncheckin
                        FROM absensi_karyawan ak
                        LEFT JOIN (
                            SELECT nip,
                                tanggal, flag_scan,
                                jam AS jam_checkin
                            FROM absensi_karyawan ak
                            WHERE STATUS = '1'
                                AND flag_scan = '1'
                                AND nip = '$nip'
                                AND tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                            GROUP BY tanggal
                        ) ci ON ci.nip = ak.nip AND ci.tanggal = ak.tanggal
                        WHERE ak.status = '1'
                            AND ak.nip = '$nip'
                            AND ak.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                            AND ci.jam_checkin IS NULL
                        GROUP BY ak.nip
                    ) ci
                ) ci ON ci.nip = ak.nip
                LEFT JOIN (
                    SELECT ak.nip, 
                        COUNT(1) AS jumlah_uncheckout
                    FROM absensi_karyawan ak
                    LEFT JOIN (
                        SELECT nip,
                            tanggal, flag_scan,
                            jam AS jam_checkout
                        FROM absensi_karyawan ak
                        WHERE STATUS = '1'
                            AND flag_scan = '2'
                            AND nip = '$nip'
                            AND tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                        GROUP BY tanggal
                    ) co ON co.nip = ak.nip AND co.tanggal = ak.tanggal
                    WHERE ak.status = '1'
                        AND ak.nip = '$nip'
                        AND ak.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                        AND co.jam_checkout IS NULL
                    GROUP BY ak.nip
                ) co ON co.nip = ak.nip
                WHERE ak.status = '1'
                    AND ak.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                GROUP BY ak.nip");

        return $query->row_array();
    }

    public function detail_rekap_absensi($nip = '', $tanggal_mulai = '', $tanggal_sampai = '')
    {
        $query = $this->db->query("SELECT ak.nip, ak.tanggal,
                    IFNULL(ci.jam_checkin, '00:00:00') AS jam_masuk,
                    IFNULL(co.jam_checkout, '00:00:00') AS jam_pulang
                FROM absensi_karyawan ak
                LEFT JOIN (
                    SELECT nip,	
                        tanggal, flag_scan,
                        jam AS jam_checkin
                    FROM absensi_karyawan ak
                    WHERE STATUS = '1'
                        AND flag_scan = '1'
                        AND nip = '$nip'
                        AND tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                    GROUP BY tanggal
                ) ci ON ci.nip = ak.nip AND ci.tanggal = ak.tanggal
                LEFT JOIN (
                    SELECT nip,
                        tanggal, flag_scan,
                        jam AS jam_checkout
                    FROM absensi_karyawan ak
                    WHERE STATUS = '1'
                        AND flag_scan = '2'
                        AND nip = '$nip'
                        AND tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                    GROUP BY tanggal
                ) co ON co.nip = ak.nip AND co.tanggal = ak.tanggal
                WHERE ak.status = '1'
                    AND ak.nip = '$nip'
                    AND ak.tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_sampai'
                GROUP BY ak.tanggal");

        return $query->result_array();
    }

    public function rekap_dayli_absensi($nip = '', $tanggal = '')
    {
        $query = $this->db->query("SELECT 
                        tanggal, jam,
                        CASE
                            WHEN flag_scan = '1' THEN 'Check In'
                            ELSE 'Check Out'
                        END flag_scan	
                    FROM absensi_karyawan ak 
                    WHERE STATUS = '1'
                        AND nip = '$nip'
                        AND tanggal = '$tanggal'
                    ORDER BY jam ASC");

        return $query->result_array();
    }
}