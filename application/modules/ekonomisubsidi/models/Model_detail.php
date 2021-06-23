<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_detail extends CI_Model
{
    protected $_publishDate = "";
    public function __construct()
    {
        parent::__construct();
    }

    public function validasiDataValue($role)
    {

        $this->form_validation->set_rules('id_subsidi_realisasi_fordetail', 'Subsidi', 'required');


        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function process_datatables($param)
    {

        $draw = intval($this->input->get("draw"));

        $dataProduk = $this->_get_datatables($param);

        $data = [];
        $index = 1;
        foreach ($dataProduk as $r) {
            $data[] = array(
                'index'             => $index,
                'id_subsidi_kategori'         => $r['id_subsidi_kategori'],
                'kategori'         => $r['kategori'],
                'id_subsidi'     => $r['id_subsidi'],
                'subsidi'             => $r['subsidi'],
                'action'             => '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEdit" data-id="' . $this->encryption->encrypt($r['id_subsidi']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_subsidi']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

            );
            $index++;
        }

        $result = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->count_all_results('ma_produk_kebijakan'),
            "recordsFiltered" => $this->db->count_all_results('ma_produk_kebijakan'),
            "data" => $data
        );

        return $result;
    }

    public function _get_datatables($param)
    {
        $post = array();
        if (is_array($param)) {
            foreach ($param as $v) {
                $post[$v['name']] = $v['value'];
            }
        }

        // Query Filter
        $this->db->select('
							kategori.id_subsidi_kategori,
							kategori.nama as "kategori",
							subsidi.id_subsidi,
							subsidi.nama as "subsidi"
		');
        $this->db->from('ma_subsidi subsidi');
        $this->db->join('ref_subsidi_kategori kategori', 'subsidi.id_subsidi_kategori = kategori.id_subsidi_kategori', 'left');

        if (isset($post['subsidi']) and $post['subsidi'] != '') {
            $this->db->where('subsidi.nama', $post['subsidi']);
        }

        if (isset($post['kategori']) and $post['kategori'] != '') {
            $this->db->where('kategori.nama', $post['kategori']);
        }

        $column_search = array('kategori.nama', 'subsidi.nama');

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

        // Dont know
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_data()
    {
        $result = [
            'status' => false,
            'success' => 'NOPE',
            'message' => null,
            'info' => null
        ];

        try {

            $idSubsidiRealisasi = $this->input->post('id_subsidi_realisasi_fordetail');

            $details = $this->input->post('detail');
            $idsubsidiDetails = $this->input->post('id_subsidi_detail');

            $total_realisasi = 0;
            foreach ($details as $key => $value) {
                $id_subsidi_detail = $idsubsidiDetails[$key];
                $query = $this->db->query("select id_subsidi_detail from ta_subsidi_detail where id_subsidi_realisasi = $idSubsidiRealisasi and bulan = $key");

                $data = [
                    'id_subsidi_realisasi'  => $idSubsidiRealisasi,
                    'bulan'                 => $key,
                    'realisasi'             => $value
                ];

                if ($query->num_rows() > 0) {
                    $q = $this->db
                        ->where('id_subsidi_realisasi', $idSubsidiRealisasi)
                        ->where('bulan', $key)
                        ->update('ta_subsidi_detail', $data);
                } else {
                    $q = $this->db->insert('ta_subsidi_detail', $data);
                }
                $total_realisasi += $value;
            }

            // Update Total Realisasi
            $q = $this->db
                ->from('ta_subsidi_realisasi')
                ->where('id_subsidi_realisasi', $idSubsidiRealisasi)
                ->get()->row();

            $persentase = round($total_realisasi / $q->alokasi * 100, 2);

            $dataTRealisasi = [
                'realisasi' => $total_realisasi,
                'persentase' => $persentase
            ];

            $this->db
                ->where('id_subsidi_realisasi', $idSubsidiRealisasi)
                ->update('ta_subsidi_realisasi', $dataTRealisasi);


            $result['success'] = 'YEAH';
            $result['status'] = true;
            $result['message'] = 'Data Subsidi Berhasil Disimpan';
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function update_data()
    {

        $result = [
            'status' => false,
            'success' => 'NOPE',
            'message' => null,
            'info' => null
        ];

        try {

            $idSubsidi = $this->input->post('id_subsidi');
            $subsidi   = $this->db->where('id_subsidi', $idSubsidi);

            if ($subsidi) {

                $data = array(
                    'id_subsidi_kategori'            => $this->input->post('id_subsidi_kategori'),
                    'nama'                            => $this->input->post('nama'),
                );

                $this->db->update('ma_subsidi', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data Ekonomi Subsidi Berhasil Diubah';
            }
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function delete_data()
    {
        $subsidiId     = $this->encryption->decrypt($this->input->post('id_subsidi', true));

        /*query delete*/
        $this->db->where('id_subsidi', $subsidiId);
        $this->db->delete('ma_subsidi');

        return array('message' => 'SUCCESS');
    }

    public function uploadfile()
    {
        $config['upload_path']             = './assets/files/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';

        $this->load->library('upload', $config);

        $this->upload->do_upload('file_to_upload');
        $file_data = $this->upload->data();
        $data = $file_data['file_name'];
        return $data;
    }
}
