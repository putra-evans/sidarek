<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_komoditas_penyumbang extends CI_Model
{
    protected $_publishDate = "";
    public function __construct()
    {
        parent::__construct();
    }

    public function validasiDataValue($role)
    {
        $this->form_validation->set_rules('jenis_komoditas', 'Jenis Komoditas Penyumbang', 'required');
        $this->form_validation->set_rules('namakomoditas', 'Nama Komoditas Penyumbang', 'required');

        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    /**
     * Get List Bidang
     */
    public function getListJenis()
    {
        $query = $this->db->get("ref_jenis_komoditas_penyumbang");
        $data = [];
        $data[''] = '-- Semua Jenis --';
        foreach ($query->result() as $key => $value) {
            $data[$value->id_jenis_komoditas] = $value->jenis_komoditas;
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
                'id_komoditas_penyumbang'       => $r['id_komoditas_penyumbang'],
                'id_jenis_komoditas'            => $r['id_jenis_komoditas'],
                'jenis_komoditas'               => $r['jenis_komoditas'],
                'nama_komoditas_penyumbang'     => $r['nama_komoditas_penyumbang'],
                'action'                    => '<button type="button" class="btn btn-xs btn-primary btnEdit" data-id="' . $this->encryption->encrypt($r['id_komoditas_penyumbang']) . '" title="Edit data"><i class="fa fa-pencil"></i> </button>
                                            <button type="button" class="btn btn-xs btn-danger btnDelete" data-id="' . $this->encryption->encrypt($r['id_komoditas_penyumbang']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'
            );

            $index++;
        }

        $result = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->count_all_results('ta_inflasi'),
            "recordsFiltered" => $this->db->count_all_results('ta_inflasi'),
            "data" => $data,
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
                            a.id_komoditas_penyumbang,
                            a.nama_komoditas_penyumbang,
                            b.jenis_komoditas,
                            b.id_jenis_komoditas,
        ');
        $this->db->from('ref_komoditas_penyumbang a');
        $this->db->join('ref_jenis_komoditas_penyumbang b', 'a.id_jenis_komoditas = b.id_jenis_komoditas', 'left');
        $column_search = array('nama_komoditas_penyumbang');

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
                'id_jenis_komoditas'                    => $this->input->post('jenis_komoditas'),
                'nama_komoditas_penyumbang'             => $this->input->post('namakomoditas'),
            );

            $this->db->insert('ref_komoditas_penyumbang', $data);

            $result['success'] = 'YEAH';
            $result['status'] = true;
            $result['message'] = 'Data Komoditas Penyumbang Berhasil Disimpan';
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


            $id = $this->input->post('id_komoditas');
            $this->db->from('ref_komoditas_penyumbang', $id);
            $tampil   = $this->db->where('id_komoditas_penyumbang', $id);

            if ($tampil) {

                $data = array(
                    'id_jenis_komoditas'            => $this->input->post('jenis_komoditas'),
                    'nama_komoditas_penyumbang'     => $this->input->post('namakomoditas'),
                );

                $this->db->update('ref_komoditas_penyumbang', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data Komoditas Penyumbang Berhasil Disimpan';
            }
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function delete_data()
    {
        $id_komoditas_penyumbang     = $this->encryption->decrypt($this->input->post('id_komoditas_penyumbang', true));

        /*query delete*/
        $this->db->where('id_komoditas_penyumbang', $id_komoditas_penyumbang);
        $this->db->delete('ref_komoditas_penyumbang');
        return array('message' => 'SUCCESS');
    }
}
