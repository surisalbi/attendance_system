<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->model('Departement_model');
    }

    public function index() {
        $data["title"] = "Data Karyawan - Attendance System";
        $data["employee"] = $this->Employee_model->all();
        $data["employee_id"] = $this->Employee_model->generate_employee_id();
        $data["departement_list"] = $this->Departement_model->all();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('employee', $data);
        $this->load->view('layout/footer');
    }

    public function create()
    {
        $employee_id = $this->Employee_model->generate_employee_id();
        $departement_id = $this->input->post('departement_id', TRUE);
        $name = $this->input->post('name', TRUE);
        $address = $this->input->post('address', TRUE);

        $request = [
            'employee_id' => $employee_id,
            'departement_id' => $departement_id,
            'name' => $name,
            'address' => $address
        ];

        $this->Employee_model->insert($request);

        $this->session->set_flashdata('alert', '
            <div class="max-w-md mt-3">
              <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-300" role="alert">
                <!-- Icon -->
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">Data berhasil ditambahkan!</span>
              </div>
            </div>
        ');
        redirect('employee');
    }

    public function update($id)
    {
        $departement_id = $this->input->post('departement_id', TRUE);
        $name = $this->input->post('name', TRUE);
        $address = $this->input->post('address', TRUE);

        $request = [
            'departement_id' => $departement_id,
            'name' => $name,
            'address' => $address
        ];

        $this->Employee_model->update($request, $id);

        $this->session->set_flashdata('alert', '
            <div class="max-w-md mt-3">
              <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-300" role="alert">
                <!-- Icon -->
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">Data berhasil diperbarui!</span>
              </div>
            </div>
        ');
        redirect('employee');
    }

    public function delete($id)
    {
        $this->Employee_model->delete($id);

        $this->session->set_flashdata('alert', '
            <div class="max-w-md mt-3">
              <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-300" role="alert">
                <!-- Icon -->
                <svg class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">Data berhasil dihapus!</span>
              </div>
            </div>
        ');
        redirect('employee');
    }

    
}
