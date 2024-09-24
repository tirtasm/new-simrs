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