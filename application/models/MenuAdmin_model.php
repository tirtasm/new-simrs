<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuAdmin_model extends CI_Model
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
        $this->db->order_by('rawat_inap.tanggal_keluar', 'ASC');
        $this->db->limit($limit, $start);
        $this->db->where('pasien.is_active', 1);
        return $this->db->get()->result_array();
    
    }
    public function total_pasien(){
        $this->db->from('rawat_inap');
        $this->db->join('pasien', 'pasien.id_pasien = rawat_inap.id_pasien');
        // $this->db->where('rawat_inap.id_ruang IS NOT NULL'); 
        return $this->db->count_all_results();
    }

    public function keluar($no_medis){
        $this->db->set('tanggal_keluar', date('Y-m-d'));
        $this->db->where('id_pasien', $no_medis);
        $this->db->update('rawat_inap');
    }
    
    
}
?>