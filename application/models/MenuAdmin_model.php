<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MenuAdmin_model extends CI_Model
{

    public function getDokterByNo()
    {
        return $this->db->get_where(
            'pegawai',
            ['no_pegawai' => $this->session->userdata['no_pegawai']],
        )->row_array();
    }

    public function getPasienById($id)
    {
        $this->db->select('pasien.*, pelayanan.*, ruang.*');
        $this->db->from('pasien');
        $this->db->join('pelayanan', 'pasien.id_pasien = pelayanan.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = pelayanan.id_ruang');
        $this->db->where('pasien.id_pasien', $id);
        return $this->db->get()->row_array();

    }
    //for all data active
    public function get_pasien($limit, $start, $search = null)
    {
        $this->db->select('pasien.*, pelayanan.*, ruang.*, ruang_igd.*');
        $this->db->from('pasien');
        $this->db->join('pelayanan', 'pasien.id_pasien = pelayanan.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = pelayanan.id_ruang', 'left');
        $this->db->join('ruang_igd', 'ruang_igd.id_ruang_igd = pelayanan.id_ruang_igd', 'left');
        $this->db->order_by('pelayanan.tanggal_keluar', 'ASC');
        $this->db->limit($limit, $start);
        $this->db->where('pasien.is_active', 1);
        $this->db->where('pasien.is_inap', 1);
        $this->db->where('pelayanan.tanggal_keluar IS NULL');

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

    public function get_pasien_keluar($limit, $start, $search = null)
    {
        $this->db->select('pasien.*, pelayanan.*, ruang.*, ruang_igd.*');
        $this->db->from('pasien');
        $this->db->join('pelayanan', 'pasien.id_pasien = pelayanan.id_pasien');
        $this->db->join('ruang', 'ruang.id_ruang = pelayanan.id_ruang', 'left');
        $this->db->join('ruang_igd', 'ruang_igd.id_ruang_igd = pelayanan.id_ruang_igd', 'left');
        $this->db->order_by('pelayanan.tanggal_keluar', 'ASC');
        $this->db->limit($limit, $start);
        $this->db->where('pasien.is_active', 1);
        $this->db->where('pelayanan.tanggal_keluar IS NOT NULL');

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

    //for data pasien active and not in rawat inap or for modal add pasien 
    public function pasien_not_inap()
    {
        $this->db->select('*');
        $this->db->from('pasien');
        $this->db->where('is_active', 1);
        $this->db->where('is_inap', 0); //$this->db->where('pasien.id_pasien NOT IN (SELECT id_pasien FROM pelayanan WHERE tanggal_keluar IS NULL)'); pakai ini bisa  
        $this->db->limit(10);
        return $this->db->get()->result_array();
    }
    //for data ruang != 0
    public function get_ruang_all($limit, $start, $search = null)
    {
        $this->db->limit($limit, $start);
        if (!empty($search)) {
            $this->db->like('nama_ruang', $search);
        }
        return $this->db->get('ruang')->result_array();
    }
    public function get_ruang_idg_all($limit, $start, $search = null)
    {
        $this->db->limit($limit, $start);
        if (!empty($search)) {
            $this->db->like('nama_ruang_igd', $search);
        }
        return $this->db->get('ruang_igd')->result_array();
    }
    public function get_tindakan_all($limit, $start, $search = null)
    {
        $this->db->limit($limit, $start);
        if (!empty($search)) {
            $this->db->like('nama_tindakan', $search);
        }
        return $this->db->get('jenis_tindakan')->result_array();
    }
    public function get_ruang()
    {
        $this->db->limit(5);
        $this->db->where('kapasitas >', 0);
        return $this->db->get('ruang')->result_array();
    }
    public function get_ruang_igd()
    {
        $this->db->limit(5);
        $this->db->where('kapasitas >', 0);
        return $this->db->get('ruang_igd')->result_array();
    }
    public function get_jenis_pelayanan()
    {
        return $this->db->get('jenis_pelayanan')->result_array();
    }


    public function total_ruang()
    {
        return $this->db->count_all('ruang');
    }
    public function total_ruang_igd()
    {
        return $this->db->count_all('ruang_igd');
    }
    public function total_pasien()
    {
        $this->db->from('pelayanan');
        $this->db->join('pasien', 'pasien.id_pasien = pelayanan.id_pasien');
        return $this->db->count_all_results();
    }
    public function total_pasien_keluar()
    {
        $this->db->from('pelayanan');
        $this->db->join('pasien', 'pasien.id_pasien = pelayanan.id_pasien');
        $this->db->where('pelayanan.tanggal_keluar IS NOT NULL');
        return $this->db->count_all_results();
    }
    public function total_tindakan()
    {
        return $this->db->count_all('jenis_tindakan');
    }

    public function addPasien()
{
  
    $jenis_pelayanan = htmlspecialchars($this->input->post('jenis_pelayanan', true));
    $pasien = htmlspecialchars($this->input->post('pasien', true));
    $tanggal_masuk = htmlspecialchars($this->input->post('tanggal_masuk', true));
    $id_jenis_pelayanan = htmlspecialchars($this->input->post('jenis_pelayanan', true));

   
    if ($jenis_pelayanan == 1) { 
        $ruang_igd = htmlspecialchars($this->input->post('ruang_igd', true));
        $ruang = null; 
    } elseif ($jenis_pelayanan == 2) { 
        $ruang = htmlspecialchars($this->input->post('ruang', true));
        $ruang_igd = null; 
    } else {
      
        echo 'Jenis pelayanan tidak valid.';
        return;
    }

   
    $this->db->set('is_inap', 1);
    $this->db->where('id_pasien', $pasien);
    $this->db->update('pasien');

   
    if (!empty($ruang)) {
        $this->db->select('kapasitas');
        $this->db->where('id_ruang', $ruang);
        $ruang_data = $this->db->get('ruang')->row_array();

        if ($ruang_data && isset($ruang_data['kapasitas'])) {
            $kapasitas = $ruang_data['kapasitas'];
            if ($kapasitas > 0) {
                $updated_kapasitas = $kapasitas - 1;
                $this->db->set('kapasitas', $updated_kapasitas);
                $this->db->where('id_ruang', $ruang);
                $this->db->update('ruang');
            }
        }
    } elseif (!empty($ruang_igd)) {
        $this->db->select('kapasitas');
        $this->db->where('id_ruang', $ruang_igd);
        $ruang_igd_data = $this->db->get('ruang')->row_array();

        if ($ruang_igd_data && isset($ruang_igd_data['kapasitas'])) {
            $kapasitas_igd = $ruang_igd_data['kapasitas'];
            if ($kapasitas_igd > 0) {
                $updated_kapasitas_igd = $kapasitas_igd - 1;
                $this->db->set('kapasitas', $updated_kapasitas_igd);
                $this->db->where('id_ruang', $ruang_igd);
                $this->db->update('ruang');
            }
        }
    }
    $data = [
        'id_pasien' => $pasien,
        'id_ruang' => $ruang, 
        'id_ruang_igd' => $ruang_igd, 
        'tanggal_masuk' => $tanggal_masuk,
        'tanggal_keluar' => null,
        'id_jenis_pelayanan' => $id_jenis_pelayanan
    ];
    $this->db->insert('pelayanan', $data);
}




    public function editRuangPasien()
    {
        $ruang_baru = htmlspecialchars($this->input->post('ruang', true));
        $pasien = htmlspecialchars($this->input->post('id_pasien', true));


        $this->db->select('id_ruang');
        $this->db->where('id_pasien', $pasien);
        $ruang_sebelumnya = $this->db->get('pelayanan')->row_array();

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
            $this->db->update('pelayanan', $data);
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
        $this->db->update('pelayanan');
    }
    public function add_ruang()
    {
        $nama_ruang = htmlspecialchars($this->input->post('ruang', true));
        $kapasitas = htmlspecialchars($this->input->post('kapasitas', true));
        $data = [
            'nama_ruang' => $nama_ruang,
            'kapasitas' => $kapasitas
        ];
        $this->db->insert('ruang', $data);
    }
    public function add_ruang_igd()
    {
        $nama_ruang = htmlspecialchars($this->input->post('ruang_igd', true));
        $kapasitas = htmlspecialchars($this->input->post('kapasitas', true));
        $data = [
            'nama_ruang_igd' => $nama_ruang,
            'kapasitas' => $kapasitas
        ];
        $this->db->insert('ruang_igd', $data);
    }
    public function hapus_ruang($id)
    {
        $id = $this->uri->segment(3);
        $this->db->where('id_ruang', $id);
        $this->db->delete('ruang');
    }
    public function hapus_ruang_igd($id)
    {
        $id = $this->uri->segment(3);
        $this->db->where('id_ruang_igd', $id);
        $this->db->delete('ruang_igd');
    }
    public function getRuangById($id)
    {
        return $this->db->get_where('ruang', ['id_ruang' => $id])->row_array();
    }
    public function getRuangIGDById($id)
    {
        return $this->db->get_where('ruang_igd', ['id_ruang_igd' => $id])->row_array();
    }
    public function getTindakanById($id)
    {
        return $this->db->get_where('jenis_tindakan', ['id_tindakan' => $id])->row_array();
    }
    public function edit_ruang()
    {
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
    public function edit_ruang_igd()
    {
        $id = $this->input->post('id_ruang_igd');
        $nama_ruang = $this->input->post('ruang_igd');
        $kapasitas = $this->input->post('kapasitas');
        $data = [
            'nama_ruang_igd' => $nama_ruang,
            'kapasitas' => $kapasitas
        ];
        $this->db->where('id_ruang_igd', $id);
        $this->db->update('ruang_igd', $data);
    }

    public function addTindakan()
    {
        $nama_tindakan = htmlspecialchars($this->input->post('tindakan', true));
        $biaya = htmlspecialchars($this->input->post('biaya', true));
        $data = [
            'nama_tindakan' => $nama_tindakan,
            'biaya' => $biaya
        ];
        $this->db->insert('jenis_tindakan', $data);
    }
    public function hapusTindakan($id)
    {
        $id = $this->uri->segment(3);
        $this->db->where('id_tindakan', $id);
        $this->db->delete('jenis_tindakan');
    }
    public function editTindakan()
    {
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