<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of model otg
 *
 * @author Yuda Pramana
 */

class Model_inflasi extends CI_Model
{
    protected $_publishDate = "";
    public function __construct()
    {
        parent::__construct();
    }

    public function validasiDataValue($role)
    {
        $this->form_validation->set_rules('id_tipe_inflasi', 'Tipe inflasi', 'required');
        $this->form_validation->set_rules('id_daerah_inflasi', 'Daerah inflasi', 'required');

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
        foreach ($dataProduk as $r) {
            $data[] = array(
                'index'                     => $index,
                'id_inflasi'                => $r['id_inflasi'],
                'id_tipe_inflasi'           => $r['id_tipe_inflasi'],
                'id_daerah_inflasi'         => $r['id_daerah_inflasi'],
                'tahun_inflasi'             => $r['tahun_inflasi'],
                'nama_tipe'                 => $r['nama_tipe'],
                'nama_daerah'               => $r['nama_daerah'],
                'action'                    => '<button type="button" class="btn btn-xs btn-primary btnDetail" data-id="' . $this->encryption->encrypt($r['id_inflasi']) . '" title="Edit data"><i class="fa fa-gear"></i> </button>
                                            <button type="button" class="btn btn-xs btn-danger btnDelete" data-idmodalpertahun="' . $this->encryption->encrypt($r['id_inflasi']) . '" title="Delete data"><i class="fa fa-times"></i> </button>'
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
                            inflasi.id_inflasi, 
                            inflasi.id_tipe_inflasi,
                            inflasi.id_daerah_inflasi,
                            inflasi.tahun_inflasi,
                            tipe.nama as "nama_tipe",
                            daerah.nama as "nama_daerah"
        ');
        $this->db->from('ta_inflasi inflasi');
        $this->db->join('ref_tipe_inflasi 	    tipe',   'tipe.id_tipe_inflasi = inflasi.id_tipe_inflasi', 'left');
        $this->db->join('ref_daerah_inflasi 	daerah', 'daerah.id_daerah_inflasi = inflasi.id_daerah_inflasi', 'left');
        $this->db->group_by('id_tipe_inflasi, id_daerah_inflasi', 'asc');

        if (isset($post['tahun_filter']) and $post['tahun_filter'] != '') {
            $this->db->where('inflasi.tahun_inflasi', $post['tahun_filter']);
        }

        $column_search = array('tipe.nama', 'daerah.nama');

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
                'id_tipe_inflasi'                    => $this->input->post('id_tipe_inflasi'),
                'id_daerah_inflasi'                    => $this->input->post('id_daerah_inflasi'),
                'tahun_inflasi'                        => $this->input->post('tahun_inflasi'),
            );

            $this->db->insert('ta_inflasi', $data);

            $result['success'] = 'YEAH';
            $result['status'] = true;
            $result['message'] = 'Data inflasi Berhasil Disimpan';
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


            $idPassed = $this->input->post('id_inflasi');
            $this->db->from('ta_inflasi', $idPassed);
            $passed   = $this->db->where('id_inflasi', $idPassed);

            if ($passed) {

                $data = array(
                    'id_tipe_inflasi'                    => $this->input->post('id_tipe_inflasi'),
                    'id_daerah_inflasi'                    => $this->input->post('id_daerah_inflasi'),
                    'tahun_inflasi'                        => $this->input->post('tahun_inflasi'),
                );

                $this->db->update('ta_inflasi', $data);

                $result['success'] = 'YEAH';
                $result['status'] = true;
                $result['message'] = 'Data Produk Kebijakan Berhasil Disimpan';
            }
        } catch (\Exception $e) {
            $result['info'] = $e->getMessage();
        }

        return $result;
    }

    public function delete_data()
    {
        $item     = $this->encryption->decrypt($this->input->post('id_inflasi', true));

        /*query delete*/
        $this->db->where('id_inflasi', $item);
        $this->db->delete('ta_inflasi');
        return array('message' => 'SUCCESS');
    }

    public function input_data()
    {
        $pk = $this->input->post('pk');


        if (isset($pk['idinflasidetail'])) {
            $this->db->where('id_inflasi_detail', $pk['idinflasidetail']);
            $data = array('persen_inflasi' => $this->input->post('value'));
            $this->db->update('ta_inflasi_detail', $data);
        } else {
            $data = array(
                'id_inflasi'                => $pk['idinflasi'],
                'bulan_inflasi'             => $pk['bulan'],
                'persen_inflasi'            => $this->input->post('value')
            );

            $this->db->insert('ta_inflasi_detail', $data);
        }

        return array('message' => 'SUCCESS');
    }
}
