<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pasien extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pasien_model');
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
        check_login();
    }
    public function error_404()
    {
        $this->output->set_status_header('404');
        $data['judul'] = '404 Page Not Found';
        $this->load->view('templates/header', $data);
        $this->load->view('user/404');
        $this->load->view('templates/footer');
    }


    public function index()
    {
        $data['user'] = $this->Pasien_model->getUser();
        $data['judul'] = 'My Profile';
        $this->load->view('templates/header', $data);

        $this->load->view('templates/topbar_pasien', $data);
        $this->load->view('pasien/index', $data);
        $this->load->view('templates/footer');
    }
    public function profil()
    {
        $data['user'] = $this->Pasien_model->getUser();
        $data['judul'] = 'My Profile';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar_pasien', $data);
        $this->load->view('pasien/profil', $data);
        $this->load->view('templates/footer');
    }
    public function edit()
    {
        $data['user'] = $this->Pasien_model->getUser();
        $this->form_validation->set_rules('nama', 'Full Name', 'required|trim', [
            'required' => 'Nama harus diisi!'
        ]);
        $this->form_validation->set_rules('no_telp', 'Phone Number', 'required|trim|max_length[13]|min_length[10]', [
            'required' => 'Nomor Telepon harus diisi!',
            'max_length' => 'Nomor Telepon maksimal 13 karakter!',
            'min_length' => 'Nomor Telepon minimal 10 karakter!'

        ]);
        $this->form_validation->set_rules('alamat', 'Address', 'required|trim', [
            'required' => 'Alamat harus diisi!'
        ]);
        if ($this->form_validation->run() == false) {
            // $data['judul'] = 'Edit Profile';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar_pasien', $data);
            $this->load->view('pasien/profil', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Pasien_model->editProfil();
        }
    }

    public function rawat_inap()
    {
        $data['user'] = $this->Pasien_model->getUser();
        $data['judul'] = 'Rawat Inap';
        $data['pasien'] = $this->Pasien_model->get_rawat_inap_by_no();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar_pasien', $data);
        $this->load->view('pasien/index', $data);
        $this->load->view('pasien/rawat_inap', $data);
        $this->load->view('templates/footer');
    }

    public function riwayat_kunjungan(){
        $data['user'] = $this->Pasien_model->getUser();
        $data['judul'] = 'Riwayat Kunjungan';
        $data['kunjungan'] = $this->Pasien_model->get_kunjungan_by_no();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar_pasien', $data);
        $this->load->view('pasien/index', $data);
        $this->load->view('pasien/riwayat_kunjungan', $data);
        $this->load->view('templates/footer');
    }
    public function tindakan_medis(){
        $data['user'] = $this->Pasien_model->getUser();
        $data['judul'] = 'Tindakan Medis';
        $data['tindakan_medis'] = $this->Pasien_model->get_tindakan_by_no();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar_pasien', $data);
        $this->load->view('pasien/index', $data);
        $this->load->view('pasien/tindakan_medis', $data);
        $this->load->view('templates/footer');
    }



}