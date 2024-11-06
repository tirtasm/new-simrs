<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{


    public function getDokterByNo()
    {
        return $this->db->get_where(
            'pegawai',
            ['no_pegawai' => $this->session->userdata['no_pegawai']],
        )->row_array();
    }
    public function get_pasien($limit, $start, $search = null) {
        $this->db->select('pasien.*, pelayanan.*, ruang.nama_ruang, ruang_igd.nama_ruang_igd');
        $this->db->from('pasien');
        $this->db->join('pelayanan', 'pasien.id_pasien = pelayanan.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = pelayanan.id_ruang', 'left');
        $this->db->join('ruang_igd', 'ruang_igd.id_ruang_igd = pelayanan.id_ruang_igd' , 'left');
        // $this->db->order_by('pelayanan.tanggal_masuk', 'DESC');
        // $this->db->limit($limit, $start);
        $this->db->where('pasien.is_active', 1);
        $this->db->where('pelayanan.tanggal_keluar', NULL);
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('pasien.no_medis', $search);
            $this->db->or_like('ruang.nama_ruang', $search);
            $this->db->or_like('pasien.no_telp', $search);
            $this->db->group_end();
        }
    
        return $this->db->get()->result_array();
    }
    
    public function total_pasien($search = null) {
        $this->db->from('pasien');
        $this->db->join('pelayanan', 'pasien.id_pasien = pelayanan.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = pelayanan.id_ruang');
        $this->db->where('pasien.is_active', 1);
        $this->db->where('pelayanan.tanggal_keluar', NULL);
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('pasien.no_medis', $search);
            $this->db->or_like('ruang.nama_ruang', $search);
            $this->db->or_like('pasien.no_telp', $search);
            $this->db->group_end();
        }
    
        return $this->db->count_all_results();
    }
    public function update()
    {
        $data = [
            'nama' => htmlspecialchars($this->input->post('nama')),
            'no_telp' => htmlspecialchars($this->input->post('no_telp')),
            'spesialisasi' => htmlspecialchars($this->input->post('spesialisasi'))
        ];
        $this->db->where('no_pegawai', $this->input->post('no_pegawai'));
        $this->db->update('pegawai', $data);
    }
    public function update_status($no_pegawai, $is_active)
    {
        $this->db->where('no_pegawai', $no_pegawai);
        $this->db->update('pegawai', ['is_active' => $is_active]);
    }
    public function delete($id)
    {
        $this->db->delete('pegawai', ['no_pegawai' => $id]);
        redirect('admin/data_dokter');
    }

    public function visite_pasien($limit, $start, $search = null)
    {
        $no_pegawai = $this->session->userdata('no_pegawai');
        $this->db->select('visite.*, pasien.*, pegawai.nama_pegawai, ruang.nama_ruang, ruang_igd.nama_ruang_igd');
        $this->db->from('visite');
        $this->db->join('pasien', 'pasien.id_pasien = visite.id_pasien');
        $this->db->join('pegawai', 'pegawai.no_pegawai = visite.no_pegawai');
        $this->db->join('ruang', 'ruang.id_ruang = visite.id_ruang', 'left');
        $this->db->join('ruang_igd', 'ruang_igd.id_ruang_igd = visite.id_ruang_igd', 'left');
        $this->db->order_by('visite.tanggal_visite', 'DESC');
        $this->db->where('visite.no_pegawai', $no_pegawai);
        $this->db->limit($limit, $start);
        
        if(!empty($search)){
            $this->db->group_start();
            $this->db->like('pasien.nama', $search);
            $this->db->or_like('pasien.no_medis', $search);
            $this->db->or_like('ruang.nama_ruang', $search);
            $this->db->or_like('ruang_igd.nama_ruang_igd', $search);
            $this->db->or_like('visite.tanggal_visite', $search);
            $this->db->group_end();
        }
        return $this->db->get()->result_array();
    }
    public function getVisiteById($id)
    {
      

        $this->db->select('visite.*, pasien.*, ruang.*, pegawai.nama_pegawai, ruang_igd.*');
        $this->db->from('visite');
        $this->db->join('pasien', 'pasien.id_pasien = visite.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = visite.id_ruang', 'left');
        $this->db->join('ruang_igd', 'ruang_igd.id_ruang_igd = visite.id_ruang_igd', 'left');
        $this->db->join('pegawai', 'pegawai.no_pegawai = visite.no_pegawai');
        $this->db->where('visite.id_visite', $id);
        $this->db->order_by('visite.tanggal_visite', 'DESC');

        return $this->db->get()->row_array();
    }
    public function getTindakanPasienById($id)
    {
        $this->db->select('t.*, pegawai.*, pasien.*, pl.*, r.*, jt.*, r_igd.*');
        $this->db->from('tindakan_pasien t');
        $this->db->join('pasien', 'pasien.id_pasien = t.id_pasien');
        $this->db->join('pelayanan pl', 'pl.id_pelayanan = t.id_pelayanan');
        $this->db->join('ruang r', 'r.id_ruang = pl.id_ruang', 'left');
        $this->db->join('ruang_igd r_igd', 'r_igd.id_ruang_igd = pl.id_ruang_igd', 'left');
        $this->db->join('pegawai', 'pegawai.no_pegawai = t.no_pegawai');
        $this->db->join('jenis_tindakan jt', 'jt.id_tindakan = t.id_tindakan');
        $this->db->order_by('t.tanggal_tindakan', 'DESC');
        $this->db->where('t.id_tindakan_pasien', $id);
        return $this->db->get()->result_array();
    }
    public function addVisite()
    {   
        $ruang = htmlspecialchars($this->input->post('id_ruang'));
        $ruang = $ruang ? $ruang : null;
        
        $ruang_igd = htmlspecialchars($this->input->post('id_ruang_igd'));
        $ruang_igd = $ruang_igd ? $ruang_igd : null;
        
        $data = [
            'id_pasien' => htmlspecialchars($this->input->post('nama_pasien')),
            'no_pegawai' => htmlspecialchars($this->input->post('no_pegawai')),
            'id_ruang' => $ruang,
            'id_ruang_igd' => $ruang_igd,
            'tanggal_visite' => htmlspecialchars($this->input->post('tanggal_visite')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        
        $this->db->insert('visite', $data);
        
    }

    public function editVisite()
    {   
        $ruang = htmlspecialchars($this->input->post('id_ruang'));
        $ruang = $ruang ? $ruang : null;
        
        $ruang_igd = htmlspecialchars($this->input->post('id_ruang_igd'));
        $ruang_igd = $ruang_igd ? $ruang_igd : null;
        
        $data = [
            'id_pasien' => htmlspecialchars($this->input->post('nama_pasien')),
            'no_pegawai' => htmlspecialchars($this->input->post('no_pegawai')),
            'id_ruang' => $ruang,
            'id_ruang_igd' => $ruang_igd,
            'tanggal_visite' => htmlspecialchars($this->input->post('tanggal_visite')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        
        $this->db->where('id_visite', $this->input->post('id_visite'));
        $this->db->update('visite', $data);
    }

    public function deleteVisite($id)
    {
        $this->db->delete('visite', ['id_visite' => $id]);
    }

   public function v_tindakan($limit, $start, $search = null)
{
    $no_pegawai = $this->session->userdata('no_pegawai'); 
    $this->db->select('t.*, pegawai.nama_pegawai, pasien.nama, pl.id_ruang, r.*, jt.*, r_igd.*');
    $this->db->from('tindakan_pasien t');
    $this->db->join('pasien', 'pasien.id_pasien = t.id_pasien');
    $this->db->join('pelayanan pl', 'pl.id_pelayanan = t.id_pelayanan');
    $this->db->join('ruang r', 'r.id_ruang = pl.id_ruang', 'left');
    $this->db->join('ruang_igd r_igd', 'r_igd.id_ruang_igd = pl.id_ruang_igd', 'left');
    $this->db->join('pegawai', 'pegawai.no_pegawai = t.no_pegawai');
    $this->db->join('jenis_tindakan jt', 'jt.id_tindakan = t.id_tindakan');
    $this->db->where('t.no_pegawai', $no_pegawai);
    $this->db->order_by('t.tanggal_tindakan', 'DESC');
    $this->db->limit($limit, $start);
    if(!empty($search)){
        $this->db->group_start();
        $this->db->like('pasien.nama', $search);
        $this->db->or_like('r.nama_ruang', $search);
        $this->db->or_like('t.tanggal_tindakan', $search);
        $this->db->or_like('jt.nama_tindakan', $search);
        $this->db->group_end();
    }
    return $this->db->get()->result_array();
}

    
    public function addTindakan()
    {
        $data = [
            'id_pasien' => htmlspecialchars($this->input->post('nama_pasien')),
            'no_pegawai' => htmlspecialchars($this->input->post('no_pegawai')),
            'id_pelayanan' => htmlspecialchars($this->input->post('id_pelayanan')),
            'id_tindakan' => htmlspecialchars($this->input->post('id_tindakan')),
            'tanggal_tindakan' => htmlspecialchars($this->input->post('tanggal_tindakan')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        $this->db->insert('tindakan_pasien', $data);
    }
    public function deleteTindakan($id)
    {
        $this->db->delete('tindakan_pasien', ['id_tindakan_pasien' => $id]);
    }
    public function editTindakanDokter(){
        $data = [
            'id_pasien' => htmlspecialchars($this->input->post('nama_pasien')),
            'no_pegawai' => htmlspecialchars($this->input->post('no_pegawai')),
            'id_pelayanan' => htmlspecialchars($this->input->post('id_pelayanan')),
            'id_tindakan' => htmlspecialchars($this->input->post('id_tindakan')),
            'tanggal_tindakan' => htmlspecialchars($this->input->post('tanggal_tindakan')),
            'catatan' => htmlspecialchars($this->input->post('catatan'))
        ];
        $this->db->where('id_tindakan_pasien', $this->input->post('id_tindakan_pasien'));
        $this->db->update('tindakan_pasien', $data);
        
    }


    public function catatan_dokter($limit,$start,$search = null){
        $this->db->select('t.*, pegawai.nama_pegawai, pasien.nama, pl.id_ruang, r.nama_ruang, jt.nama_tindakan');
        $this->db->from('tindakan_pasien t');
        $this->db->join('pasien', 'pasien.id_pasien = t.id_pasien');
        $this->db->join('pelayanan pl', 'pl.id_pelayanan = t.id_pelayanan');
        $this->db->join('ruang r', 'r.id_ruang = pl.id_ruang');
        $this->db->join('pegawai', 'pegawai.no_pegawai = t.no_pegawai');
        $this->db->join('jenis_tindakan jt', 'jt.id_tindakan = t.id_tindakan');
        $this->db->order_by('t.tanggal_tindakan', 'DESC');
        $this->db->limit($limit, $start);
        if(!empty($search)){
            $this->db->group_start();
            $this->db->like('pegawai.nama_pegawai', $search);
            $this->db->or_like('pasien.nama', $search);
            $this->db->or_like('r.nama_ruang', $search);
            $this->db->or_like('jt.nama_tindakan', $search);
            $this->db->group_end();
        }
        return $this->db->get()->result_array();
    }
}
?>