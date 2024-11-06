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
    //pasien
    public function pasien()
    {

        $data['judul'] = 'Pasien';
        $data['user'] = $this->MenuAdmin_model->getDokterByNo();
        $data['total_pasien'] = $this->MenuAdmin_model->total_pasien();
        $config['base_url'] = base_url('menuadmin/pasien');
        $config['total_rows'] = $data['total_pasien'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $search = $this->input->post('search', true);
        $data['search'] = $search;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pasien'] = $this->MenuAdmin_model->get_pasien($config['per_page'], $page, $search);
        $data['pasien_not_inap'] = $this->MenuAdmin_model->pasien_not_inap();

        $data['ruang'] = $this->MenuAdmin_model->get_ruang();
        $data['ruang_igd'] = $this->MenuAdmin_model->get_ruang_igd();
        $data['jenis_pelayanan'] = $this->MenuAdmin_model->get_jenis_pelayanan();
        // $data['ruang_selected'] = $this->MenuAdmin_model->get_ruang_id();
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/pasien', $data);
        $this->load->view('templates/footer');
    }

    //add pasien
    public function add()
    {
        $this->form_validation->set_rules('no_telp', 'no', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errorflash', 'Pasien gagal ditambahkan');
            redirect('menuadmin/pasien');
        } else {
            $this->MenuAdmin_model->addPasien();
            
            $this->session->set_flashdata('pasienflash', 'Pasien berhasil ditambahkan');
            redirect('menuadmin/pasien');
        }

    }
    public function edit()
    {
        $this->form_validation->set_rules('no_telp', 'no', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errorflash', 'Pasien gagal diedit');
            redirect('menuadmin/pasien');
        } else {
            $this->MenuAdmin_model->editRuangPasien();
            $this->session->set_flashdata('pasienflash', 'Pasien berhasil diedit');
            redirect('menuadmin/pasien');
        }
    }
    public function keluar($no_medis)
    {
        $this->MenuAdmin_model->keluar($no_medis);
        $this->session->set_flashdata('pasienflash', 'Pasien telah keluar ruangan');
        redirect('menuadmin/pasien');
    }
    public function getPasienInap()
    {

        echo json_encode($this->MenuAdmin_model->getPasienById($this->input->post('id_pasien')));
        // echo json_encode($this->MenuAdmin_model->getPasienById($id));
    }
    public function getEditRuang(){
        echo json_encode($this->MenuAdmin_model->getRuangById($this->input->post('id_ruang')));
    }
    public function getEditRuangIGD(){
        echo json_encode($this->MenuAdmin_model->getRuangIGDById($this->input->post('id_ruang_igd')));
    }
    public function getEditTindakan(){
        echo json_encode($this->MenuAdmin_model->getTindakanById($this->input->post('id_tindakan')));
    }
    //ruang
    public function ruang(){
        $data['judul'] = 'Ruang';
        $data['user'] = $this->MenuAdmin_model->getDokterByNo();
        $data['total_ruang'] = $this->MenuAdmin_model->total_ruang();
        $config['base_url'] = base_url('menuadmin/ruang');
        $config['total_rows'] = $data['total_ruang'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $search = $this->input->post('search', true);
        $data['search'] = $search;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['ruang'] = $this->MenuAdmin_model->get_ruang_all($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/ruang', $data);
        $this->load->view('templates/footer');
    }
    public function ruang_igd(){
        $data['judul'] = 'Ruang IGD';
        $data['user'] = $this->MenuAdmin_model->getDokterByNo();
        $data['total_ruang'] = $this->MenuAdmin_model->total_ruang_igd();
        $config['base_url'] = base_url('menuadmin/ruang_igd');
        $config['total_rows'] = $data['total_ruang'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $search = $this->input->post('search', true);
        $data['search'] = $search;
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['ruang_igd'] = $this->MenuAdmin_model->get_ruang_idg_all($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/ruang-igd', $data);
        $this->load->view('templates/footer');
    }
    public function add_ruang(){
        $this->form_validation->set_rules('nama_ruang', 'required|is_unique[ruang.nama_ruang]');
        $this->form_validation->set_rules('kapasitas', 'kapasitas', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errorflash', 'Nama ruang sudah ada');
            redirect('menuadmin/ruang');
        } else {
            $this->MenuAdmin_model->add_ruang();
            $this->session->set_flashdata('ruangflash', 'Ruang berhasil ditambahkan');
            redirect('menuadmin/ruang');
        }
    }
    public function delete_ruang(){
        $id = $this->uri->segment(3);
        $this->MenuAdmin_model->hapus_ruang($id);
        $this->session->set_flashdata('ruangflash', 'Ruang berhasil dihapus');
        redirect('menuadmin/ruang');
    }

    public function update_ruang(){
        $this->form_validation->set_rules('nama_ruang', 'required|is_unique[ruang.nama_ruang]');
        $this->form_validation->set_rules('kapasitas', 'kapasitas', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errorflash', 'Nama ruang sudah ada');
            redirect('menuadmin/ruang');
        }else{
            $this->MenuAdmin_model->edit_ruang();
            $this->session->set_flashdata('ruangflash', 'Ruang berhasil diubah');
            redirect('menuadmin/ruang');
        }
    }
    public function add_ruang_igd(){
        $this->form_validation->set_rules('nama_ruang_igd', 'required|is_unique[ruang.nama_ruang_igd]');
        $this->form_validation->set_rules('kapasitas', 'kapasitas', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errorflash', 'Nama ruang sudah ada');
            redirect('menuadmin/ruang-igd');
        } else {
            $this->MenuAdmin_model->add_ruang_igd();
            $this->session->set_flashdata('ruangflash', 'Ruang berhasil ditambahkan');
            redirect('menuadmin/ruang_igd');
        }
    }
    public function delete_ruang_igd(){
        $id = $this->uri->segment(3);
        $this->MenuAdmin_model->hapus_ruang_igd($id);
        $this->session->set_flashdata('ruangflash', 'Ruang berhasil dihapus');
        redirect('menuadmin/ruang_igd');
    }

    public function update_ruang_igd(){
        $this->form_validation->set_rules('nama_ruang_igd', 'required|is_unique[ruang_igd.nama_ruang_igd]');
        $this->form_validation->set_rules('kapasitas', 'kapasitas', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errorflash', 'Nama ruang sudah ada');
            redirect('menuadmin/ruang_igd');
        }else{
            $this->MenuAdmin_model->edit_ruang_igd();
            $this->session->set_flashdata('ruangflash', 'Ruang berhasil diubah');
            redirect('menuadmin/ruang_igd');
        }
    }

    //tindakan
    public function tindakan(){
        $data['judul'] = 'Tindakan';
        $data['user'] = $this->MenuAdmin_model->getDokterByNo();
        $data['total_tindakan'] = $this->MenuAdmin_model->total_tindakan();
        $config['base_url'] = base_url('menuadmin/tindakan');
        $config['total_rows'] = $data['total_tindakan'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $search = $this->input->post('search', true);
        $data['search'] = $search;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['tindakan'] = $this->MenuAdmin_model->get_tindakan_all($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/tindakan', $data);
        $this->load->view('templates/footer');  
    }
    public function addtindakan(){
        $this->form_validation->set_rules('nama_tindakan', 'required|is_unique[tindakan.nama_tindakan]');
        $this->form_validation->set_rules('biaya', 'biaya', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errorflash', 'Nama tindakan sudah ada');
            redirect('menuadmin/tindakan');
        } else {
            $this->MenuAdmin_model->addTindakan();
            $this->session->set_flashdata('tindakanflash', 'Tindakan berhasil ditambahkan');
            redirect('menuadmin/tindakan');
        }
    }
    public function updateTindakan(){
        $this->form_validation->set_rules('nama_tindakan', 'required|is_unique[tindakan.nama_tindakan]');
        $this->form_validation->set_rules('biaya', 'biaya', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errorflash', 'Nama tindakan sudah ada');
            redirect('menuadmin/tindakan');
        }else{
            $this->MenuAdmin_model->editTindakan();
            $this->session->set_flashdata('tindakanflash', 'Tindakan berhasil diubah');
            redirect('menuadmin/tindakan');
        }
    }
    public function deleteTindakan(){
        $id = $this->uri->segment(3);
        $this->MenuAdmin_model->hapusTindakan($id);
        $this->session->set_flashdata('tindakanflash', 'Tindakan berhasil dihapus');
        redirect('menuadmin/tindakan');
    }
    public function riwayat_pasien() {
        $data['judul'] = 'Riwayat';
        $data['user'] = $this->MenuAdmin_model->getDokterByNo();
        $data['total_pasien_keluar'] = $this->MenuAdmin_model->total_pasien_keluar();
        $config['base_url'] = base_url('menuadmin/riwayat_pasien');
        $config['total_rows'] = $data['total_pasien_keluar'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $search = $this->input->post('search', true);
        $data['search'] = $search;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pasien_keluar'] = $this->MenuAdmin_model->get_pasien_keluar($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/riwayat', $data);
        $this->load->view('templates/footer');
    }


}
