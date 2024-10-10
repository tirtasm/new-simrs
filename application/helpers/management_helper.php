<?php  
    function check_login(){
        $ci = get_instance();        
    if(!$ci->session->userdata('no_dokter') && !$ci->session->userdata('no_medis')){
            redirect('auth/login');
        }else{
            $role_id = $ci->session->userdata('id_role');
            $menu = $ci->uri->segment(1);   
            $queryMenu = $ci->db->get_where('menu', ['menu' => $menu])->row_array();
            $menu_id = $queryMenu['id_menu'];
            
            
            $userAccess = $ci->db->get_where('akses', ['id_role' => $role_id, 'id_menu' => $menu_id]);
            // echo json_encode($userAccess);
            
            if($userAccess->num_rows() < 1){
                echo "Access Denied!";
                redirect('auth/blocked');
            }
        }
    }
     function check_access($role, $menu_id){
         $ci = get_instance();
         $ci->db->where('id_role', $role);
         $ci->db->where('id_menu', $menu_id);
         $result = $ci->db->get('akses');
         if($result->num_rows() > 0){
             return "checked='checked'";
        }
     }
?>