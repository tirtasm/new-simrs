<?php 
    class Dokter extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model('Auth_model');
            $this->load->model('Dokter_model');
            $this->load->model('Admin_model');
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
        
        public function data_pasien(){
            $data['judul'] = 'Data Pasien';
            $data['user'] = $this->Dokter_model->getDokterByNo();
            
            $data['total_pasien'] = $this->Dokter_model->total_pasien();
    
            $this->load->library('pagination');
            $config['base_url'] = base_url('dokter/data_pasien');
            $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
    
            $this->pagination->initialize($config);
    
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['pasien'] = $this->Dokter_model->get_pasien($config['per_page'], $page);
            $data['pagination'] = $this->pagination->create_links();
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/data_pasien', $data);
            $this->load->view('templates/footer');
        }
    
        public function visite()
        {
            $data['judul'] = 'Visite';
            $data['user'] = $this->Dokter_model->getDokterByNo();
             
            $data['total_pasien'] = $this->Dokter_model->total_pasien();
    
            $this->load->library('pagination');
            $config['base_url'] = base_url('dokter/data_pasien');
            $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
    
            $this->pagination->initialize($config);
    
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['pasien'] = $this->Dokter_model->visite_pasien($config['per_page'], $page);
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/visite');
            $this->load->view('templates/footer');
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