<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->model('Departement_model');
        $this->load->model('Attendance_model');
        $this->load->model('Attendance_history_model');
    }

    public function index() {
        $data["title"] = "Data Absensi Karyawan - Attendance System";
        $data["employee"] = $this->Employee_model->all();
        $data["attendance_history"] = $this->Attendance_history_model->all();
        $data["departement_list"] = $this->Departement_model->all();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('attendance', $data);
        $this->load->view('layout/footer');
    }

    public function create()
    {
        date_default_timezone_set('Asia/Jakarta');
        $attendance_id = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        $employee_id = $this->input->post('employee_id', TRUE);
        $clock_in = date("Y-m-d")." ".$this->input->post('clock_in', TRUE);;

        $request_attendance = [
            'employee_id' => $employee_id,
            'attendance_id' => $attendance_id,
            'clock_in' => $clock_in
        ];

        $get_dept_emply = $this->db->query("SELECT max_clock_in_time, max_clock_out_time FROM employee JOIN departement ON employee.departement_id = departement.id WHERE employee_id = '$employee_id'")->row();
        $max_clock_in_time = $get_dept_emply->max_clock_in_time; // "08:30:00";
        $post_clock_in = date("H:i:s");

        $max_time  = strtotime($max_clock_in_time);
        $post_time = strtotime($post_clock_in);

        $diff = $post_time - $max_time;

        if ($diff > 0) {
            $jam   = floor($diff / 3600);
            $menit = floor(($diff % 3600) / 60);
            $description = "Anda telat $jam jam $menit menit";
        } elseif ($diff == 0) {
            $description = "Anda tepat waktu";
        } else {
            $diff = abs($diff);
            $jam   = floor($diff / 3600);
            $menit = floor(($diff % 3600) / 60);
            $description = "Anda datang lebih cepat $jam jam $menit menit";
        }

        $request_attendance_history = [
            'employee_id' => $employee_id,
            'attendance_id' => $attendance_id,
            'date_attendance' => $clock_in,
            'attendance_type' => 1,
            'description' => null
        ];

        $this->Attendance_model->insert($request_attendance);
        $this->Attendance_history_model->insert($request_attendance_history);

        $this->session->set_flashdata('alert', '
                <div class="max-w-md mt-3">
                  <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-300" role="alert">
                    <!-- Icon -->
                    <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">Absen masuk berhasil ditambahkan!</span>
                  </div>
                </div>
            ');
        redirect('attendance');
    }

    public function update($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $clock_out = date("Y-m-d")." ".$this->input->post('clock_out', TRUE);;

        $request = [
            'clock_out' => $clock_out
        ];

        $this->Attendance_model->update($request, $id);

        $this->session->set_flashdata('alert', '
            <div class="max-w-md mt-3">
              <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-300" role="alert">
                <!-- Icon -->
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">Absen keluar berhasil!</span>
              </div>
            </div>
        ');
        redirect('attendance');
    }

    public function filter_date()
    {
        $from = $this->input->get('from', TRUE);
        $to = $this->input->get('to', TRUE);

        $data["title"] = "Data Absensi Karyawan - Attendance System";
        $data["employee"] = $this->Employee_model->all();
        $data["departement_list"] = $this->Departement_model->all();
        $data["attendance_history"] = $this->Attendance_history_model->all_filter_date($from, $to);
        $data["from"] = $from;
        $data["to"] = $to;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('attendance', $data);
        $this->load->view('layout/footer');
    }

    public function filter_departement()
    {
        $departement_id = $this->input->get('departement_id', TRUE);

        $data["title"] = "Data Absensi Karyawan - Attendance System";
        $data["employee"] = $this->Employee_model->all();
        $data["departement_list"] = $this->Departement_model->all();
        $data["departement"] = $this->Departement_model->get_where($departement_id);
        $data["attendance_history"] = $this->Attendance_history_model->all_filter_departement($departement_id);
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('attendance', $data);
        $this->load->view('layout/footer');
    }

    public function delete_all()
    {
        $this->Attendance_model->delete_all();
        $this->Attendance_history_model->delete_all();

        $this->session->set_flashdata('alert', '
            <div class="max-w-md mt-3">
              <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-300" role="alert">
                <!-- Icon -->
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">Data berhasil di reset!</span>
              </div>
            </div>
        ');
        redirect('attendance');
    }

    
}
