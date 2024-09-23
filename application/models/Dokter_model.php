<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter_model extends CI_Model
{

    public function getDokterById($no_dokter)
    {
        return $this->db->get_where('dokter', ['no_dokter' => $no_dokter])->row_array();
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