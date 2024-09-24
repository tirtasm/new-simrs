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
    public function get_pasien($limit, $start){      
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
    public function visite_pasien($limit, $start){      
        $this->db->select('p.no_medis,p.nama, r.nama_ruang, d.nama_dokter, v.tanggal_visite, v.catatan');
        $this->db->from('pasien p'); 
        $this->db->join('rawat_inap ri', 'p.id_pasien = ri.id_pasien'); 
        $this->db->join('ruang r', 'r.id_ruang = ri.id_ruang'); 
        $this->db->join('visite v', 'v.id_pasien = p.id_pasien');
        $this->db->join('dokter d', 'd.no_dokter = v.no_dokter');
        $this->db->where('ri.id_ruang IS NOT NULL'); 
        $this->db->order_by('ri.tanggal_masuk', 'DESC');  
        $this->db->limit($limit, $start); 
        return $this->db->get()->result_array();
    }
    
    public function total_pasien(){
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
    public function update_status($no_dokter, $is_active) {
        $this->db->where('no_dokter', $no_dokter);
        $this->db->update('dokter', ['is_active' => $is_active]);
    }
    public function delete($id){
        $this->db->delete('dokter', ['no_dokter' => $id]);
        redirect('admin/data_dokter');
    }
}
?>