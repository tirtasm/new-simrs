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

        $this->db->select('p.id_pasien, p.nama, p.no_telp, ri.tanggal_masuk,r.*');
        $this->db->from('pasien p');
        $this->db->join('rawat_inap ri', 'p.id_pasien = ri.id_pasien');
        $this->db->join('ruang r', 'r.id_ruang = ri.id_ruang');
        $this->db->where('p.id_pasien', $id);
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
        return $this->db->get()->result_array();

    }

    //for data pasien active and not in rawat inap or for modal add pasien 
    public function get_pasien_active()
    {
        // $this->db->select('*');
        // $this->db->from('pasien');
        // $this->db->limit(5);
        // $this->db->where('is_active', 1);
        // // $this->db->join('rawat_inap ri', 'ri.id_pasien = p.id_pasien AND ri.tanggal_keluar IS NULL', 'left');
        // // $this->db->where('ri.id_pasien IS NULL');
        // return $this->db->get()->result_array();

        $this->db->select('p.*, ri.*');
        $this->db->from('pasien p');
        $this->db->limit(5);
        $this->db->where('p.is_active', 1);
        // $this->db->join('rawat_inap ri', 'p.id_pasien = ri.id_pasien');
        $this->db->join('rawat_inap ri', 'ri.id_pasien = p.id_pasien AND ri.tanggal_keluar IS NULL', 'left');
        $this->db->where('ri.id_pasien IS NULL');
        return $this->db->get()->result_array();
    }
    public function get_ruang()
    {
        $this->db->limit(5);
        return $this->db->get('ruang')->result_array();
    }
    public function total_pasien()
    {
        $this->db->from('rawat_inap');
        $this->db->join('pasien', 'pasien.id_pasien = rawat_inap.id_pasien');
        // $this->db->where('rawat_inap.id_ruang IS NOT NULL'); 
        return $this->db->count_all_results();
    }

    public function addPasien()
    {
        $ruang = htmlspecialchars($this->input->post('ruang', true));
        $pasien = htmlspecialchars($this->input->post('pasien', true));
        $tanggal_masuk = htmlspecialchars($this->input->post('tanggal_masuk', true));

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

            if ($ruang_lama !== $ruang_baru) {
                $this->db->select('kapasitas');
                $this->db->where('id_ruang', $ruang_lama);
                $ruang_lama_data = $this->db->get('ruang')->row_array();
                if ($ruang_lama_data && isset($ruang_lama_data['kapasitas'])) {
                    $kapasitas_ruang_lama = $ruang_lama_data['kapasitas'] + 1;
                    var_dump($kapasitas_ruang_lama);
                    $this->db->set('kapasitas', $kapasitas_ruang_lama);
                    $this->db->where('id_ruang', $ruang_lama);
                    $this->db->update('ruang');
                }
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
        $this->db->set('tanggal_keluar', date('Y-m-d'));
        $this->db->where('id_pasien', $no_medis);
        $this->db->update('rawat_inap');
    }


}
?>