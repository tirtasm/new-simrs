<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuAdmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('MenuAdmin_model');
        check_login();
    }
    public function pasien()
    {

        $data['judul'] = 'Pasien';
        $data['user'] = $this->MenuAdmin_model->getDokterByNo();
        $data['total_pasien'] = $this->MenuAdmin_model->total_pasien();
        $this->load->library('pagination');
        $config['base_url'] = base_url('menu/pasien');
        $config['total_rows'] = $data['total_pasien'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pasien'] = $this->MenuAdmin_model->get_pasien($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/pasien', $data);
        $this->load->view('templates/footer');
    }

    public function keluar($no_medis)
    {
        $this->MenuAdmin_model->keluar($no_medis);
        $this->session->set_flashdata('pasienflash', 'Pasien telah keluar rawat inap');
        redirect('menuadmin/pasien');
    }


}
