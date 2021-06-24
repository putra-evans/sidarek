<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_bahanpokok extends CI_Model
{
    protected $_publishDate = "";
    public function __construct()
    {
        parent::__construct();
    }

    public function validasiDataValue($role)
    {
        $this->form_validation->set_rules('nama_komoditas', 'Nama Komoditas', 'required');

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
        $index = $_POST['start'] + 1;
        $komoditas_options = '<option value="">-- Semua Komoditas --</option>';
        $kategori_options = '<option value="">-- Semua Kategori --</option>';

        foreach ($dataProduk as $r) {
            $data[] = array(
                'index'                     => $index,
                'id_komoditas'              => $r['id_komoditas'],
                'nama_komoditas'            => $r['nama_komoditas'],
                'id_komoditas_kategori'     => $r['id_komoditas_kategori'],
                'nama_kategori'             => $r['nama_kategori'],
                'action'                    => '<button type="button" class="btn btn-xs btn-orange btnEdit" data-id="' . $this->encryption->encrypt($r['id_komoditas']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
                                            <button type="button" class="btn btn-xs btn-success btnLook" data-id="' . $this->encryption->encrypt($r['id_komoditas']) . '" title="Look Commodity">Lihat Jenis </button>'
            );

            $index++;

            $komoditas_options .= "<option value=" . $r['id_komoditas'] . ">" . $r['nama_komoditas'] . "</option>";
            $kategori_options .= "<option value=" . $r['id_komoditas_kategori'] . ">" . $r['nama_kategori'] . "</option>";
        }

        $result = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->count_all_results('ref_komoditas'),
            "recordsFiltered" => $this->db->count_all_results('ref_komoditas'),
            "data" => $data,
            "komoditas_options" => $komoditas_options,
            "kategori_options" => $kategori_options,
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

        $this->db->select('
                            komoditas.id_komoditas, 
                            komoditas.nama AS "nama_komoditas",
                            kategori.id_komoditas_kategori,
                            kategori.nama AS "nama_kategori"
        ');
        $this->db->from('ref_komoditas komoditas');
        $this->db->join('ma_komoditas_kategori 	kategori', 'kategori.id_komoditas = komoditas.id_komoditas', 'left');

        if (isset($post['id_komoditas']) and $post['id_komoditas'] != '') {
            $this->db->where('komoditas.id_komoditas', $post['id_komoditas']);
        }

        $column_search = array('komoditas.nama', 'kategori.nama');

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

            $data = array(
                'nama'            => $this->input->post('nama_komoditas'),
            );

            $this->db->insert('ref_komoditas', $data);
            $id_komoditas = $this->db->insert_id();

            if ($this->input->post('nama_kategori')) {
                $data = array(
                    'id_komoditas'              => $this->input->post('id_komoditas'),
                    'nama'                      => $this->input->post('nama_kategori'),
                );
                $this->db->insert('ma_komoditas_kategori', $data);
            }

            $result['success'] = 'YEAH';
            $result['status'] = true;
            $result['message'] = 'Data komoditas Berhasil Disimpan';
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

            $idkomoditas = $this->input->post('id_komoditas');
            $produk   = $this->db->where('id_komoditas', $idkomoditas);

            if ($produk) {

                $data = array(
                    'nama'            => $this->input->post('nama_komoditas'),
                );
                $this->db->update('ref_komoditas', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data komoditas Berhasil Disimpan';
            }

            $idKategori = $this->input->post('id_komoditas_kategori');
            $kategori = $this->db->where('id_komoditas_kategori', $idKategori);

            if ($kategori) {

                $data = array(
                    'nama'            => $this->input->post('nama_kategori'),
                );

                $this->db->update('ma_komoditas_kategori', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data komoditas Berhasil Disimpan';
            }
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function delete_data()
    {
        $idKomoditas     = $this->encryption->decrypt($this->input->post('id_komoditas', true));
        $idKategori     = $this->encryption->decrypt($this->input->post('id_komoditas_kategori', true));


        /*query delete*/
        $this->db->where('id_komoditas', $idKomoditas);
        $this->db->where('id_komoditas_kategori', $idKategori);
        $this->db->delete('ma_komoditas_kategori');

        $this->db->where('id_komoditas', $idKomoditas);
        $this->db->delete('ref_komoditas');

        return array('message' => 'SUCCESS');
    }
}
