<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien_model extends CI_Model
{
    public function getAllUser()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('user_role', 'user.id_role = user_role.id_role');
        $this->db->where('email', $this->session->userdata('email'));
        return $this->db->get()->row_array();
    }
    public function getUser()
    {
        return $this->db->get_where(
            'pasien',
            ['no_medis' => $this->session->userdata['no_medis']]
        )->row_array();
    }

    public function update_status($no_medis, $is_active)
    {
        $this->db->where('no_medis', $no_medis);
        $this->db->update('pasien', ['is_active' => $is_active]);
    }
    public function deleteUser($id)
    {
        $this->db->delete('pasien', ['no_medis' => $id]);
        redirect('admin/data_pasien');
    }

    public function editProfil()
    {
        $this->db->set('nama', htmlspecialchars($this->input->post('nama')));
        $this->db->set('no_telp', htmlspecialchars($this->input->post('no_telp')));
        $this->db->set('alamat', htmlspecialchars($this->input->post('alamat')));
        $this->db->where('no_medis', $this->session->userdata('no_medis'));
        $this->db->update('pasien');
        $this->session->set_flashdata('message_profil', '<div class="alert  alert-success" role="alert">Profil updated!</div>');
        redirect('pasien/profil');

    }



    public function get_rawat_inap_by_no()
    {
        $no_medis = $this->session->userdata('no_medis');
        $this->db->select('pasien.*, pelayanan.*, ruang_igd.nama_ruang_igd, ruang.nama_ruang');
        $this->db->from('pasien');
        $this->db->join('pelayanan', 'pasien.id_pasien = pelayanan.id_pasien');
        $this->db->join('ruang_igd', 'ruang_igd.id_ruang_igd = pelayanan.id_ruang_igd', 'left');
        $this->db->join('ruang', 'ruang.id_ruang = pelayanan.id_ruang', 'left');
        $this->db->order_by('pelayanan.tanggal_masuk', 'DESC');
        $this->db->where('pasien.is_active', 1);
        $this->db->where('pasien.no_medis', $no_medis);
        return $this->db->get()->result_array();

    }
    public function get_kunjungan_by_no()
    {
        $no_medis = $this->session->userdata('no_medis');
        $this->db->select('visite.*, pasien.*,  pegawai.nama_pegawai, ruang_igd.nama_ruang_igd, ruang.nama_ruang');
        $this->db->from('visite');
        $this->db->join('pasien', 'pasien.id_pasien = visite.id_pasien');
        $this->db->join('pegawai', 'pegawai.no_pegawai = visite.no_pegawai');
        $this->db->join('ruang_igd', 'ruang_igd.id_ruang_igd = visite.id_ruang_igd', 'left');
        $this->db->join('ruang', 'ruang.id_ruang = visite.id_ruang' , 'left');
        $this->db->order_by('visite.tanggal_visite', 'DESC');
        $this->db->where('pasien.no_medis', $no_medis);
        return $this->db->get()->result_array();
    }

    public function get_tindakan_by_no()
    {
        $no_medis = $this->session->userdata('no_medis');
        $this->db->select('t.*, pegawai.nama_pegawai, pasien.*, pl.id_ruang, r.nama_ruang, r_igd.nama_ruang_igd, jt.*');
        $this->db->from('tindakan_pasien t');
        $this->db->join('pasien', 'pasien.id_pasien = t.id_pasien');
        $this->db->join('pelayanan pl', 'pl.id_pelayanan = t.id_pelayanan');
        $this->db->join('ruang r', 'r.id_ruang = pl.id_ruang', 'left');
        $this->db->join('ruang_igd r_igd', 'r_igd.id_ruang_igd = pl.id_ruang_igd', 'left');
        $this->db->join('pegawai', 'pegawai.no_pegawai = t.no_pegawai');
        $this->db->join('jenis_tindakan jt', 'jt.id_tindakan = t.id_tindakan');
        $this->db->where('pasien.no_medis', $no_medis);
        $this->db->order_by('t.tanggal_tindakan', 'DESC');
        return $this->db->get()->result_array();
    }




}