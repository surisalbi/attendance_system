<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_history_model extends CI_Model
{
	protected $table = 'attendance_history';
	protected $where_id = 'id';

    public function all()
    {
        return $this->db->query("SELECT attendance_history.id AS ID_att, name, departement_name, date_attendance, DATE_FORMAT(clock_in, '%H:%i:%s') AS clock_in, DATE_FORMAT(clock_out, '%H:%i:%s') AS clock_out, description, max_clock_in_time, max_clock_out_time FROM attendance_history JOIN attendance ON attendance_history.attendance_id = attendance.attendance_id JOIN employee ON attendance_history.employee_id = employee.employee_id JOIN departement ON employee.departement_id = departement.id ORDER BY ID_att ASC")->result();
    }

    public function all_filter_date($from, $to)
    {
        return $this->db->query("SELECT attendance_history.id AS ID_att, name, departement_name, date_attendance, DATE_FORMAT(clock_in, '%H:%i:%s') AS clock_in, DATE_FORMAT(clock_out, '%H:%i:%s') AS clock_out, description, max_clock_in_time, max_clock_out_time FROM attendance_history JOIN attendance ON attendance_history.attendance_id = attendance.attendance_id JOIN employee ON attendance_history.employee_id = employee.employee_id JOIN departement ON employee.departement_id = departement.id WHERE cast(date_attendance as date) BETWEEN '$from' AND '$to' ORDER BY ID_att ASC")->result();
    }

    public function all_filter_departement($departement_id)
    {
        return $this->db->query("SELECT attendance_history.id AS ID_att, name, departement_name, date_attendance, DATE_FORMAT(clock_in, '%H:%i:%s') AS clock_in, DATE_FORMAT(clock_out, '%H:%i:%s') AS clock_out, description, max_clock_in_time, max_clock_out_time FROM attendance_history JOIN attendance ON attendance_history.attendance_id = attendance.attendance_id JOIN employee ON attendance_history.employee_id = employee.employee_id JOIN departement ON employee.departement_id = departement.id WHERE departement.id = $departement_id ORDER BY ID_att ASC")->result();
    }

    public function get_attendance_late_today() {
        $jumlah_telat = 0;
        $attendance_history = $this->db->query("SELECT attendance_history.id AS ID_att, name, departement_name, date_attendance, DATE_FORMAT(clock_in, '%H:%i:%s') AS clock_in, DATE_FORMAT(clock_out, '%H:%i:%s') AS clock_out, description, max_clock_in_time, max_clock_out_time FROM attendance_history JOIN attendance ON attendance_history.attendance_id = attendance.attendance_id JOIN employee ON attendance_history.employee_id = employee.employee_id JOIN departement ON employee.departement_id = departement.id WHERE DATE(attendance.created_at) = CURDATE();")->result();
	    foreach ($attendance_history as $row) {
	        $max_time  = strtotime($row->max_clock_in_time);
	        $post_time = strtotime($row->clock_in);

	        $diff = $post_time - $max_time;

	        if ($diff > 0) {
	            $jam   = floor($diff / 3600);
	            $menit = floor(($diff % 3600) / 60);

	            $jumlah_telat++;

	        } elseif ($diff == 0) {


	        } else {
	            $diff  = abs($diff);
	            $jam   = floor($diff / 3600);
	            $menit = floor(($diff % 3600) / 60);

	        }
	    }

	    return $jumlah_telat;
    }

    public function get_attendance_ontime_today() {
        $jumlah_cepat = 0;
        $attendance_history = $this->db->query("SELECT attendance_history.id AS ID_att, name, departement_name, date_attendance, DATE_FORMAT(clock_in, '%H:%i:%s') AS clock_in, DATE_FORMAT(clock_out, '%H:%i:%s') AS clock_out, description, max_clock_in_time, max_clock_out_time FROM attendance_history JOIN attendance ON attendance_history.attendance_id = attendance.attendance_id JOIN employee ON attendance_history.employee_id = employee.employee_id JOIN departement ON employee.departement_id = departement.id WHERE DATE(attendance.created_at) = CURDATE();")->result();
	    foreach ($attendance_history as $row) {
	        $max_time  = strtotime($row->max_clock_in_time);
	        $post_time = strtotime($row->clock_in);

	        $diff = $post_time - $max_time;

		    if ($diff > 0) {
		        // Telat
		    } elseif ($diff == 0) {
		        // Tepat waktu
		    } else {
		        // Datang lebih cepat
		        $jumlah_cepat++;
		    }
	    }

	    return $jumlah_cepat;
    }

    public function insert($request)
    {
        $this->db->insert($this->table, $request);
    }

    public function update($request, $id)
    {
        $this->db->where($this->where_id, $id);
        $this->db->update($this->table, $request);
    }

    public function delete($id)
    {
        $this->db->where($this->where_id, $id);
        $this->db->delete($this->table);
    }

    public function delete_all()
    {
        $this->db->query("DELETE FROM {$this->table}");
    }
}
