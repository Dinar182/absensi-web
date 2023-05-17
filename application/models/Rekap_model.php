<?php defined('BASEPATH') or exit('no direct scripts are allowed');

class Rekap_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dt_select_rekap_absensi($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 10;

        $search = isset($params['search']) ? $params['search'] : '';
        $search = $this->db->escape_str($search);

        $col_name = isset($params['col_name']) ? $params['col_name'] : 'mk.nip';
        $order_dir = isset($params['order_dir']) ? $params['order_dir'] : 'ASC';

        $start_date = isset($params['start_date']) ? $params['start_date'] : '';
        $end_date = isset($params['end_date']) ? $params['end_date'] : '';
        $total_weekend = weekend_count($start_date, $end_date);

        $query = $this->db->query("SELECT 
                    mk.nip,
                    mk.nama AS nama_kary,
                    IFNULL(hd.jumlah_hadir, 0) AS jumlah_hadir,
                    IFNULL(lt.jumlah_telat, 0) AS jumlah_telat,
                    CAST(DATEDIFF('$end_date', '$start_date') + 1 AS SIGNED) 
                        - CAST(IFNULL(hd.jumlah_hadir, 0) AS SIGNED) 
                        - IFNULL(ct.jumlah_cuti, 0) 
                        - $total_weekend 
                    AS jumlah_mangkir,
                    IFNULL(ij.jumlah_ijin, 0) AS jumlah_ijin,
                    IFNULL(ct.jumlah_cuti, 0) AS jumlah_cuti,
                    COUNT(1) OVER() AS total_record
                FROM ms_karyawan mk 
                LEFT JOIN (
                    SELECT ak.nip,
                        COUNT(1) AS jumlah_hadir
                    FROM absensi_karyawan ak 
                    INNER JOIN (
                        SELECT MIN(ak.id) AS id
                        FROM absensi_karyawan ak
                        WHERE ak.status = '1'
                            AND ak.flag_scan = '1'
                            AND ak.tanggal BETWEEN '$start_date' AND '$end_date'
                        GROUP BY ak.nip, ak.tanggal
                    ) ls ON ls.id = ak.id
                    INNER JOIN (
                        SELECT ak.*
                        FROM absensi_karyawan ak 
                        INNER JOIN (
                            SELECT MAX(ak.id) AS id
                            FROM absensi_karyawan ak
                            INNER JOIN ms_karyawan mk ON mk.nip = ak.nip
                            INNER JOIN ms_scan_log msl ON msl.id = mk.id_lokasi_kerja
                            LEFT JOIN (
                                SELECT ik.nip,
                                    ik.tanggal
                                FROM ijin_karyawan ik
                                WHERE ik.status = '1'
                                    AND ik.status_ijin = '1'
                                    AND ik.jenis_ijin = '1'
                                    AND ik.tanggal BETWEEN '$start_date' AND '$end_date'
                            ) ik ON ik.nip = ak.nip AND ik.tanggal = ak.tanggal
                            WHERE ak.status = '1'
                                AND ak.flag_scan = '2'
                                AND ak.tanggal BETWEEN '$start_date' AND '$end_date'
                                AND CASE 
                                        WHEN ik.tanggal IS NULL THEN ak.jam >= msl.jam_pulang
                                        ELSE 1 = 1
                                    END
                            GROUP BY ak.nip, ak.tanggal
                        ) ls ON ls.id = ak.id
                        WHERE ak.status = '1'
                            AND ak.flag_scan = '2'
                            AND ak.tanggal BETWEEN '$start_date' AND '$end_date'
                    ) pl ON pl.nip = ak.nip AND pl.tanggal = ak.tanggal
                    WHERE ak.status = '1'
                        AND ak.flag_scan = '1'
                        AND ak.tanggal BETWEEN '$start_date' AND '$end_date'
                    GROUP BY ak.nip
                ) hd ON hd.nip = mk.nip
                LEFT JOIN (
                    SELECT ak.nip,
                        COUNT(*) jumlah_telat
                    FROM absensi_karyawan ak
                    INNER JOIN (
                        SELECT MAX(ak.id) AS id
                        FROM absensi_karyawan ak
                        WHERE ak.status = '1'
                            AND ak.flag_scan = '1'
                            AND ak.status_absen = '2'
                            AND ak.tanggal BETWEEN '$start_date' AND '$end_date'
                        GROUP BY ak.nip, ak.tanggal
                    ) ls ON ls.id = ak.id
                    WHERE ak.status = '1'
                        AND ak.flag_scan = '1'
                        AND ak.status_absen = '2'
                        AND ak.tanggal BETWEEN '$start_date' AND '$end_date'
                    GROUP BY ak.nip
                ) lt ON lt.nip = mk.nip
                LEFT JOIN (
                    SELECT ik.nip,
                        COUNT(1) AS jumlah_ijin
                    FROM ijin_karyawan ik 
                    WHERE ik.status = '1'
                        AND ik.status_ijin = '2'
                        AND ik.tanggal BETWEEN '$start_date' AND '$end_date'
                    GROUP BY ik.nip
                ) ij ON ij.nip = mk.nip
                LEFT JOIN (
                    SELECT
                        ck.nip,
                        SUM(lc.lama_cuti) AS jumlah_cuti
                    FROM cuti_karyawan ck
                    INNER JOIN (
                        SELECT ck.id,
                            DATEDIFF(ck.tgl_selesai, ck.tgl_mulai) + 1 AS lama_cuti
                        FROM cuti_karyawan ck
                        WHERE ck.status = '1'
                            AND ck.status_cuti = '2'
                            AND (
                                ck.tgl_mulai BETWEEN '$start_date' AND '$end_date'
                                OR ck.tgl_selesai BETWEEN '$start_date' AND '$end_date'
                            )
                    ) lc ON lc.id = ck.id
                    GROUP BY ck.nip
                ) ct ON ct.nip = mk.nip
                WHERE mk.status = '1'
                    AND mk.is_admin = 0
                    AND (
                        mk.nip LIKE '%$search%'
                        OR mk.nama LIKE '%$search%'
                    )
                ORDER BY $col_name $order_dir
                LIMIT $start, $limit");

        return $query;
    }

    public function dt_select_rekap_scanlog($params = [])
    {
        $start = isset($params['start']) ? $params['start'] : 0;
        $limit = isset($params['limit']) ? $params['limit'] : 10;

        $search = isset($params['search']) ? $params['search'] : '';
        $search = $this->db->escape_str($search);

        $col_name = isset($params['col_name']) ? $params['col_name'] : 'mk.nip';
        $order_dir = isset($params['order_dir']) ? $params['order_dir'] : 'ASC';

        $start_date = isset($params['start_date']) ? $params['start_date'] : '';
        $end_date = isset($params['end_date']) ? $params['end_date'] : '';

        if (!empty($start_date) 
        && !empty($end_date)) {
            $where_daterange = " AND ak.tanggal BETWEEN '$start_date' AND '$end_date'";

        } else if (!empty($start_date)) {
            $where_daterange = " AND ak.tanggal >= '$start_date'";
            
        } else if(!empty($end_date)) {
            $where_daterange = " AND ak.tanggal <= '$end_date'";

        } else {
            $where_daterange = " AND ak.tanggal = DATE(NOW())";
        }

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
                        CASE 
                            WHEN ak.flag_scan = 1 THEN MIN(id)
                            ELSE MAX(id)
                        END AS id_scan
                    FROM absensi_karyawan ak
                    WHERE ak.status = '1'
                        $where_daterange
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

    public function query_log()
    {
        # log Rekap Absensi
		// if ($bulan < date('m')) {
        //     $date = date('Y-m-d', strtotime(date('Y').'-'.$bulan.'-01'));
			
		// } elseif ($bulan == date('m')) {

		// 	$date = date('Y-m-d');
		// } else {

		// 	$date = 0;
		// }

        // CASE 
        // WHEN '$bulan' = DATE_FORMAT(NOW() , '%m')
        //     THEN (CAST((DATE_FORMAT('$date', '%d')) AS SIGNED) - CAST(IFNULL(hd.jumlah_hadir, 0) AS SIGNED)) - IFNULL(ct.jumlah_cuti, 0) - $total_weekend
        // WHEN '$bulan' < DATE_FORMAT(NOW() , '%m')
        //     THEN (CAST(DAY(LAST_DAY(DATE_FORMAT('$date' , '%Y-%$bulan-%d'))) AS SIGNED) - CAST(IFNULL(hd.jumlah_hadir, 0) AS SIGNED)) - IFNULL(ct.jumlah_cuti, 0) - $total_weekend
        // ELSE 0
        // END AS jumlah_mangkir,
    }
}