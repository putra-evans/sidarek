<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_komoditas extends CI_Model
{
    protected $_publishDate = "";
    public function __construct()
    {
        parent::__construct();
    }

    public function validasiDataValue($role)
    {

        $this->form_validation->set_rules('id_komoditas_for_jenis', 'Nama Komoditas', 'required');


        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    // public function check_row()
    // {
    //     $id_komoditas_jenis = $this->input->post('id_komoditas_jenis');
    //     $minggu_tahun = $this->input->post('minggu_tahun');

    //     $this->db->from('ta_komoditas_harga');
    //     $this->db->where('id_komoditas', $id_komoditas);
    //     $this->db->where('id_komoditas_jenis', $id_komoditas_jenis);
    //     $this->db->where('minggu_tahun', $minggu_tahun);
    //     $query = $this->db->get();
    //     $num = $query->num_rows();

    //     // if ($num > 0) {
    //     // 	return FALSE;
    //     // } else {
    //     // 	return TRUE;
    //     // }
    // }

    public function process_datatables($param, $id_komoditas_for_jenis, $id_kategori_for_jenis)
    {
        $draw = intval($this->input->get("draw"));

        $result = $this->_get_datatables($param, $id_komoditas_for_jenis, $id_kategori_for_jenis);

        $data = [];
        $index = $_POST['start'] + 1;
        foreach ($result['data'] as $r) {
            $data[] = array(
                'index'                         => $index,
                'id_komoditas_jenis'             => $r['id_komoditas_jenis'],
                'id_komoditas'                     => $r['id_komoditas'],
                'id_komoditas_kategori'         => $r['id_komoditas_kategori'],
                'nama'                            => $r['nama'],
                'satuan'                         => $r['satuan'],
                'nama_komoditas'                 => $r['nama_komoditas'],
                'nama_kategori'                 => $r['nama_kategori'],
                'action'                         => '<button type="button" class="btn btn-xs btn-orange btn-status-warning btnEditJenis" data-id="' . $this->encryption->encrypt($r['id_komoditas_jenis']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
											<button type="button" class="btn btn-xs btn-danger btn-status-danger btnDeleteJenis" data-id="' . $this->encryption->encrypt($r['id_komoditas_jenis']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'

            );
            $index++;
        }

        $result = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->count_all_results('ma_komoditas_jenis'),
            "recordsFiltered" => $this->count_filtered($param, $id_komoditas_for_jenis, $id_kategori_for_jenis),
            "data" => $data
        );

        return $result;
    }

    public function _get_datatables_query($param, $id_komoditas_for_jenis, $id_kategori_for_jenis)
    {

        $post = array();
        if (is_array($param)) {
            foreach ($param as $v) {
                $post[$v['name']] = $v['value'];
            }
        }

        // Query Filter
        $this->db->select('
							jenis.id_komoditas_jenis,					
							jenis.id_komoditas,
							jenis.id_komoditas_kategori,
							jenis.nama,
							jenis.satuan,
							komoditas.nama as "nama_komoditas",
							kategori.nama as "nama_kategori"
		');
        $this->db->from('ma_komoditas_jenis jenis');
        $this->db->join('ref_komoditas 			komoditas', 'komoditas.id_komoditas = jenis.id_komoditas', 'left');
        $this->db->join('ma_komoditas_kategori 	kategori', 'kategori.id_komoditas_kategori = jenis.id_komoditas_kategori', 'left');
        $this->db->where('komoditas.id_komoditas', $id_komoditas_for_jenis);

        if ($id_kategori_for_jenis)
            $this->db->where('kategori.id_komoditas_kategori', $id_kategori_for_jenis);

        $column_search = array('komoditas.nama', 'jenis.nama', 'kategori.nama');

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

    public function _get_datatables($param, $id_komoditas_for_jenis, $id_kategori_for_jenis)
    {

        $this->_get_datatables_query($param, $id_komoditas_for_jenis, $id_kategori_for_jenis);

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $query = $this->db->get();

        return [
            'data' => $query->result_array(),
            'num_rows' => $query->num_rows()
        ];
    }

    public function count_filtered($param, $id_komoditas_for_jenis, $id_kategori_for_jenis)
    {
        $this->_get_datatables_query($param, $id_komoditas_for_jenis, $id_kategori_for_jenis);
        $query = $this->db->get();
        return $query->num_rows();
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

            $data = array(
                'id_komoditas'                => $this->input->post('id_komoditas_for_jenis'),
                'id_komoditas_kategori'        => $this->input->post('id_kategori_for_jenis'),
                'nama'                        => $this->input->post('nama_jenis'),
                'satuan'                    => $this->input->post('satuan')
            );

            $this->db->insert('ma_komoditas_jenis', $data);

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

            $idPass = $this->input->post('id_komoditas_jenis');
            $passed   = $this->db->where('id_komoditas_jenis', $idPass);

            if ($passed) {

                $data = array(
                    'id_komoditas'                => $this->input->post('id_komoditas_for_jenis'),
                    'id_komoditas_kategori'        => $this->input->post('id_kategori_for_jenis'),
                    'nama'                        => $this->input->post('nama_jenis'),
                    'satuan'                    => $this->input->post('satuan')
                );

                $this->db->update('ma_komoditas_jenis', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data Berhasil Diubah';
            }
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function delete_data()
    {
        $itemID     = $this->encryption->decrypt($this->input->post('id_komoditas_jenis', true));

        /*query delete*/
        $this->db->where('id_komoditas_jenis', $itemID);
        $this->db->delete('ma_komoditas_jenis');

        return array('message' => 'SUCCESS');
    }
}
