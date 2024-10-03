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
    public function getTindakanPasienById($id)
    {
        $this->db->select('t.*, dokter.*, pasien.*, ri.*, r.*, jt.*');
        $this->db->from('tindakan_pasien t');
        $this->db->join('pasien', 'pasien.id_pasien = t.id_pasien');
        $this->db->join('rawat_inap ri', 'ri.id_rawat = t.id_rawat');
        $this->db->join('ruang r', 'r.id_ruang = ri.id_ruang');
        $this->db->join('dokter', 'dokter.no_dokter = t.no_dokter');
        $this->db->join('jenis_tindakan jt', 'jt.id_tindakan = t.id_tindakan');
        $this->db->order_by('t.tanggal_tindakan', 'DESC');
        $this->db->where('t.id_tindakan_pasien', $id);
        return $this->db->get()->result_array();
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
            'id_pasien' => htmlspecialchars($this->input->post('nama_pasien')),
            'no_dokter' => htmlspecialchars($this->input->post('no_dokter')),
            'id_ruang' => htmlspecialchars($this->input->post('id_ruang')),
            'tanggal_visite' => htmlspecialchars($this->input->post('tanggal_visite')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        var_dump($data);
        $this->db->where('id_visite', $this->input->post('id_visite'));
        $this->db->update('visite', $data);
    }

    public function deleteVisite($id)
    {
        $this->db->delete('visite', ['id_visite' => $id]);
    }

    public function v_tindakan($limit, $start)
    {
        $this->db->select('t.*, dokter.nama_dokter, pasien.nama, ri.id_ruang, r.nama_ruang, jt.nama_tindakan');
        $this->db->from('tindakan_pasien t');
        $this->db->join('pasien', 'pasien.id_pasien = t.id_pasien');
        $this->db->join('rawat_inap ri', 'ri.id_rawat = t.id_rawat');
        $this->db->join('ruang r', 'r.id_ruang = ri.id_ruang');
        $this->db->join('dokter', 'dokter.no_dokter = t.no_dokter');
        $this->db->join('jenis_tindakan jt', 'jt.id_tindakan = t.id_tindakan');
        $this->db->order_by('t.tanggal_tindakan', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }
    
    public function addTindakan()
    {
        $data = [
            'id_pasien' => htmlspecialchars($this->input->post('nama_pasien')),
            'no_dokter' => htmlspecialchars($this->input->post('no_dokter')),
            'id_rawat' => htmlspecialchars($this->input->post('id_rawat')),
            'id_tindakan' => htmlspecialchars($this->input->post('id_tindakan')),
            'tanggal_tindakan' => htmlspecialchars($this->input->post('tanggal_tindakan')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        $this->db->insert('tindakan_pasien', $data);
    }
    public function deleteTindakan($id)
    {
        $this->db->delete('tindakan_pasien', ['id_tindakan_pasien' => $id]);
    }
    public function editTindakanDokter(){
        $data = [
            'id_pasien' => htmlspecialchars($this->input->post('nama_pasien')),
            'no_dokter' => htmlspecialchars($this->input->post('no_dokter')),
            'id_rawat' => htmlspecialchars($this->input->post('id_rawat')),
            'id_tindakan' => htmlspecialchars($this->input->post('id_tindakan')),
            'tanggal_tindakan' => htmlspecialchars($this->input->post('tanggal_tindakan')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        $this->db->where('id_tindakan_pasien', $this->input->post('id_tindakan_pasien'));
        $this->db->update('tindakan_pasien', $data);
        // var_dump($data);
    }

}
?>