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
            $this->load->model('MenuAdmin_model');
            // check_login();
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
        
        public function data_pasien() {
            $data['judul'] = 'Data Pasien';
            $data['user'] = $this->Dokter_model->getDokterByNo();
            $search = $this->input->post('search', true); 
            $data['search'] = $search; 
            $data['total_pasien'] = $this->Dokter_model->total_pasien($search);
            $this->load->library('pagination');
            $config['base_url'] = base_url('dokter/data_pasien');
            $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['pasien'] = $this->Dokter_model->get_pasien($config['per_page'], $page, $search);
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
            $search = $this->input->post('search', true); 
            $data['search'] = $search; 
            $data['total_pasien'] = $this->Dokter_model->total_pasien($search);
            $this->load->library('pagination');
            $config['base_url'] = base_url('dokter/visite');
            $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
    
            $this->pagination->initialize($config);
    
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['pasien'] = $this->Dokter_model->get_pasien($config['per_page'], $page, $search);
            $data['ruang'] = $this->MenuAdmin_model->get_ruang();
            $data['v_pasien'] = $this->Dokter_model->visite_pasien($config['per_page'], $page, $search);
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/visite', $data);
            $this->load->view('templates/footer');
        }

        public function addvisite(){
            $this->form_validation->set_rules('catatan', 'Catatan', 'required|trim', [
                'required' => 'Catatan harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('visite_failed', ' Catatan harus diisi!');
                redirect('dokter/visite');
            } else {
                $this->Dokter_model->addVisite();
                $this->session->set_flashdata('visite_success', 'berhasil ditambahkan!');
                redirect('dokter/visite');
            }
        }
        public function getEditVisite()
        {
            echo json_encode($this->Dokter_model->getVisiteById($this->input->post('id_visite')));
        }
        public function getEditTindakanDokter()
        {
            echo json_encode($this->Dokter_model->getTindakanPasienById($this->input->post('id_tindakan_pasien')));
        }
        public function editVisite()
        {
            $this->form_validation->set_rules('catatan', 'Catatan', 'required|trim', [
                'required' => 'Catatan harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('visite_failed', ' Catatan harus diisi!');
                redirect('dokter/visite');
            } else {
                $this->Dokter_model->editVisite();
                $this->session->set_flashdata('visite_success', 'berhasil diedit!');
                redirect('dokter/visite');
            }
        }
        
        public function deleteVisite($id)
        {
            $id = $this->uri->segment(3);
            $this->Dokter_model->deleteVisite($id);
            $this->session->set_flashdata('visite_success', ' berhasil dihapus');
            redirect('dokter/visite');
        }

        public function tindakan()
        {
            $data['judul'] = 'Tindakan';
            $data['user'] = $this->Dokter_model->getDokterByNo();
            // $data['total_pasien'] = $this->Dokter_model->total_pasien();
            $this->load->library('pagination');
            // $config['base_url'] = base_url('dokter/data_pasien');
            // $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
    
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $search = $this->input->post('search', true); 
            $data['search'] = $search;

            $data['pasien'] = $this->MenuAdmin_model->get_pasien($config['per_page'], $page, $search);
            $data['tindakan'] = $this->MenuAdmin_model->get_tindakan_all($config['per_page'], $page);
            $data['v_tindakan'] = $this->Dokter_model->v_tindakan($config['per_page'], $page, $search);
            $data['ruang'] = $this->MenuAdmin_model->get_ruang();
            // $data['v_pasien'] = $this->Dokter_model->visite_pasien($config['per_page'], $page);
            $data['pagination'] = $this->pagination->create_links();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/tindakan' );
            $this->load->view('templates/footer');
        }
        public function addtindakan(){
            $this->form_validation->set_rules('catatan', 'Catatan', 'required|trim', [
                'required' => 'Catatan harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('tindakan_failed', ' Catatan harus diisi!');
                redirect('dokter/tindakan');
            } else {
                $this->Dokter_model->addTindakan();
                $this->session->set_flashdata('tindakan_success', 'berhasil ditambahkan!');
                redirect('dokter/tindakan');
            }
        }
        public function deleteTindakan($id)
        {
            $id = $this->uri->segment(3);
            $this->Dokter_model->deleteTindakan($id);
            $this->session->set_flashdata('tindakan_success', ' berhasil dihapus');
            redirect('dokter/tindakan');
        }
        public function editTindakan()
        {
            // $this->Dokter_model->editTindakanDokter();
            $this->form_validation->set_rules('catatan', 'Catatan', 'required|trim', [
                'required' => 'Catatan harus diisi!'
            ]);
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('tindakan_failed', ' Catatan harus diisi!');
                redirect('dokter/tindakan');
            } else {
                $this->Dokter_model->editTindakanDokter();
                $this->session->set_flashdata('tindakan_success', 'berhasil diedit!');
                redirect('dokter/tindakan');
            }
        }

        public function catatan(){
            $data['judul'] = 'Catatan Dokter';
            $data['user'] = $this->Dokter_model->getDokterByNo();
            $search = $this->input->post('search', true); 
            $data['search'] = $search; 
            $data['total_pasien'] = $this->Dokter_model->total_pasien($search);
            $this->load->library('pagination');
            $config['base_url'] = base_url('dokter/catatan');
            $config['total_rows'] = $data['total_pasien'];
            $config['per_page'] = 10;
            $config['num_links'] = 5;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data['catatan'] = $this->Dokter_model->catatan_dokter($config['per_page'], $page, $search);
            $data['pagination'] = $this->pagination->create_links();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/catatan_dokter', $data);
            $this->load->view('templates/footer');
        }
        
    }
?>