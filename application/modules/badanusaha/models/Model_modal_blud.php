<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 *
 * @author Yuda Pramana
 */

class Model_modal_blud extends CI_Model
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
                'index'                         => $index,
                'id_profil_bu'                  => $r['id_profil_bu'],
                'id_modal_pertahun'             => $r['id_modal_pertahun'],
                'nama_badan_usaha'              => $r['nama_badan_usaha'],

                'badan_usaha'                   => $r['badan_usaha'],
                'tahun'                         => $r['tahun'],
                'penyertaan_modal'              => $r['penyertaan_modal'],
                'dividen'                       => $r['dividen'],

                'id_bu_aset'                    => $r['id_bu_aset'],
                'aset_lancar'                   => $r['aset_lancar'],
                'aset_tidak_lancar'             => $r['aset_tidak_lancar'],
                'aset_total'                    => $r['aset_total'],

                'id_bu_liabilitas'              => $r['id_bu_liabilitas'],
                'liabilitas_jangka_panjang'     => $r['liabilitas_jangka_panjang'],
                'liabilitas_jangka_pendek'      => $r['liabilitas_jangka_pendek'],
                'liabilitas_total'              => $r['liabilitas_total'],

                'id_bu_ekuitas'                 => $r['id_bu_ekuitas'],
                'ekuitas_total'                 => $r['ekuitas_total'],

                'id_bu_pendapatan'              => $r['id_bu_pendapatan'],
                'pendapatan_usaha'              => $r['pendapatan_usaha'],
                'harga_pokok_pendapatan'        => $r['harga_pokok_pendapatan'],

                'id_bu_laba_rugi'               => $r['id_bu_laba_rugi'],
                'laba_rugi_pajak'               => $r['laba_rugi_pajak'],
                'taksiran_pajak'                => $r['taksiran_pajak'],
                'laba_rugi_nopajak'             => $r['laba_rugi_nopajak'],

                'action'                        => '<button type="button" class="btn btn-xs btn-primary btnView" data-id="' . $this->encryption->encrypt($r['id_profil_bu']) . '" title="View data"><i class="fa fa-search"></i> </button>
											        <button type="button" class="btn btn-xs btn-danger btnDelete" data-idmodalpertahun="' . $this->encryption->encrypt($r['id_modal_pertahun']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

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
        $this->db->where('profil.id_jenis_bu', '2');

        if ($idProfilBU) {
            $this->db->where('profil.`id_profil_bu`', $idProfilBU);
        }

        if (isset($post['id_profil_bu_filter']) and $post['id_profil_bu_filter'] != '') {
            $this->db->where('profil.id_profil_bu', $post['id_profil_bu_filter']);
        }

        if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
            $this->db->where('tahun.tahun', $post['tahun_filter']);
        }

        $column_search = array('profil.nama');

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
