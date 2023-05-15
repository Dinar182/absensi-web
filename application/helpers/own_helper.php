<?php defined('BASEPATH') or exit('no direct scripts are allowed');

if (!function_exists('admin_view')) {
	function admin_view($data_header, $content_template, $data_content = null)
	{
		$ci =& get_instance();
		$ci->load->view('template/header', $data_header);
		$ci->load->view($content_template, $data_content);
		$ci->load->view('template/footer');
	}
}

if(!function_exists('pre'))
{
	function pre($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";

		exit;
	}
}

if(!function_exists('radius_calculate'))
{
	function radius_calculate($latitude, $longtitude, $current_latitude, $current_longtitude){
        $earth_radius = 6371000; # Earth's radius in meters
        $dLat = deg2rad($current_latitude - $latitude);
        $dLon = deg2rad($current_longtitude - $longtitude);
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude)) * cos(deg2rad($current_latitude)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $distance = $earth_radius * $c;
        return round($distance);
	}
}

if (!function_exists('str_random')) {
	function str_random($length = null)
	{
		if($length == false) {
			throw new Exception("Missing argument in line ".debug_backtrace()[0]["line"], true);
		} else {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}
	}
}

if (!function_exists('weekend_countOLD')) {
	function weekend_countOLD($month = '')
	{
		$weekend_count = 0;
		$month_filtered = ($month == '') ? date('m') : $month;
		if ($month < date('m')) {
			$day = date('t', strtotime(date('Y').'-'.$month.'-t'));
			
		} elseif ($month == date('m')) {

			$day = date('j');
		} else {

			$day = 0;
		}
		
		for ($i = 1; $i <= $day; $i++) {
			$date = date('Y-'.$month_filtered.'-'.$i);
			$day_of_week = date('N', strtotime($date));
		
			if ($day_of_week > 6) {
				$weekend_count++;
			}
		}
		
		return $weekend_count;
	}
}

if (!function_exists('weekend_count')) {
	function weekend_count($start_date = '', $end_date = '')
	{
		$start = new DateTime($start_date);
		$end = new DateTime($end_date);
	
		// Adjust the end date by one day so that it is inclusive
		$end->modify('+1 day');
	
		$interval = new DateInterval('P1D'); // 1 day interval
		$period = new DatePeriod($start, $interval, $end);
	
		$count = 0;
		foreach ($period as $date) {
			if ($date->format('N') > 6) { // Saturday or Sunday (6 or 7)
				$count++;
			}
		}
	
		return $count;
	}
}