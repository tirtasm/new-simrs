<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter_model extends CI_Model
{


    public function getDokterByNo()
    {
        return $this->db->get_where(
            'dokter',
            ['no_dokter' => $this->session->userdata['no_dokter']],
        )->row_array();
    }
    public function get_pasien($limit, $start)
    {
        $this->db->select('pasien.*, rawat_inap.*, ruang.*');
        $this->db->from('pasien');
        $this->db->join('rawat_inap', 'pasien.id_pasien = rawat_inap.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = rawat_inap.id_ruang');
        $this->db->order_by('rawat_inap.tanggal_masuk', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->where('pasien.is_active', 1);
        $this->db->where('rawat_inap.tanggal_keluar', NULL);
        return $this->db->get()->result_array();

    }

    public function total_pasien()
    {
        $this->db->from('rawat_inap');
        $this->db->join('pasien', 'pasien.id_pasien = rawat_inap.id_pasien');
        $this->db->where('rawat_inap.id_ruang IS NOT NULL');
        return $this->db->count_all_results();
    }
    public function update()
    {
        $data = [
            'nama' => htmlspecialchars($this->input->post('nama')),
            'no_telp' => htmlspecialchars($this->input->post('no_telp')),
            'spesialisasi' => htmlspecialchars($this->input->post('spesialisasi'))
        ];
        $this->db->where('no_dokter', $this->input->post('no_dokter'));
        $this->db->update('dokter', $data);
    }
    public function update_status($no_dokter, $is_active)
    {
        $this->db->where('no_dokter', $no_dokter);
        $this->db->update('dokter', ['is_active' => $is_active]);
    }
    public function delete($id)
    {
        $this->db->delete('dokter', ['no_dokter' => $id]);
        redirect('admin/data_dokter');
    }

    public function visite_pasien($limit, $start)
    {
        $this->db->select('visite.*, pasien.*, dokter.nama_dokter, ruang.nama_ruang');
        $this->db->from('visite');
        $this->db->join('pasien', 'pasien.id_pasien = visite.id_pasien');
        $this->db->join('dokter', 'dokter.no_dokter = visite.no_dokter');
        $this->db->join('ruang', 'ruang.id_ruang = visite.id_ruang');
        $this->db->order_by('visite.tanggal_visite', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }
    public function getVisiteById($id)
    {
        $this->db->select('visite.*, pasien.*, ruang.*, dokter.nama_dokter');
        $this->db->from('visite');
        $this->db->join('pasien', 'pasien.id_pasien = visite.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = visite.id_ruang');
        $this->db->join('dokter', 'dokter.no_dokter = visite.no_dokter');
        $this->db->where('visite.id_visite', $id);
        $this->db->order_by('visite.tanggal_visite', 'DESC');

        return $this->db->get()->row_array();
    }
    public function addVisite()
    {
        $data = [
            'id_pasien' => htmlspecialchars($this->input->post('nama_pasien')),
            'no_dokter' => htmlspecialchars($this->input->post('no_dokter')),
            'id_ruang' => htmlspecialchars($this->input->post('id_ruang')),
            'tanggal_visite' => htmlspecialchars($this->input->post('tanggal_visite')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        $this->db->insert('visite', $data);
    }

    public function editVisite()
    {
        $data = [
            'id_pasien' => htmlspecialchars($this->input->post('id_pasien')),
            'no_dokter' => htmlspecialchars($this->input->post('no_dokter')),
            'id_ruang' => htmlspecialchars($this->input->post('id_ruang')),
            'tanggal_visite' => htmlspecialchars($this->input->post('tanggal_visite')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        $this->db->where('id_visite', $this->input->post('id_visite'));
        $this->db->update('visite', $data);
    }

    public function deleteVisite($id)
    {
        $this->db->delete('visite', ['id_visite' => $id]);
    }



}
?>