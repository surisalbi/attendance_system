<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departement extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Departement_model');
    }

    public function index() {
        $data["title"] = "Data Departemen - Attendance System";
        $data["departement"] = $this->Departement_model->all();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar');
        $this->load->view('departement', $data);
        $this->load->view('layout/footer');
    }

    public function create()
    {
        $departement_name = $this->input->post('departement_name', TRUE);
        $max_clock_in_time = $this->input->post('max_clock_in_time', TRUE);
        $max_clock_out_time = $this->input->post('max_clock_out_time', TRUE);

        $request = [
            'departement_name' => $departement_name,
            'max_clock_in_time' => $max_clock_in_time,
            'max_clock_out_time' => $max_clock_out_time
        ];

        $this->Departement_model->insert($request);

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
        redirect('departement');
    }

    public function update($id)
    {
        $departement_name = $this->input->post('departement_name', TRUE);
        $max_clock_in_time = $this->input->post('max_clock_in_time', TRUE);
        $max_clock_out_time = $this->input->post('max_clock_out_time', TRUE);

        $request = [
            'departement_name' => $departement_name,
            'max_clock_in_time' => $max_clock_in_time,
            'max_clock_out_time' => $max_clock_out_time
        ];

        $this->Departement_model->update($request, $id);

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
        redirect('departement');
    }

    public function delete($id)
    {
        $this->Departement_model->delete($id);

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
        redirect('departement');
    }

    
}
