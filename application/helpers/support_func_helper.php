<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('getNotification')) {
	function getNotification()
	{
		$CI = &get_instance();
		$CI->db->from('notif');
		$CI->db->where('id_user', $CI->session->userdata()['id_user']);
		$CI->db->limit('20');
		$CI->db->order_by('notif_time', 'desc');

		$query = $CI->db->get();
		return $query->result_array();
		// echo json_encode($CI->session->userdata());
	}
}

if (!function_exists('tanggal_indonesia')) {
	function tanggal_indonesia($tanggal)
	{
		if (empty($tanggal)) return '';
		$BULAN = [
			0, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
		];
		$t = explode('-', $tanggal);
		return "{$t[2]} {$BULAN[intval($t[1])]} {$t[0]}";
	}
}

if (!function_exists('bulan_indo')) {
	function bulan_indo(int $x)
	{

		$BULAN = [
			0, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
		];
		return $BULAN[$x];
	}
}
if (!function_exists('to_romawi')) {
	function to_romawi($integer)
	{
		// Convert the integer into an integer (just to make sure)
		$integer = intval($integer);
		$result = '';

		// Create a lookup array that contains all of the Roman numerals.
		$lookup = array(
			'M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1
		);

		foreach ($lookup as $roman => $value) {
			// Determine the number of matches
			$matches = intval($integer / $value);

			// Add the same number of characters to the string
			$result .= str_repeat($roman, $matches);

			// Set the integer to be the remainder of the integer and the value
			$integer = $integer % $value;
		}

		// The Roman numeral should be built, return it
		return $result;
	}
}
if (!function_exists('romawi_bulan')) {
	function romawi_bulan($bln)
	{
		// echo $bln;
		switch ($bln) {
			case 1:
				return "I";
				break;
			case 2:
				return "II";
				break;
			case 3:
				return "III";
				break;
			case 4:
				return "IV";
				break;
			case 5:
				return "V";
				break;
			case 6:
				return "VI";
				break;
			case 7:
				return "VII";
				break;
			case 8:
				return "VIII";
				break;
			case 9:
				return "IX";
				break;
			case 10:
				return "X";
				break;
			case 11:
				return "XI";
				break;
			case 12:
				return "XII";
				break;
		}
	}
}
if (!function_exists('statusCuti')) {

	function statusCuti($n, $d)
	{
		if ($n == 'acc_adm') {
			return "Disetujui admin <br>Catatan Admin : " . $d['catatan_adm'] . "";
		} else  if ($n == 'tol_adm') {
			return "Ditolak admin <br>Catatan Admin : " . $d['catatan_adm'] . "";
		} else  if ($n == 'rev_adm') {
			return "Revisi <br>Catatan Admin : " . $d['catatan_adm'] . "";
		}

		if ($n == 'acc_kepsek') {
			return "<span class='text-success'><i class='fa fa-check'></i>Selesai</span ><br>Disetujui admin <br>Catatan Admin : " . $d['catatan_adm'] . "<br>Disetujui Kepsek <br>Catatan Kepsek : " . $d['catatan_kepsek'] . "";
		} else  if ($n == 'tol_kepsek') {
			return "Disetujui admin <br>Catatan Admin : " . $d['catatan_adm'] . "<br>Ditolak Kepsek <br>Catatan Kepsek : " . $d['catatan_kepsek'] . "";
		} else  if ($n == 'rev_kepsek') {
			return "Disetujui admin <br>Catatan Admin : " . $d['catatan_adm'] . "<br>Revisi Kepsek <br>Catatan Kepsek : " . $d['catatan_kepsek'] . "";
		}

		return 'Sedang diajukan';
	}
}
if (!function_exists('convertDayInd')) {
	function convertDayInd($day)
	{

		switch ($day) {
			case 'Sunday':
				$hari = 'Minggu';
				break;
			case 'Monday':
				$hari = 'Senin';
				break;
			case 'Tuesday':
				$hari = 'Selasa';
				break;
			case 'Wednesday':
				$hari = 'Rabu';
				break;
			case 'Thursday':
				$hari = 'Kamis';
				break;
			case 'Friday':
				$hari = 'Jum\'at';
				break;
			case 'Saturday':
				$hari = 'Sabtu';
				break;
			default:
				$hari = '-';
				break;
		}
		return $hari;
	}
}




// ------------------------------------------------------------------------
/* End of file helper.php */
/* Location: ./system/helpers/Side_Menu_helper.php */