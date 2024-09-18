<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_model');

    }
    
    public function login()
    {
        
        $this->form_validation->set_rules('no_medis', 'No. Medis', 'required|trim', [
            'required' => 'No. Medis harus diisi!'
        ]);
        $this->form_validation->set_rules('tanggal_lahir', 'Password', 'required|callback_check_date', [
            'required' => 'Tanggal lahir harus diisi!'
        ]);


        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Login | User';
            $this->load->view('templates/home_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/home_footer');
        } else {
            // echo base_url('user/registration');
            $this->Auth_model->_login();
        }
    }
    public function blocked()
    {
        $data['judul'] = 'Access Forbidden';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/denied');
        $this->load->view('templates/auth_footer');
    }
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('email_message', '<div class="alert alert-success" role="alert">You have been logged out! </div>');
        redirect('auth/login');
    }

    public function forgotpassword()
    {
        $data['judul'] = 'Forgot Password';
        $data['user'] = $this->Auth_model->getUser();

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email is required!',
            'valid_email' => 'Email is not valid!'
        ]);


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot');
            $this->load->view('templates/auth_footer');
        } else {
            $this->Auth_model->_forgotPassword();
        }


    }
    public function registrasi()
    {
        if ($this->session->userdata('no_medis')) {
            redirect('user/regis');
        }
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required' => 'Nama lengkap harus diisi!'
        ]);

        $this->form_validation->set_rules('no_telp', 'No Telepon', 'required|trim|regex_match[/^08[0-9]{8,13}$/]|is_unique[pasien.no_telp]', [
            'required' => 'Nomor telepon harus diisi!',
            'regex_match' => 'Nomor telepon tidak valid!',
            'is_unique' => 'Nomor ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('no_medis', 'No Telepon', 'is_unique[pasien.no_medis]|regex_match[/^08[0-9]{8,13}$/]', [
            'is_unique' => '',
            'regex_match' => 'Nomor telepon tidak valid!'
        ]);
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal lahir', 'required|callback_check_date', [
            'required' => 'Tanggal lahir harus diisi!'
        ]);

        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', [
            'required' => 'Alamat lengkap harus diisi!'
        ]);

        if ($this->form_validation->run() == false) {

            $data['judul'] = 'Registrasi | User';
            $data['pasien'] = $this->Auth_model->getNoMedis();

            $this->load->view('templates/home_header', $data);
            $this->load->view('auth/regis');
            $this->load->view('templates/home_footer');
        } else {
            $this->Auth_model->_registration();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! Your account has been created. Please activate your account!</div>');


        }

    }
    public function check_date($date)
    {
        if ($date > date('Y-m-d')) {
            $this->form_validation->set_message('check_date', 'Tanggal lahir tidak valid!');
            return FALSE;
        }
        return TRUE;
    }

    public function resetpassword()
    {
        $this->Auth_model->_resetpassword();
    }

    public function verify()
    {
        $this->Auth_model->_verify();
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth/login');
        }
        $this->form_validation->set_rules('newpass', 'Password', 'required|trim|min_length[4]', [
            'required' => 'Password is required!',
            'min_length' => 'Password too short!'
        ]);

        $this->form_validation->set_rules('repass', 'Password', 'trim|matches[newpass]', [
            'matches' => 'Password dont match!',

        ]);
        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/changePassword');
            $this->load->view('templates/auth_footer');
        } else {

            $this->Auth_model->_changePassword();
            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please login.</div>');
            redirect('auth/login');
        }
    }

}
?>