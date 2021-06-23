<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 *
 * @author Yuda Pramana
 */

class Model_profil_blud extends CI_Model
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
        $this->db->from('ref_jenis_bu');
        $this->db->where('id_jenis_bu', 2);
        $query = $this->db->get();

        // $query = $this->db->get("ref_jenis_bu");
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

    public function process_datatables($param)
    {

        $draw = intval($this->input->get("draw"));

        $dataProduk = $this->_get_datatables($param);

        $data = [];
        $index = $_POST['start'] + 1;
        foreach ($dataProduk as $r) {
            $data[] = array(
                'index'                         => $index,
                'id_profil_bu'                  => $r['id_profil_bu'],
                'id_profil_bu_encrypted'        => $this->encryption->encrypt($r['id_profil_bu']),
                'id_bentuk_bu'                  => $r['id_bentuk_bu'],
                'id_jenis_bu'                   => $r['id_jenis_bu'],
                'nama'                          => $r['nama'],
                'alamat'                        => $r['alamat'],
                'no_telp'                       => $r['no_telp'],
                'email'                         => $r['email'],
                'tahun_berdiri'                 => $r['tahun_berdiri'],
                'persen_kepemilikan'            => $r['persen_kepemilikan'],
                'bidang_usaha'                  => $r['bidang_usaha'],
                'nomor_perda_pendirian'         => $r['nomor_perda_pendirian'],
                'modal_dasar'                   => $r['modal_dasar'],
                'jumlah_komisaris'              => $r['jumlah_komisaris'],
                'jumlah_direksi'                => $r['jumlah_direksi'],
                'keterangan'                    => $r['keterangan'],
                'action'                        => '<button type="button" class="btn btn-xs btn-primary btnView" data-id="' . $this->encryption->encrypt($r['id_profil_bu']) . '" title="View data"><i class="fa fa-search"></i> </button>
											        <button type="button" class="btn btn-xs btn-orange btnEdit" data-id="' . $this->encryption->encrypt($r['id_profil_bu']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											        <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_profil_bu']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'
            );
            $index++;
        }
        $result = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->count_all_results('ta_produksi_sda'),
            "recordsFiltered" => $this->count_filtered($param),
            "data" => $data
        );

        return $result;
    }

    public function _get_datatables($param)
    {
        $this->_get_datatables_query($param);

        // Dont know
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filtered($param)
    {

        $this->_get_datatables_query($param);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function _get_datatables_query($param)
    {
        $post = array();
        if (is_array($param)) {
            foreach ($param as $v) {
                $post[$v['name']] = $v['value'];
            }
        }

        // Query Filter
        $this->db->select('
                            p.id_profil_bu,
                            p.id_bentuk_bu,
                            c.id_jenis_bu,
                            b.nama as bentuk_bu,
                            c.nama as jenis_bu,
                            p.nama,
                            p.alamat,
                            p.no_telp,
                            p.email,
                            p.tahun_berdiri,
                            p.persen_kepemilikan,
                            p.bidang_usaha,
                            p.nomor_perda_pendirian,
                            p.modal_dasar,
                            p.jumlah_komisaris,
                            p.jumlah_direksi,
                            p.keterangan
							');
        $this->db->from('ma_profil_bu p');
        $this->db->join('ref_bentuk_bu b', 'p.id_bentuk_bu = b.id_bentuk_bu', 'left');
        $this->db->join('ref_jenis_bu c', 'p.id_jenis_bu = c.id_jenis_bu', 'left');
        $this->db->where('p.id_jenis_bu', '2');

        if (isset($post['id_bentuk_bu_filter']) and $post['id_bentuk_bu_filter'] != '') {
            $this->db->where('b.id_bentuk_bu', $post['id_bentuk_bu_filter']);
        }

        if (isset($post['id_jenis_bu_filter']) and $post['id_jenis_bu_filter'] != '') {
            $this->db->where('c.id_jenis_bu', $post['id_jenis_bu_filter']);
        }

        $column_search = array('b.nama', 'c.nama', 'p.nama', 'p.alamat', 'p.no_telp', 'p.email', 'p.tahun_berdiri', 'p.persen_kepemilikan', 'p.bidang_usaha');

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
            $result['message'] = 'Data Profil BLUD Berhasil Disimpan';
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
                $result['message'] = 'Data Profil BLUD Berhasil diupdate';
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
