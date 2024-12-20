<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    //role management
    public function getRoleById($id)
    {

        return $this->db->get_where('role', ['id_role' => $id])->row_array();
    }
    public function getRole()
    {

        return $this->db->get('role')->result_array();
    }
    public function addRole()
    {
        $data = [
            'role' => htmlspecialchars($this->input->post('role'))
        ];
        $this->db->insert('role', $data);
    }

    
    public function deleteRole($id)
    {
        $this->db->delete('role', ['id_role' => $id]);
    }
    public function updateRole()
    {
        $data = [
            'role' => htmlspecialchars($this->input->post('role'))
        ];
        $this->db->where('id_role', htmlspecialchars($this->input->post('id_role')));
        $this->db->update('role', $data);

        var_dump($data);
    }

    public function total_dokter()
    {
        return $this->db->count_all('pegawai'); //total pegawai
    }
    public function total_pasien()
    {
        return $this->db->count_all('pasien'); //total pasien
    }
//pagination
    public function get_dokter($limit, $start, $search)
    {
        $this->db->order_by('is_active', 'ASC');
        $this->db->limit($limit, $start);
        $this->db->where('id_role', 2);
        if(!empty($search)){
            $this->db->like('nama_dokter', $search);
            $this->db->or_like('no_telp', $search);
            $this->db->or_like('spesialisasi', $search);
        }
        return $this->db->get('pegawai')->result_array();
    }
    public function get_pasien($limit, $start, $search)
    {
        $this->db->order_by('is_active', 'ASC');
        $this->db->limit($limit, $start);
        if(!empty($search)){
            $this->db->like('nama', $search);
            $this->db->or_like('no_medis', $search);
            $this->db->or_like('no_telp', $search);
        }
        return $this->db->get('pasien')->result_array();
    }
        
    public function getPasien(){
        return $this->db->get('pasien')->result_array();
    }

    
}
?>