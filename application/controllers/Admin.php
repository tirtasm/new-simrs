<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Admin_model');
        $this->load->model('Menu_model');
        $this->load->model('Dokter_model');
        $this->load->model('User_model');
        // check_login();
    }
    public function dashboard()
    {
        
        $data['user'] = $this->Admin_model->getDokterByNo();
        $data['judul'] = 'Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
    public function role()
    {
        $data['judul'] = 'Role';
        $data['user'] = $this->Admin_model->getDokterByNo();
        $data['role'] = $this->Admin_model->getRole();
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }
    public function roleaccess($role_id)
    {
        $data['judul'] = 'Role Access';
        $data['user'] = $this->Admin_model->getDokterByNo();
        $data['role'] = $this->Admin_model->getRoleById($role_id);
        $this->db->where('id_menu !=', 1);

        $data['menu'] = $this->Menu_model->getMenu();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');

    }
   
    

    


    public function data_dokter(){
        $data['judul'] = 'Data Dokter';
        $data['user'] = $this->Admin_model->getDokterByNo();
        // $data['dokter'] = $this->Dokter_model->getAllDokter(); udah diambil sama yang bawah get_dokter
        $data['total_dokter'] = $this->Admin_model->total_dokter();

        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/data_dokter');
        $config['total_rows'] = $data['total_dokter'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['dokter'] = $this->Admin_model->get_dokter($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/data_dokter', $data);
        $this->load->view('templates/footer');
    }
    public function data_pasien(){
        $data['judul'] = 'Data Pasien';
        $data['user'] = $this->Admin_model->getDokterByNo();
        
        $data['total_pasien'] = $this->Admin_model->total_pasien();

        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/data_pasien');
        $config['total_rows'] = $data['total_pasien'];
        $config['per_page'] = 10;
        $config['num_links'] = 5;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pasien'] = $this->Admin_model->get_pasien($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/data_pasien', $data);
        $this->load->view('templates/footer');
    }


    public function status_dokter() {
        $no_dokter = $this->input->post('no_dokter');
        $is_active = $this->input->post('is_active');
        $this->Dokter_model->update_status($no_dokter, $is_active);
        echo json_encode(['status' => 'success']);
    }
    public function status_pasien() {
        $no_medis = $this->input->post('no_medis');
        $is_active = $this->input->post('is_active');
        $this->User_model->update_status($no_medis, $is_active);
        echo json_encode(['status' => 'success']);
    }

    
    public function add()
    {
        $this->form_validation->set_rules('role', 'Role', 'required|trim|is_unique[role.role]', [
            'is_unique' => 'This role has already added!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('role_failed', ' already exists!');
            redirect('admin/role');
        } else {
            $this->session->set_flashdata('role_added', ' added!');
            $this->Admin_model->addRole();
            redirect('admin/role');
        }
    }

    public function delete($id)
    {
        $this->Admin_model->deleteRole($id);
        $this->session->set_flashdata('role_flash', ' deleted!');
        redirect('admin/role');
    }
    public function getEditRole()
    {
        echo json_encode($this->Admin_model->getRoleById($this->input->post('id_role')));
    }
    public function editRole()
    {
        $this->form_validation->set_rules('role', 'Role', 'required|trim|is_unique[role.role]', [
            'is_unique' => 'This role has already added!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('role_failed', ' already exists!');
            redirect('admin/role');
        } else {
            $this->session->set_flashdata('role_flash', ' updated!');
            $this->Admin_model->updateRole();
            redirect('admin/role');
        }

    }
    public function changeaccess(){
        $data = [
			'id_role' => $this->input->post('roleId'),
            'id_menu' => $this->input->post('menuId')
		];

		$result = $this->db->get_where('akses', $data);


        if ($result->num_rows() < 1) {
            
            $this->session->set_flashdata('changeaccess', '<div class="alert alert-success" role="alert">Changed Access</div>');
            $this->db->insert('akses', $data);
        } else {
            $this->session->set_flashdata('changeaccess', '<div class="alert alert-danger" role="alert">Delete Access</div>');
            $this->db->delete('akses', $data);
        }
    }
    
}
?>