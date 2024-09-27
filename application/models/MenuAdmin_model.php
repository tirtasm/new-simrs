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

    public function getPasienById($id)
    {
        $this->db->select('pasien.*, rawat_inap.*, ruang.*');
        $this->db->from('pasien');
        $this->db->join('rawat_inap', 'pasien.id_pasien = rawat_inap.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = rawat_inap.id_ruang');
        $this->db->where('pasien.id_pasien', $id);
        return $this->db->get()->row_array();

    }
    //for all data active
    public function get_pasien($limit, $start)
    {
        $this->db->select('pasien.*, rawat_inap.*, ruang.*');
        $this->db->from('pasien');
        $this->db->join('rawat_inap', 'pasien.id_pasien = rawat_inap.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = rawat_inap.id_ruang');
        $this->db->order_by('rawat_inap.tanggal_keluar', 'ASC');
        $this->db->limit($limit, $start);
        $this->db->where('pasien.is_active', 1);
        $this->db->where('pasien.is_inap', 1);
        $this->db->where('rawat_inap.tanggal_keluar IS NULL');
        return $this->db->get()->result_array();

    }

    public function get_pasien_keluar($limit, $start)
    {
        $this->db->select('pasien.*, rawat_inap.*, ruang.*');
        $this->db->from('pasien');
        $this->db->join('rawat_inap', 'pasien.id_pasien = rawat_inap.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = rawat_inap.id_ruang');
        $this->db->order_by('rawat_inap.tanggal_keluar', 'ASC');
        $this->db->limit($limit, $start);
        $this->db->where('pasien.is_active', 1);
        $this->db->where('rawat_inap.tanggal_keluar IS NOT NULL');
        return $this->db->get()->result_array();

    }

    //for data pasien active and not in rawat inap or for modal add pasien 
    public function pasien_not_inap()
    {
        $this->db->select('*');
        $this->db->from('pasien');
        $this->db->where('is_active', 1);
        $this->db->where('is_inap', 0); //$this->db->where('pasien.id_pasien NOT IN (SELECT id_pasien FROM rawat_inap WHERE tanggal_keluar IS NULL)'); pakai ini bisa  
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }
    //for data ruang != 0
    public function get_ruang_all($limit, $start)
    {
        $this->db->limit($limit, $start);
        return $this->db->get('ruang')->result_array();
    }
    public function get_tindakan_all($limit, $start)
    {
        $this->db->limit($limit, $start);
        return $this->db->get('jenis_tindakan')->result_array();
    }
    public function get_ruang()
    {
        $this->db->limit(5);
        $this->db->where('kapasitas >', 0);
        return $this->db->get('ruang')->result_array();
    }
    

    public function total_ruang()
    {
        return $this->db->count_all('ruang');
    }
    public function total_pasien()
    {
        $this->db->from('rawat_inap');
        $this->db->join('pasien', 'pasien.id_pasien = rawat_inap.id_pasien');
        return $this->db->count_all_results();
    }
    public function total_pasien_keluar()
    {
        $this->db->from('rawat_inap');
        $this->db->join('pasien', 'pasien.id_pasien = rawat_inap.id_pasien');
        $this->db->where('rawat_inap.tanggal_keluar IS NOT NULL');
        return $this->db->count_all_results();
    }
    public function total_tindakan()
    {
        return $this->db->count_all('jenis_tindakan');
    }

    public function addPasien()
    {
        $ruang = htmlspecialchars($this->input->post('ruang', true));
        $pasien = htmlspecialchars($this->input->post('pasien', true));
        var_dump($pasien);
        $tanggal_masuk = htmlspecialchars($this->input->post('tanggal_masuk', true));

        //update is_inap = true
        $this->db->set('is_inap', 1);
        $this->db->where('id_pasien', $pasien);
        $this->db->update('pasien');
        //update -1 kapasitas ruang
        $this->db->select('kapasitas');
        $this->db->where('id_ruang', $ruang);
        $ruang_data = $this->db->get('ruang')->row_array();
        if ($ruang_data && isset($ruang_data['kapasitas'])) {
            $kapasitas = $ruang_data['kapasitas'];
            $updated_kapasitas = $kapasitas - 1;
            $this->db->set('kapasitas', $updated_kapasitas);
            $this->db->where('id_ruang', $ruang);
            $this->db->update('ruang');
            $data = [
                'id_pasien' => $pasien,
                'id_ruang' => $ruang,
                'tanggal_masuk' => $tanggal_masuk,
                'tanggal_keluar' => null
            ];
            var_dump($data);
            $this->db->insert('rawat_inap', $data);
        } else {
            echo 'Data kapasitas tidak ditemukan untuk ruang yang dipilih.';
        }
    }
    public function editRuangPasien()
    {
        $ruang_baru = htmlspecialchars($this->input->post('ruang', true));
        $pasien = htmlspecialchars($this->input->post('id_pasien', true));


        $this->db->select('id_ruang');
        $this->db->where('id_pasien', $pasien);
        $ruang_sebelumnya = $this->db->get('rawat_inap')->row_array();

        if ($ruang_sebelumnya) {
            $ruang_lama = $ruang_sebelumnya['id_ruang'];

            if ($ruang_lama === $ruang_baru) {
                $this->session->set_flashdata('errorflash', 'Pasien sudah berada di ruang yang dipilih.');
                return;
            } else {
                $this->session->set_flashdata('pasienflash', 'Pasien berhasil dipindahkan ke ruang lain.');
            }

            $this->db->select('kapasitas');
            $this->db->where('id_ruang', $ruang_lama);
            $ruang_lama_data = $this->db->get('ruang')->row_array();
            if ($ruang_lama_data && isset($ruang_lama_data['kapasitas'])) {
                $kapasitas_ruang_lama = $ruang_lama_data['kapasitas'] + 1;
                // var_dump($kapasitas_ruang_lama);
                $this->db->set('kapasitas', $kapasitas_ruang_lama);
                $this->db->where('id_ruang', $ruang_lama);
                $this->db->update('ruang');
            }
        }
        $this->db->select('kapasitas');
        $this->db->where('id_ruang', $ruang_baru);
        $ruang_baru_data = $this->db->get('ruang')->row_array();

        if ($ruang_baru_data && isset($ruang_baru_data['kapasitas'])) {
            $kapasitas_ruang_baru = $ruang_baru_data['kapasitas'] - 1;
            $this->db->set('kapasitas', $kapasitas_ruang_baru);
            $this->db->where('id_ruang', $ruang_baru);
            $this->db->update('ruang');
            $data = [
                'id_ruang' => $ruang_baru,
                'tanggal_keluar' => null
            ];
            $this->db->where('id_pasien', $pasien);
            $this->db->update('rawat_inap', $data);
        } else {
            echo 'Data kapasitas tidak ditemukan untuk ruang yang dipilih.';
        }

    }
    public function keluar($no_medis)
    {
        $this->db->set('is_inap', 0);
        $this->db->where('id_pasien', $no_medis);
        $this->db->update('pasien');
        $this->db->set('tanggal_keluar', date('Y-m-d'));
        $this->db->where('id_pasien', $no_medis);
        $this->db->update('rawat_inap');
    }
    public function addRuang()
    {
        $nama_ruang = htmlspecialchars($this->input->post('ruang', true));
        $kapasitas = htmlspecialchars($this->input->post('kapasitas', true));
        $data = [
            'nama_ruang' => $nama_ruang,
            'kapasitas' => $kapasitas
        ];
        $this->db->insert('ruang', $data);
    }
    public function hapus($id){
        $id = $this->uri->segment(3);
        $this->db->where('id_ruang', $id);
        $this->db->delete('ruang');
    }
    public function getRuangById($id)
    {
        return $this->db->get_where('ruang', ['id_ruang' => $id])->row_array();
    }
    public function getTindakanById($id)
    {
        return $this->db->get_where('jenis_tindakan', ['id_tindakan' => $id])->row_array();
    }
    public function editRuang(){
        $id = $this->input->post('id_ruang');
        $nama_ruang = $this->input->post('ruang');
        $kapasitas = $this->input->post('kapasitas');
        $data = [
            'nama_ruang' => $nama_ruang,
            'kapasitas' => $kapasitas
        ];
        $this->db->where('id_ruang', $id);
        $this->db->update('ruang', $data);
    }

    public function addTindakan(){
        $nama_tindakan = htmlspecialchars($this->input->post('tindakan', true));
        $biaya = htmlspecialchars($this->input->post('biaya', true));
        $data = [
            'nama_tindakan' => $nama_tindakan,
            'biaya' => $biaya
        ];
        $this->db->insert('jenis_tindakan', $data);
    }
    public function hapusTindakan($id){
        $id = $this->uri->segment(3);
        $this->db->where('id_tindakan', $id);
        $this->db->delete('jenis_tindakan');
    }
    public function editTindakan(){
        $id = $this->input->post('id_tindakan');
        $nama_tindakan = htmlspecialchars($this->input->post('tindakan'));
        $biaya = $this->input->post('biaya');
        $data = [
            'nama_tindakan' => $nama_tindakan,
            'biaya' => $biaya
        ];
        $this->db->where('id_tindakan', $id);
        $this->db->update('jenis_tindakan', $data);
    }
}
?>