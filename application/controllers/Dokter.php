<?php 
    class Dokter extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model('Auth_model');
            $this->load->model('Dokter_model');
        }
      
        public function login()
        {
            $this->form_validation->set_rules('no_dokter', 'No. Dokter', 'required|trim', [
                'required' => 'No. Dokter harus diisi!'
            ]);
            $this->form_validation->set_rules('password', 'Password', 'required|trim', [
                'required' => 'Password harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $data['judul'] = 'Login | Dokter';
                $this->load->view('templates/home_header', $data);
                $this->load->view('dokter/login');
                $this->load->view('templates/home_footer');
            } else {
                $this->Auth_model->login_dokter();
            }
        }
        public function profil()
        {
            // echo 'dashboard';
            $data['user'] = $this->Dokter_model->getDokterByNo();
            
            $data['judul'] = 'Profil';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/profil');
            $this->load->view('templates/footer');
        }
        public function edit(){
         
                $this->Dokter_model->update();
                $this->session->set_flashdata('message_profil', ' edited!');
                redirect('dokter/profil');
        }
        
        public function tindakan()
        {
            $data['user'] = $this->Dokter_model->getDokterByNo();
            
            $data['judul'] = 'Tindakan';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/tindakan');
            $this->load->view('templates/footer');
        }
        
    }
?>