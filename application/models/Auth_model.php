<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth_model extends CI_Model
{
    public function getPasien()
    {
        return $this->db->get('pasien');

    }
    public function getDokter()
    {
        return $this->db->get('pegawai');


    }
    public function getNoMedis()
    {
        $this->db->select('no_medis');
        $this->db->order_by('id_pasien', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('pasien')->row_array();
        return $query;
    }
    public function _registration()
    {
        $no_medis = 'P' . date('Ymd') . rand(1000, 9999);

        $data = [
            'no_medis' => $no_medis,
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'no_telp' => htmlspecialchars($this->input->post('no_telp', true)),
            'alamat' => htmlspecialchars($this->input->post('alamat', true)),
            'tanggal_lahir' => htmlspecialchars($this->input->post('tanggal_lahir', true)),
            'gambar' => 'default.jpg',
            'id_role' => 3,
            'is_active' => 0, 
            'is_inap' => 0,
            'date_created' => time()
        ];
        $this->db->insert('pasien', $data);
        $this->session->set_flashdata('daftar_pasien', 'Berhasil');
        redirect('auth/registrasi');

    }
    //login pasien
    public function login()
{
    $no_medis = $this->input->post('no_medis');
    $tanggal_lahir = $this->input->post('tanggal_lahir');
    $pasien = $this->db->get_where('pasien', ['no_medis' => $no_medis])->row_array();
    
    if ($pasien) {
        // Periksa apakah tanggal lahir dan no_medis cocok
        if ($pasien['tanggal_lahir'] == $tanggal_lahir && $pasien['no_medis'] == $no_medis) {
            
            // Set sesi untuk pengguna yang berhasil login
            $data = [
                'no_medis' => $pasien['no_medis'],
                'id_role' => $pasien['id_role']
            ];
            $this->session->set_userdata($data);
            $this->session->set_flashdata('login_success', 'Silahkan aktivasi akun pasien Anda ke petugas kami!');
            redirect('auth/login');
        } else {
            // Jika tanggal lahir atau no_medis salah
            $this->session->set_flashdata('login_error', 'Pastikan No. Registrasi Medis dan Tanggal Lahir benar!');
            redirect('auth/login');
        }
    } else {
        // Jika No. Medis tidak ditemukan di database
        $this->session->set_flashdata('no_medis', '<div class="alert alert-danger" role="alert">No. Registrasi Medis tidak ditemukan!</div>');
        redirect('auth/login');
    }
}

    public function login_dokter()
    {
        $no_pegawai = htmlspecialchars($this->input->post('no_pegawai'));
        $password = htmlspecialchars($this->input->post('password'));
        $pegawai = $this->db->get_where('pegawai', ['no_pegawai' => $no_pegawai])->row_array();

        if ($pegawai) {
            if ($pegawai['no_pegawai'] == $no_pegawai && $pegawai['password'] == $password) {

                //admin
                if ($pegawai['id_role'] == 1) {
                    $data = [
                        'no_pegawai' => $pegawai['no_pegawai'],
                        'id_role' => $pegawai['id_role']
                    ];
                    $this->session->set_userdata($data);
                    var_dump($data);
                    echo 'ok';
                    $this->session->set_flashdata('login_success', 'ok');
                    redirect('admin/dashboard');
                }
                //pegawai
                else if ($pegawai['id_role'] == 2) {
                    if ($pegawai['is_active'] == 0) {
                        $this->session->set_flashdata('login_error', 'Akun Anda belum diaktivasi oleh petugas!');
                        redirect('pegawai/login');
                    } else {

                        $data = [
                            'no_pegawai' => $pegawai['no_pegawai'],
                            'id_role' => $pegawai['id_role']
                        ];
                        $this->session->set_userdata($data);
                        var_dump($data);
                        $this->session->set_flashdata('login_success', 'ok');
                        redirect('pegawai/profil');
                    }
                }
            } else {
                $this->session->set_flashdata('login_error', 'Pastikan No. Dokter dan Password benar!');
                redirect('pegawai/login');
                var_dump($pegawai);
            }
        } else {
            echo 'gagal';
        }
    }
    public function _login()
    {
        $no_medis = $this->input->post('no_medis');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $pasien = $this->db->get_where('pasien', ['no_medis' => $no_medis])->row_array();
        // var_dump($pasien['tanggal_lahir']);
        if ($pasien) {
            if ($pasien['tanggal_lahir'] == $tanggal_lahir && $pasien['no_medis'] == $no_medis) {
                $this->session->set_flashdata('login_success', 'Silahkan aktivasi akun pasien Anda ke petugas kami!');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('login_error', 'Pastikan No. Registrasi Medis dan Tanggal Lahir benar!');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('no_medis', '<div class="alert alert-danger" role="alert">No. Registrasi Medis tidak ditemukan!</div>');
            redirect('auth/login');
        }
        echo 'ok';

    }

    public function _forgotPassword()
    {

        $email = htmlspecialchars($this->input->post('email'));
        $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
        if ($user) {
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => htmlspecialchars($email),
                'token' => htmlspecialchars($token),
                'date_created' => time()
            ];
            $this->db->insert('user_token', $user_token);
            $this->_sendEmail($token, 'forgot');
            $this->session->set_flashdata('check_email', '<div class="alert alert-success" role="alert">Please check your email to reset your password!</div>');
            redirect('auth/forgotpassword');
        } else {
            $this->session->set_flashdata('validasi', '<small class="text-danger pl-2">Email is not registered or activated!</small>');
            redirect('auth/forgotpassword');
        }
    }
    public function _resetpassword()
    {
        $email = htmlspecialchars($this->input->get('email'));
        $token = htmlspecialchars($this->input->get('token'));

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                redirect('auth/changepassword');

            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong token.</div>');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong email.</div>');
            redirect('auth/login');
        }
    }

    public function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'akunsimpanan023@gmail.com',
            'smtp_pass' => 'afok etus dzrp aucp',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        $this->email->initialize($config);

        $this->email->from('akunsimpanan023@gmail.com', 'Akun Email');
        $this->email->to(htmlspecialchars($this->input->post('email')));


        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . htmlspecialchars($this->input->post('email')) . '&token=' . urlencode($token) . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . htmlspecialchars($this->input->post('email')) . '&token=' . urlencode($token) . '">Reset Password</a>');
        }
        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function _verify()
    {
        $email = htmlspecialchars($this->input->get('email'));
        $token = htmlspecialchars($this->input->get('token'));

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token')->row_array();
            // var_dump($user_token);
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated! Please login.</div>');
                    redirect('auth/login');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token expired.</div>');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token invalid.</div>');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong email.</div>');
            redirect('auth/login');
        }
    }
    public function _changePassword()
    {
        $password = htmlspecialchars(password_hash($this->input->post('newpass'), PASSWORD_DEFAULT));
        $email = $this->session->userdata('reset_email');
        $this->db->set('password', $password);
        $this->db->where('email', $email);
        $this->db->update('user');
    }

}