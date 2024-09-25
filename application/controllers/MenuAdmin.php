<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuAdmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->model('MenuAdmin_model');
        check_login();
    }
    public function pasien()
    {

        $data['judul'] = 'Pasien';
        $data['user'] = $this->MenuAdmin_model->getDokterByNo();
        $data['total_pasien'] = $this->MenuAdmin_model->total_pasien();
        $config['base_url'] = base_url('menu/pasien');
        $config['total_rows'] = $data['total_pasien'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pasien'] = $this->MenuAdmin_model->get_pasien($config['per_page'], $page);
        $data['pasien_active'] = $this->MenuAdmin_model->get_pasien_active();
        $data['ruang'] = $this->MenuAdmin_model->get_ruang();
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/pasien', $data);
        $this->load->view('templates/footer');
    }

    public function add()
    {

        $this->MenuAdmin_model->addPasien();
        $this->session->set_flashdata('pasienflash', 'Pasien berhasil ditambahkan');
        redirect('menuadmin/pasien');

    }
    public function getPasienInap(){
        // var_dump($this->MenuAdmin_model->getPasienById());
        echo json_encode($this->MenuAdmin_model->getPasienById($this->input->post('id_pasien')));
   }
    public function edit()
    {
        $this->MenuAdmin_model->editRuangPasien();
    }
    public function keluar($no_medis)
    {
        $this->MenuAdmin_model->keluar($no_medis);
        $this->session->set_flashdata('pasienflash', 'Pasien telah keluar rawat inap');
        redirect('menuadmin/pasien');
    }


}
