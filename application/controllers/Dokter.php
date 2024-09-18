<?php 
    class Dokter extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model('Auth_model');
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
        public function dashboard()
        {
            // echo 'dashboard';
            // $data['user'] = $this->Dokter_model->getUser();
            // var_dump($data['user']);
            $data['judul'] = 'Dashboard | Dokter';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/index');
            $this->load->view('templates/footer');
        }
        public function role()
        {
            $data['user'] = $this->Dokter_model->getUser();
            $data['judul'] = 'Dashboard | Dokter';
            $data['role'] = $this->Dokter_model->getRole();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('dokter/role', $data);
            $this->load->view('templates/footer');
        }
        //crud role
        public function delete($id)
        {
            $this->Dokter_model->deleteRole($id);
        }
    }
?>