<?php 
    class Pegawai extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model('Auth_model');
            $this->load->model('Pegawai_model');
            $this->load->model('Admin_model');
            $this->load->model('MenuAdmin_model');
            // check_login();
        }
      public function index(){
        echo 'tes';
      }
        public function login()
        {
            $this->form_validation->set_rules('no_pegawai', 'No. Dokter', 'required|trim', [
                'required' => 'No. Dokter harus diisi!'
            ]);
            $this->form_validation->set_rules('password', 'Password', 'required|trim', [
                'required' => 'Password harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $data['judul'] = 'Login | Dokter';
                $this->load->view('templates/home_header', $data);
                $this->load->view('pegawai/login');
                $this->load->view('templates/home_footer');
            } else {
                $this->Auth_model->login_dokter();
            }
        }
        public function profil()
        {
            // echo 'dashboard';
            $data['user'] = $this->Pegawai_model->getDokterByNo();
            
            $data['judul'] = 'Profil';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pegawai/profil');
            $this->load->view('templates/footer');
        }
        public function edit(){
         
                $this->Pegawai_model->update();
                $this->session->set_flashdata('message_profil', ' edited!');
                redirect('pegawai/profil');
        }
        
        public function data_pasien() {
            $data['judul'] = 'Data Pasien';
            $data['user'] = $this->Pegawai_model->getDokterByNo();
            $search = $this->input->post('search', true); 
            $data['search'] = $search; 
            $data['total_pasien'] = $this->Pegawai_model->total_pasien($search);
            $this->load->library('pagination');
            $config['base_url'] = base_url('pegawai/data_pasien');
            $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['pasien'] = $this->Pegawai_model->get_pasien($config['per_page'], $page, $search);
            $data['pagination'] = $this->pagination->create_links();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pegawai/data_pasien', $data);
            $this->load->view('templates/footer');
        }
        

    
        public function visite()
        {
            $data['judul'] = 'Visite';
            $data['user'] = $this->Pegawai_model->getDokterByNo();
            $search = $this->input->post('search', true); 
            $data['search'] = $search; 
            $data['total_pasien'] = $this->Pegawai_model->total_pasien($search);
            $this->load->library('pagination');
            $config['base_url'] = base_url('pegawai/visite');
            $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
    
            $this->pagination->initialize($config);
    
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['pasien'] = $this->Pegawai_model->get_pasien($config['per_page'], $page, $search);
            $data['ruang'] = $this->MenuAdmin_model->get_ruang();
            $data['v_pasien'] = $this->Pegawai_model->visite_pasien($config['per_page'], $page, $search);
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pegawai/visite', $data);
            $this->load->view('templates/footer');
        }

        public function addvisite(){
            $this->form_validation->set_rules('catatan', 'Catatan', 'required|trim', [
                'required' => 'Catatan harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('visite_failed', ' Catatan harus diisi!');
                redirect('pegawai/visite');
            } else {
                $this->Pegawai_model->addVisite();
                $this->session->set_flashdata('visite_success', 'berhasil ditambahkan!');
                redirect('pegawai/visite');
            }
        }
        public function getEditVisite()
        {
            echo json_encode($this->Pegawai_model->getVisiteById($this->input->post('id_visite')));
        }
        public function getEditTindakanDokter()
        {
            echo json_encode($this->Pegawai_model->getTindakanPasienById($this->input->post('id_tindakan_pasien')));
        }
        public function editVisite()
        {
            $this->form_validation->set_rules('catatan', 'Catatan', 'required|trim', [
                'required' => 'Catatan harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('visite_failed', ' Catatan harus diisi!');
                redirect('pegawai/visite');
            } else {
                $this->Pegawai_model->editVisite();
                $this->session->set_flashdata('visite_success', 'berhasil diedit!');
                redirect('pegawai/visite');
            }
        }
        
        public function deleteVisite($id)
        {
            $id = $this->uri->segment(3);
            $this->Pegawai_model->deleteVisite($id);
            $this->session->set_flashdata('visite_success', ' berhasil dihapus');
            redirect('pegawai/visite');
        }

        public function tindakan()
        {
            $data['judul'] = 'Tindakan';
            $data['user'] = $this->Pegawai_model->getDokterByNo();
            // $data['total_pasien'] = $this->Pegawai_model->total_pasien();
            $this->load->library('pagination');
            // $config['base_url'] = base_url('pegawai/data_pasien');
            // $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
    
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $search = $this->input->post('search', true); 
            $data['search'] = $search;

            $data['pasien'] = $this->MenuAdmin_model->get_pasien($config['per_page'], $page, $search);
            $data['tindakan'] = $this->MenuAdmin_model->get_tindakan_all($config['per_page'], $page);
            $data['v_tindakan'] = $this->Pegawai_model->v_tindakan($config['per_page'], $page, $search);
            $data['ruang'] = $this->MenuAdmin_model->get_ruang();
            // $data['v_pasien'] = $this->Pegawai_model->visite_pasien($config['per_page'], $page);
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pegawai/tindakan' );
            $this->load->view('templates/footer');
        }
        public function addtindakan(){
            $this->form_validation->set_rules('catatan', 'Catatan', 'required|trim', [
                'required' => 'Catatan harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('tindakan_failed', ' Catatan harus diisi!');
                redirect('pegawai/tindakan');
            } else {
                $this->Pegawai_model->addTindakan();
                $this->session->set_flashdata('tindakan_success', 'berhasil ditambahkan!');
                redirect('pegawai/tindakan');
            }
        }
        public function deleteTindakan($id)
        {
            $id = $this->uri->segment(3);
            $this->Pegawai_model->deleteTindakan($id);
            $this->session->set_flashdata('tindakan_success', ' berhasil dihapus');
            redirect('pegawai/tindakan');
        }
        public function editTindakan()
        {
            // $this->Pegawai_model->editTindakanDokter();
            $this->form_validation->set_rules('catatan', 'Catatan', 'required|trim', [
                'required' => 'Catatan harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('tindakan_failed', ' Catatan harus diisi!');
                redirect('pegawai/tindakan');
            } else {
                $this->Pegawai_model->editTindakanDokter();
                $this->session->set_flashdata('tindakan_success', 'berhasil diedit!');
                redirect('pegawai/tindakan');
            }
        }

        public function catatan(){
            $data['judul'] = 'Catatan Dokter';
            $data['user'] = $this->Pegawai_model->getDokterByNo();
            $search = $this->input->post('search', true); 
            $data['search'] = $search; 
            $data['total_pasien'] = $this->Pegawai_model->total_pasien($search);
            $this->load->library('pagination');
            $config['base_url'] = base_url('pegawai/catatan');
            $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['catatan'] = $this->Pegawai_model->catatan_dokter($config['per_page'], $page, $search);
            $data['pagination'] = $this->pagination->create_links();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pegawai/catatan_dokter', $data);
            $this->load->view('templates/footer');
        }
        
    }
?>