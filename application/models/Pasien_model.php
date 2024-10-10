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
        $this->db->select('pasien.*, rawat_inap.*, ruang.*');
        $this->db->from('pasien');
        $this->db->join('rawat_inap', 'pasien.id_pasien = rawat_inap.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = rawat_inap.id_ruang');
        $this->db->order_by('rawat_inap.tanggal_masuk', 'DESC');
        $this->db->where('pasien.is_active', 1);
        $this->db->where('pasien.no_medis', $no_medis);
        return $this->db->get()->result_array();

    }
    public function get_kunjungan_by_no()
    {
        $no_medis = $this->session->userdata('no_medis');
        $this->db->select('visite.*, pasien.*, dokter.nama_dokter, ruang.nama_ruang');
        $this->db->from('visite');
        $this->db->join('pasien', 'pasien.id_pasien = visite.id_pasien');
        $this->db->join('dokter', 'dokter.no_dokter = visite.no_dokter');
        $this->db->join('ruang', 'ruang.id_ruang = visite.id_ruang');
        $this->db->order_by('visite.tanggal_visite', 'DESC');
        $this->db->where('pasien.no_medis', $no_medis);
        return $this->db->get()->result_array();
    }

    public function get_tindakan_by_no()
    {
        $no_medis = $this->session->userdata('no_medis');
        $this->db->select('t.*, dokter.nama_dokter, pasien.*, ri.id_ruang, r.nama_ruang, jt.*');
        $this->db->from('tindakan_pasien t');
        $this->db->join('pasien', 'pasien.id_pasien = t.id_pasien');
        $this->db->join('rawat_inap ri', 'ri.id_rawat = t.id_rawat');
        $this->db->join('ruang r', 'r.id_ruang = ri.id_ruang');
        $this->db->join('dokter', 'dokter.no_dokter = t.no_dokter');
        $this->db->join('jenis_tindakan jt', 'jt.id_tindakan = t.id_tindakan');
        $this->db->where('pasien.no_medis', $no_medis);
        $this->db->order_by('t.tanggal_tindakan', 'DESC');
        return $this->db->get()->result_array();
    }




}