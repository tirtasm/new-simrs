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
    }

    public function total_dokter()
    {
        return $this->db->count_all('dokter'); //total dokter
    }

    public function get_dokter($limit, $start)
    {
        $this->db->order_by('no_dokter', 'ASC');
        $this->db->limit($limit, $start);
        $this->db->where('id_role', 2);
        return $this->db->get('dokter')->result_array();
    }
    

    public function getDokterByNo()
    {
        return $this->db->get_where(
            'dokter',
            ['no_dokter' => $this->session->userdata['no_dokter']], 
        )->row_array();
    }

    
}
?>