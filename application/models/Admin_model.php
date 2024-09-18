<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
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
        echo $this->db->insert('role', $data);
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
    public function getUser()
    {
        return $this->db->get_where(
            'admin',
            ['email' => $this->session->userdata['email']]
        )->row_array();
    }
    
}
?>