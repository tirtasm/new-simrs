<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Menu_model');
        $this->load->model('Pasien_model');
        check_login();
    }



    //menu
    public function menumanagement()
    {

        $data['user'] = $this->db->get_where(
            'pegawai',
            ['no_pegawai' => $this->session->userdata['no_pegawai']]
        )->row_array();
        $data['menu'] = $this->Menu_model->getMenu();

        $data['judul'] = 'Menu Management';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/index', $data);
        $this->load->view('templates/footer');

    }

    public function add()
    {
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim|is_unique[menu.menu]');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('menu_failed', ' already exist!');
            redirect('menu/menumanagement');
        } else {
            $this->Menu_model->addMenu();
            $this->session->set_flashdata('menu_added', ' added!');
            redirect('menu/menumanagement');
        }
    }
    public function delete($id)
    {
        $this->Menu_model->deleteMenu($id);
        $this->session->set_flashdata('menu_flash', ' deleted!');
        redirect('menu/menumanagement');
    }
    public function editMenu()
    {
        $this->Menu_model->updateMenu();
        $this->session->set_flashdata('menu_flash', ' updated!');
        redirect('menu/menumanagement');
    }
    public function getEditMenu()
    {
        echo json_encode($this->Menu_model->getMenuById($this->input->post('id_menu')));
        // var_dump(json_encode($this->Menu_model->getMenuById($this->input->post('id_menu'))));
        

    }
    //submenu
    public function getEditSubMenu()
    {
        echo json_encode($this->Menu_model->getSubMenuById($this->input->post('id_sub')));
    }
    public function submenu()
    {
        $data['user'] = $this->db->get_where(
            'pegawai',
            ['no_pegawai' => $this->session->userdata['no_pegawai']]
        )->row_array();
        $data['sub_menu'] = $this->Menu_model->getAllSubmenu();
        $data['menu'] = $this->Menu_model->getMenu();
        $data['judul'] = 'Sub Menu';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/submenu', $data);
        $this->load->view('templates/footer');
    }
    public function addsubmenu()
    {
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required|trim');
        $this->form_validation->set_rules('url', 'URL', 'required|trim|is_unique[sub_menu.url]', [
            'is_unique' => 'This URL has already registered!'
        ]);
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('submenu_failed', ' URL already exist!');
            redirect('menu/submenu');
        } else {
            $this->Menu_model->addSubMenu();
            $this->session->set_flashdata('submenu_added', ' added!');
            redirect('menu/submenu');
        }

    }
    public function deletesubmenu($id)
    {
        $this->Menu_model->deleteSubMenu($id);
        $this->session->set_flashdata('menu_flash', ' deleted!');
        redirect('menu/submenu');
    }
    public function editsubmenu()
    {
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('menu_name', 'Menu Name', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('submenu_failed', ' failed!');
            redirect('menu/submenu');
        } else {
            $this->Menu_model->updateSubMenu();
            $this->session->set_flashdata('menu_flash', ' updated!');
            redirect('menu/submenu');
        }

    }

}
