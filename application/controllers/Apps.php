<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apps extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->model('Departement_model');
        $this->load->model('Attendance_history_model');
    }

    public function index() {
        $data["title"] = "Selamat Datang - Attendance System";
        $data["count_employee"] = $this->Employee_model->count_all();
        $data["count_departement"] = $this->Departement_model->count_all();
        $data["count_late_today"] = $this->Attendance_history_model->get_attendance_late_today();
        $data["count_ontime_today"] = $this->Attendance_history_model->get_attendance_ontime_today();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('apps', $data);
        $this->load->view('layout/footer');
    }

    
}
