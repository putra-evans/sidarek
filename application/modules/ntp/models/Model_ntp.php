<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 *
 * @author Yuda Pramana
 */

class Model_ntp extends CI_Model
{
    protected $_publishDate = "";
    public function __construct()
    {
        parent::__construct();
    }

    public function validasiDataValue()
    {
        $this->form_validation->set_rules('nama_bu', 'Nama Badan Usaha', 'required');

        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    /**
     * Get JenisBU
     */
    public function getJenisBU()
    {
        $query = $this->db->get("ref_jenis_bu");
        $data = [];
        $data[''] = '-- Semua Jenis --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_jenis_bu] = $value->nama;
        }

        return $data;
    }

    /**
     * Get BentukBU
     */
    public function getBentukBU()
    {
        $query = $this->db->get("ref_bentuk_bu");
        $data = [];
        $data[''] = '-- Semua Bentuk --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_bentuk_bu] = $value->nama;
        }

        return $data;
    }

    public function process_datatables($param, $idProfilBU)
    {

        $draw = intval($this->input->get("draw"));

        $dataProduk = $this->_get_datatables($param, $idProfilBU);

        $data = [];
        $index = $_POST['start'] + 1;
        foreach ($dataProduk as $r) {
            $data[] = array(
                'index'                     => $index,
                'id_ntp'                    => $r['id_ntp'],
                'bulan_ntp'                 => $r['bulan_ntp'],
                'ket_ntp'                   => $r['ket_ntp'],

                'id_tp'                             => $r['id_tp'],
                'nilai_tukar_petani_ntpp_a'         => $r['nilai_tukar_petani_ntpp_a'],
                'nilai_tukar_usaha_pertanian_a'     => $r['nilai_tukar_usaha_pertanian_a'],
                'indeks_harga_diterima_petani_a'    => $r['indeks_harga_diterima_petani_a'],
                'padi_a'                            => $r['padi_a'],
                'palawijaya_a'                      => $r['palawijaya_a'],
                'indeks_harga_dibayar_petani_a'     => $r['indeks_harga_dibayar_petani_a'],
                'indeks_konsumsi_rumah_tangga_a'    => $r['indeks_konsumsi_rumah_tangga_a'],
                'indeks_bppbm_a'                    => $r['indeks_bppbm_a'],

                'id_hortikultur'                    => $r['id_hortikultur'],
                'nilai_tukar_petani_ntph_b'         => $r['nilai_tukar_petani_ntph_b'],
                'nilai_tukar_usaha_pertanian_b'     => $r['nilai_tukar_usaha_pertanian_b'],
                'indeks_harga_diterima_petani_b'    => $r['indeks_harga_diterima_petani_b'],
                'sayur_sayuran_b'                   => $r['sayur_sayuran_b'],
                'buah_buahan_b'                     => $r['buah_buahan_b'],
                'tanaman_obat_b'                    => $r['tanaman_obat_b'],
                'indeks_harga_dibayar_petani_b'     => $r['indeks_harga_dibayar_petani_b'],
                'indeks_konsumsi_rumah_tangga_b'    => $r['indeks_konsumsi_rumah_tangga_b'],
                'indeks_bppbm_b'                    => $r['indeks_bppbm_b'],

                'id_perkebunan'                     => $r['id_perkebunan'],
                'nilai_tukar_petani_ntpr_c'         => $r['nilai_tukar_petani_ntpr_c'],
                'nilai_tukar_usaha_pertanian_c'     => $r['nilai_tukar_usaha_pertanian_c'],
                'indeks_harga_diterima_petani_c'    => $r['indeks_harga_diterima_petani_c'],
                'tanaman_perkebunan_rakyat_tpr_c'   => $r['tanaman_perkebunan_rakyat_tpr_c'],
                'indeks_harga_dibayar_petani_c'     => $r['indeks_harga_dibayar_petani_c'],
                'indeks_konsumsi_rumah_tangga_c'    => $r['indeks_konsumsi_rumah_tangga_c'],
                'indeks_bppbm_c'                    => $r['indeks_bppbm_c'],

                'id_peternakan'                     => $r['id_peternakan'],
                'nilai_tukar_petani_ntpt_d'         => $r['nilai_tukar_petani_ntpt_d'],
                'nilai_tukar_usaha_pertanian_d'     => $r['nilai_tukar_usaha_pertanian_d'],
                'indeks_harga_diterima_petani_d'    => $r['indeks_harga_diterima_petani_d'],
                'ternak_besar_d'                    => $r['ternak_besar_d'],
                'ternak_kecil_d'                    => $r['ternak_kecil_d'],
                'unggas_d'                          => $r['unggas_d'],
                'hasil_ternak_d'                    => $r['hasil_ternak_d'],
                'indeks_harga_dibayar_petani_d'     => $r['indeks_harga_dibayar_petani_d'],
                'indeks_konsumsi_rumah_tangga_d'    => $r['indeks_konsumsi_rumah_tangga_d'],
                'indeks_bppbm_d'                    => $r['indeks_bppbm_d'],

                'id_perikanan'                      => $r['id_perikanan'],
                'nilai_tukar_petani_ntnp_e'         => $r['nilai_tukar_petani_ntnp_e'],
                'nilai_tukar_usaha_pertanian_e'     => $r['nilai_tukar_usaha_pertanian_e'],
                'indeks_harga_diterima_petani_e'    => $r['indeks_harga_diterima_petani_e'],
                'tangkap_e'                         => $r['tangkap_e'],
                'budidaya_e'                        => $r['budidaya_e'],
                'indeks_harga_dibayar_petani_e'     => $r['indeks_harga_dibayar_petani_e'],
                'indeks_konsumsi_rumah_tangga_e'    => $r['indeks_konsumsi_rumah_tangga_e'],
                'indeks_bppbm_e'                    => $r['indeks_bppbm_e'],

                'id_tangkap'                        => $r['id_tangkap'],
                'nilai_tukar_petani_ntn_f'          => $r['nilai_tukar_petani_ntn_f'],
                'nilai_tukar_usaha_pertanian_f'     => $r['nilai_tukar_usaha_pertanian_f'],
                'indeks_harga_diterima_petani_f'    => $r['indeks_harga_diterima_petani_f'],
                'penangkapan_perairan_umum_f'       => $r['penangkapan_perairan_umum_f'],
                'penangkapan_laut_f'                => $r['penangkapan_laut_f'],
                'indeks_harga_dibayar_petani_f'     => $r['indeks_harga_dibayar_petani_f'],
                'indeks_konsumsi_rumah_tangga_f'    => $r['indeks_konsumsi_rumah_tangga_f'],
                'indeks_bppbm_f'                    => $r['indeks_bppbm_f'],

                'id_budidaya'                       => $r['id_budidaya'],
                'nilai_tukar_petani_ntpi_g'         => $r['nilai_tukar_petani_ntpi_g'],
                'nilai_tukar_usaha_pertanian_g'     => $r['nilai_tukar_usaha_pertanian_g'],
                'indeks_harga_diterima_petani_g'    => $r['indeks_harga_diterima_petani_g'],
                'budidaya_air_tawar_g'              => $r['budidaya_air_tawar_g'],
                'budidaya_laut_g'                   => $r['budidaya_laut_g'],
                'indeks_harga_dibayar_petani_g'     => $r['indeks_harga_dibayar_petani_g'],
                'indeks_konsumsi_rumah_tangga_g'    => $r['indeks_konsumsi_rumah_tangga_g'],
                'indeks_bppbm_g'                    => $r['indeks_bppbm_g'],

                'action'                        => '<button type="button" class="btn btn-xs btn-primary btnView" data-id="' . $this->encryption->encrypt($r['id_ntp']) . '" title="View data"><i class="fa fa-search"></i> </button>
											        <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_ntp']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

            );
            $index++;
        }

        $result = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->count_all_results('ta_modal_pertahun'),
            "recordsFiltered" => $this->count_filtered($param, $idProfilBU),
            "data" => $data
        );

        return $result;
    }

    public function _get_datatables($param, $idProfilBU)
    {
        $this->_get_datatables_query($param, $idProfilBU);

        // Dont know
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filtered($param, $idProfilBU)
    {

        $this->_get_datatables_query($param, $idProfilBU);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function _get_datatables_query($param, $idProfilBU)
    {

        $post = array();
        if (is_array($param)) {
            foreach ($param as $v) {
                $post[$v['name']] = $v['value'];
            }
        }

        // Query Filter
        $this->db->select(" 
                *
        ");
        $this->db->from('ta_ntp a');

        $this->db->join('ta_ntp_tp b', 'b.id_ntp = a.id_ntp', 'left');
        $this->db->join('ta_ntp_hortikultur c', 'c.id_ntp = a.id_ntp', 'left');
        $this->db->join('ta_ntp_perkebunan d', 'd.id_ntp = a.id_ntp', 'left');
        $this->db->join('ta_ntp_peternakan e', 'e.id_ntp = a.id_ntp', 'left');
        $this->db->join('ta_ntp_perikanan f', 'f.id_ntp = a.id_ntp', 'left');
        $this->db->join('ta_ntp_perikanan_tangkap g', 'g.id_ntp = a.id_ntp', 'left');
        $this->db->join('ta_ntp_perikanan_budidaya h', 'h.id_ntp = a.id_ntp', 'left');


        // if ($idProfilBU) {
        //     $this->db->where('profil.`id_profil_bu`', $idProfilBU);
        // }

        // if (isset($post['id_profil_bu_filter']) and $post['id_profil_bu_filter'] != '') {
        //     $this->db->where('profil.id_profil_bu', $post['id_profil_bu_filter']);
        // }

        // if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
        //     $this->db->where('tahun.tahun', $post['tahun_filter']);
        // }

        $column_search = array('a.bulan_ntp');

        $i = 0;

        foreach ($column_search as $item) { // loop column
            if (isset($_POST['search']['value'])) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($column_search) - 1 == $i) { //last loop
                    $this->db->group_end();
                } //close bracket
            }
            $i++;
        }
        // End of Query Filter
    }

    public function getDataListBUReport($profil, $tahun)
    {
        $this->db->select("
                            tahun.`id_modal_pertahun`,
                            tahun.`penyertaan_modal`,
                            tahun.`dividen`,
                            profil.`id_profil_bu`,
                            profil.`nama` as 'nama_badan_usaha',
                                profil.`nama` as 'badan_usaha', 
                            tahun.`tahun`, 
                            aset.`id_bu_aset`, 
                                aset.`lancar` as 'aset_lancar', 
                                aset.`tidak_lancar` as 'aset_tidak_lancar',
                                aset.`total` as 'aset_total', 
                            liabilitas.`id_bu_liabilitas`, 
                                liabilitas.`jangka_panjang` as 'liabilitas_jangka_panjang', 
                                liabilitas.`jangka_pendek` as 'liabilitas_jangka_pendek',
                                liabilitas.`total` as 'liabilitas_total', 
                            ekuitas.`id_bu_ekuitas`, 
                                ekuitas.`total` as 'ekuitas_total',
                            pendapatan.`id_bu_pendapatan`, 
                                pendapatan.`pendapatan_usaha`, 
                                pendapatan.`harga_pokok_pendapatan`, 
                            labarugi.`id_bu_laba_rugi`, 
                                labarugi.`laba_rugi_pajak`, 
                                labarugi.`taksiran_pajak`, 
                                labarugi.`laba_rugi_nopajak`
					");
        $this->db->from('ta_modal_pertahun tahun');

        $this->db->join('ma_profil_bu profil', 'profil.id_profil_bu = tahun.id_profil_bu');
        $this->db->join('ta_bu_aset aset', 'aset.id_modal_pertahun = tahun.id_modal_pertahun', 'left');
        $this->db->join('ta_bu_liabilitas liabilitas', 'liabilitas.id_modal_pertahun = tahun.id_modal_pertahun', 'left');
        $this->db->join('ta_bu_ekuitas ekuitas', 'ekuitas.id_modal_pertahun = tahun.id_modal_pertahun', 'left');
        $this->db->join('ta_bu_pendapatan pendapatan', 'pendapatan.id_modal_pertahun = tahun.id_modal_pertahun', 'left');
        $this->db->join('ta_bu_laba_rugi labarugi', 'labarugi.id_modal_pertahun = tahun.id_modal_pertahun', 'left');

        if ($profil != '')
            $this->db->where('profil.id_profil_bu', $profil);
        if ($tahun != '')
            $this->db->where('tahun.tahun', $tahun);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_data_profil()
    {
        $result = [
            'status' => false,
            'success' => 'NOPE',
            'message' => null,
            'info' => null
        ];

        try {

            $data = array(
                'id_bentuk_bu'                  => $this->input->post('id_bentuk_bu'),
                'id_jenis_bu'                   => $this->input->post('id_jenis_bu'),
                'nama'                          => $this->input->post('nama_bu'),
                'alamat'                        => $this->input->post('alamat'),
                'no_telp'                       => $this->input->post('no_telp'),
                'email'                         => $this->input->post('email'),
                'tahun_berdiri'                 => $this->input->post('tahun_berdiri'),
                'persen_kepemilikan'            => $this->input->post('persen_kepemilikan'),
                'bidang_usaha'                  => $this->input->post('bidang_usaha'),
                'nomor_perda_pendirian'         => $this->input->post('nomor_perda_pendirian'),
                'modal_dasar'                   => $this->input->post('modal_dasar'),
                'jumlah_komisaris'              => $this->input->post('jumlah_komisaris'),
                'jumlah_direksi'                => $this->input->post('jumlah_direksi'),
                'keterangan'                    => $this->input->post('keterangan'),
            );

            $this->db->insert('ma_profil_bu', $data);

            $result['success'] = 'YEAH';
            $result['status'] = true;
            $result['message'] = 'Data Profil Badan Usaha Berhasil Disimpan';
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function update_data_profil()
    {

        $result = [
            'status' => false,
            'success' => 'NOPE',
            'message' => null,
            'info' => null
        ];

        try {

            $idProfilBU = $this->input->post('id_profil_bu');

            $profil   = $this->db->where('id_profil_bu', $idProfilBU);

            if ($profil) {

                $data = array(
                    'id_bentuk_bu'                  => $this->input->post('id_bentuk_bu'),
                    'id_jenis_bu'                   => $this->input->post('id_jenis_bu'),
                    'nama'                          => $this->input->post('nama_bu'),
                    'alamat'                        => $this->input->post('alamat'),
                    'no_telp'                       => $this->input->post('no_telp'),
                    'email'                         => $this->input->post('email'),
                    'tahun_berdiri'                 => $this->input->post('tahun_berdiri'),
                    'persen_kepemilikan'            => $this->input->post('persen_kepemilikan'),
                    'bidang_usaha'                  => $this->input->post('bidang_usaha'),
                    'nomor_perda_pendirian'         => $this->input->post('nomor_perda_pendirian'),
                    'modal_dasar'                   => $this->input->post('modal_dasar'),
                    'jumlah_komisaris'              => $this->input->post('jumlah_komisaris'),
                    'jumlah_direksi'                => $this->input->post('jumlah_direksi'),
                    'keterangan'                    => $this->input->post('keterangan'),
                );

                $this->db->update('ma_profil_bu', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data Produksi SDA Berhasil diupdate';
            }
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function delete_data_profil()
    {
        $profilID     = $this->encryption->decrypt($this->input->post('id_profil_bu', true));

        /*query delete*/
        $this->db->where('id_profil_bu', $profilID);
        $this->db->delete('ma_profil_bu');

        return array('message' => 'SUCCESS');
    }
}
